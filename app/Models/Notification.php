<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id', 
        'course_id', 
        'user_id',  
        'message',  
        'status',
        'type' 
    ];
}
