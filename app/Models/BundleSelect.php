<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourseReview; 

class BundleSelect extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'instructor_id',
        'slug',
        'price',
        'offer_price',
        'thumbnail',
        'short_description',
    ];

    public function reviews(){
        return $this->hasMany(CourseReview::class,'course_id','course_id');
    }

}
