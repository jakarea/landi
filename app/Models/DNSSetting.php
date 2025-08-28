<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DNSSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'instructor_id',
        'domain',
        'verify_by',
        'verify_token'
    ];
}
