<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'subscription_packages_id',
        'name',
        'stripe_plan',
        'amount',
        'quantity',
        'start_at',
        'end_at',
        'trial_ends_at',
        'status',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'trial_ends_at' => 'datetime',
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function subscriptionPakage()
    {
        return $this->belongsTo(SubscriptionPackage::class, 'subscription_packages_id');
    }

    // attach instructor to subscription
    public function newSubscription($instructor, $name, $plan, $quantity = 1)
    {
        $subscription = $instructor->subscriptions()->create([
            'name' => $name,
            'stripe_plan' => $plan,
            'quantity' => $quantity,
        ]);

        return $subscription;
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'instructor_id');
    }

}
