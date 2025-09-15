<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'instructor_id',
        'module_id',
        'title',
        'slug',
        'video_link',
        'video_type',
        'thumbnail',
        'short_description',
        'reorder',
        'status',
        'type',
        'is_public',
        // Live lesson fields
        'live_start_time',
        'live_duration_minutes',
        'zoom_meeting_id',
        'zoom_join_url',
        'zoom_password',
    ];

    public function courseActivities()
    {
        return $this->hasMany(CourseActivity::class);
    }

    public function courseLogs()
    {
        return $this->hasMany(CourseLog::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    protected $casts = [
        'live_start_time' => 'datetime',
    ];

    // Live lesson helper methods
    public function isLive()
    {
        if ($this->type !== 'live' || !$this->live_start_time) {
            return false;
        }

        $now = now();
        $endTime = $this->live_start_time->addMinutes($this->live_duration_minutes);
        
        return $now->greaterThanOrEqualTo($this->live_start_time) && 
               $now->lessThanOrEqualTo($endTime);
    }

    public function isUpcoming()
    {
        if ($this->type !== 'live' || !$this->live_start_time) {
            return false;
        }

        return $this->live_start_time->greaterThan(now());
    }

    public function isExpired()
    {
        if ($this->type !== 'live' || !$this->live_start_time) {
            return false;
        }

        $endTime = $this->live_start_time->addMinutes($this->live_duration_minutes);
        return now()->greaterThan($endTime);
    }

    public function getTimeUntilStartAttribute()
    {
        if (!$this->isUpcoming()) {
            return null;
        }

        $diff = now()->diff($this->live_start_time);
        
        if ($diff->days > 0) {
            return $diff->days . ' দিন বাকি';
        } elseif ($diff->h > 0) {
            return $diff->h . ' ঘন্টা ' . $diff->i . ' মিনিট বাকি';
        } else {
            return $diff->i . ' মিনিট বাকি';
        }
    }

    public function getLiveDurationHumanAttribute()
    {
        if (!$this->live_duration_minutes) {
            return null;
        }

        $hours = floor($this->live_duration_minutes / 60);
        $minutes = $this->live_duration_minutes % 60;
        
        $duration = '';
        if ($hours > 0) {
            $duration .= $hours . ' ঘন্টা ';
        }
        if ($minutes > 0) {
            $duration .= $minutes . ' মিনিট';
        }
        
        return trim($duration);
    }

    public function getLiveStartTimeBanglaAttribute()
    {
        if (!$this->live_start_time) {
            return null;
        }
        
        return $this->live_start_time->format('d/m/Y, h:i A');
    }

    // Check if user attended this live lesson
    public function hasAttended($userId)
    {
        return $this->courseActivities()
                   ->where('student_id', $userId)
                   ->where('lesson_id', $this->id)
                   ->exists();
    }

    // Mark user as attended
    public function markAttended($userId)
    {
        if (!$this->hasAttended($userId)) {
            $this->courseActivities()->create([
                'student_id' => $userId,
                'course_id' => $this->course_id,
                'lesson_id' => $this->id,
                'instructor_id' => $this->instructor_id,
                'created_at' => now()
            ]);
        }
    }
}
