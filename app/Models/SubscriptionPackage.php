<?php

namespace App\Models;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'regular_price',
        'sales_price',
        'features',
        'status',
        'type',
        'created_by'
    ];

    // protected $casts = [
    //     'features' => 'array',
    // ];

    // /**
    //  * Public boot
    //  */
    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->created_by = auth()->user()->id;
    //     });

    //     static::updating(function ($model) {
    //         $model->created_by = auth()->user()->id;
    //     });
    // }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'name');
    }

    public function newSubscription($instructor, $name, $plan, $quantity = 1)
    {
        $subscription = $instructor->subscriptions()->create([
            'name' => $name,
            'stripe_plan' => $plan,
            'quantity' => $quantity,
        ]);

        return $subscription;
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
