<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class course_like extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'instructor_id',
        'user_id',
        'status'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
