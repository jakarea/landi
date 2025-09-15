<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LiveClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'instructor_id',
        'course_id',
        'course_name',
        'start_time',
        'duration_minutes',
        'zoom_meeting_id',
        'zoom_start_url',
        'zoom_join_url',
        'zoom_password',
        'status',
        'zoom_response'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'zoom_response' => 'array'
    ];

    // Relationships
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Scopes
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>', now())
                    ->where('status', 'scheduled');
    }

    public function scopeForInstructor($query, $instructorId)
    {
        return $query->where('instructor_id', $instructorId);
    }

    public function scopeForCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }

    // Accessors & Mutators
    public function getEndTimeAttribute()
    {
        return $this->start_time->addMinutes($this->duration_minutes);
    }

    public function getIsLiveAttribute()
    {
        $now = now();
        return $now->greaterThanOrEqualTo($this->start_time) && 
               $now->lessThanOrEqualTo($this->end_time);
    }

    public function getIsUpcomingAttribute()
    {
        return $this->start_time->greaterThan(now());
    }

    public function getIsEndedAttribute()
    {
        return now()->greaterThan($this->end_time);
    }

    public function getStartTimeHumanAttribute()
    {
        return $this->start_time->format('d M Y, h:i A');
    }

    public function getStartTimeBanglaAttribute()
    {
        return $this->start_time->format('d/m/Y, h:i A');
    }

    public function getDurationHumanAttribute()
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        $duration = '';
        if ($hours > 0) {
            $duration .= $hours . ' ঘন্টা ';
        }
        if ($minutes > 0) {
            $duration .= $minutes . ' মিনিট';
        }
        
        return trim($duration);
    }

    public function getTimeUntilStartAttribute()
    {
        if (!$this->is_upcoming) {
            return null;
        }

        $diff = now()->diff($this->start_time);
        
        if ($diff->days > 0) {
            return $diff->days . ' দিন বাকি';
        } elseif ($diff->h > 0) {
            return $diff->h . ' ঘন্টা ' . $diff->i . ' মিনিট বাকি';
        } else {
            return $diff->i . ' মিনিট বাকি';
        }
    }

    public function getStatusBanglaAttribute()
    {
        return match($this->status) {
            'scheduled' => 'নির্ধারিত',
            'live' => 'লাইভ',
            'ended' => 'শেষ',
            'cancelled' => 'বাতিল',
            default => 'অজানা'
        };
    }

    // Methods
    public function canJoin($userId = null)
    {
        if (!$userId) {
            return false;
        }

        // Check if user is enrolled in the course
        $isEnrolled = CourseEnrollment::where('course_id', $this->course_id)
                                    ->where('user_id', $userId)
                                    ->where('status', 'approved')
                                    ->exists();

        return $isEnrolled && ($this->is_live || $this->is_upcoming);
    }

    public function canStart($userId = null)
    {
        return $userId && $userId == $this->instructor_id && 
               ($this->is_live || $this->is_upcoming);
    }

    public function updateStatus()
    {
        if ($this->is_live && $this->status !== 'live') {
            $this->update(['status' => 'live']);
        } elseif ($this->is_ended && $this->status !== 'ended') {
            $this->update(['status' => 'ended']);
        }
    }
}