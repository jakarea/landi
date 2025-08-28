<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'instructor_id',
        'applicable_courses',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active'
    ];

    protected $casts = [
        'applicable_courses' => 'array',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'coupon_courses');
    }

    public function isValid()
    {
        return $this->is_active 
            && now()->between($this->valid_from, $this->valid_until)
            && $this->used_count < $this->usage_limit;
    }

    public function isApplicableToCourse($courseId)
    {
        if (empty($this->applicable_courses)) {
            return true;
        }
        
        return in_array($courseId, $this->applicable_courses);
    }

    public function calculateDiscount($amount)
    {
        if ($this->type === 'percentage') {
            return $amount * ($this->value / 100);
        }
        
        return min($this->value, $amount);
    }

    public static function generateCode($length = 8)
    {
        do {
            $code = strtoupper(Str::random($length));
        } while (self::where('code', $code)->exists());
        
        return $code;
    }

    public function markAsUsed()
    {
        $this->increment('used_count');
    }

    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function canBeUsedByUser($userId, $courseId)
    {
        return !$this->usages()
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->exists();
    }
}
