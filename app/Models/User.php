<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Subscription;
use App\Models\VimeoData;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'user_role',
        'short_bio',
        'email_verified_at',
        'phone',
        'avatar',
        'social_links',
        'company_name',
        'description',
        'recivingMessage',
        'password',
        'last_activity_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * subscription
     */
    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'instructor_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'user_id');
    }

    /**
     * vimeo_data
     */
    public function vimeo_data()
    {
        return $this->hasOne(VimeoData::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class, 'admin_id');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'instructor_id');
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class, 'user_id');
    }

}
