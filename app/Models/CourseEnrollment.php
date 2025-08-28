<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseEnrollment extends Model
{
    use HasFactory;

    protected $table = 'course_user';

    protected $fillable = [
        'course_id',
        'user_id',
        'instructor_id',
        'payment_method',
        'transaction_id',
        'amount',
        'original_amount',
        'promo_code',
        'promo_discount',
        'status',
        'paid',
        'start_at',
        'end_at',
        'payment_screenshot',
        'admin_notes',
        'rejection_reason'
    ];

    protected $casts = [
        'paid' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    const STATUS_PAYMENT_PENDING = 'payment_pending';  // Student hasn't paid yet
    const STATUS_PENDING = 'pending';                  // Student paid, waiting approval
    const STATUS_APPROVED = 'approved';                // Instructor approved
    const STATUS_REJECTED = 'rejected';

    const PAYMENT_METHODS = [
        'bkash' => 'bKash',
        'nogod' => 'Nogod',
        'rocket' => 'Rocket',
        'cash' => 'Cash Payment',
        'free_access' => 'Free Access'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function scopePaymentPending($query)
    {
        return $query->where('status', self::STATUS_PAYMENT_PENDING);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }
}
