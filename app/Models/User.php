<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Subscription;
use App\Models\UserSession;
use App\Models\VimeoData;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'facebook_pixel_id',
        'google_analytics_id',
        'google_tag_manager_id',
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
     * Avatar attributes
     */
    protected function avatarImg() : Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => asset($attributes['avatar']) 
                ? asset($attributes['avatar']) 
                : asset('assets/images/avatar.avif')
        );
    }

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

    public function sessions()
    {
        return $this->hasMany(UserSession::class, 'user_id');
    }

}
