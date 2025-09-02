<?php

namespace App\Models;

use Auth;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checkout extends Model
{
    use HasFactory;

    protected $table = 'course_user';

    protected $fillable = [
        'user_id',
        'course_id',
        'instructor_id',
        'payment_method',
        'payment_status',
        'payment_id',
        'transaction_id',
        'sender_number',
        'notes',
        'payment_date',
        'is_manual',
        'payment_details',
        'status',
        'amount',
        'start_date',
        'end_date',
    ];
    
    protected $casts = [
        'payment_details' => 'array',
        'payment_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Public boot function
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = auth()->user()->id;
        });
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function instructor()
    {
        return $this->belongsTo(User::class,'instructor_id','id');
    }

    public function getUserByCourseID($course_id)
    {
        return Checkout::where('course_id', $course_id)->pluck('user_id')->toArray();
    }

    public function getUserByCheckoutID($checkout_id)
    {
        return Checkout::where('id', $checkout_id)->pluck('user_id')->toArray();
    }

    public function getCheckoutByCourseID($course_id)
    {
        return Checkout::where('course_id', $course_id)->get();
    }

    public static function courseEnrolledByInstructor()
    {
        return Checkout::whereHas('course', function ($query) {
            $query->where('user_id', auth()->user()->id);
        });
    }
    public function getCheckoutByInstructorID()
    {
        return Checkout::where('instructor_id', Auth::user()->id)->select('id','instructor_id','course_id','user_id')->get()->unique('user_id');
    }

    // public function subscriptionPackage()
    // {
    //     return $this->hasOne(SubscriptionPackage::class,'instructor_id','id');
    // }

    // Scopes
    public function scopeManualPayments($query)
    {
        return $query->where('is_manual', true);
    }
    
    public function scopeByPaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }
    
    public function scopeCompletedPayments($query)
    {
        return $query->whereIn('payment_status', ['completed', 'Paid']);
    }
    
    // Helper methods
    public function isManualPayment()
    {
        return $this->is_manual;
    }
    
    public function isBkashPayment()
    {
        return $this->payment_method === 'bkash';
    }
    
    public function isNogodPayment()
    {
        return $this->payment_method === 'nogod';
    }
    
    public function isRocketPayment()
    {
        return $this->payment_method === 'rocket';
    }
    
    public function getPaymentMethodNameAttribute()
    {
        $methods = [
            'bkash' => 'বিকাশ',
            'nogod' => 'নগদ', 
            'rocket' => 'রকেট',
            'manual' => 'ম্যানুয়াল',
        ];
        
        return $methods[$this->payment_method] ?? $this->payment_method;
    }
    
    // get student payment by course user id is equal to auth user id and course id is equal to course id
    
}
