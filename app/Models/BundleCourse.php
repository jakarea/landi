<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Checkout;

class BundleCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',   
        'title',   
        'sub_title',   
        'slug',  
        'selected_course', 
        'regular_price', 
        'sales_price', 
        'thumbnail', 
        'description'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'id', 'course_id');
    }

    // In Course model
    public function checkouts()
    {
        return $this->hasMany(Checkout::class, 'course_id', 'id');
    }
}
