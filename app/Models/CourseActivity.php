<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'instructor_id',
        'module_id',
        'lesson_id',
        'user_id',
        'is_completed',
        'duration'
    ];
}
