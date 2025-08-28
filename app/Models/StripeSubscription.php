<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'stripe_id',
        'name',
        'stripe_plan',
        'quantity',
        'trial_ends_at',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
    ];
}
