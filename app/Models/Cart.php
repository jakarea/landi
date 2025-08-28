<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\User;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_identifier',
        'course_id',
        'bundle_course_id',
        'quantity',
        'price'
    ];

    public function courses()
    {
        return $this->belongsTo(Course::class,'course_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id', 'id');
    }
}
