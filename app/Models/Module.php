<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'instructor_id',
        'title',
        'slug',
        'reorder',
        'status',
        'publish_at',
    ];
    
    protected $casts = [
        'publish_at' => 'datetime',
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function lessons(){
        return $this->hasMany(Lesson::class,'module_id','id');
    }

    public function courseActivities()
    {
        return $this->hasMany(CourseActivity::class);
    }

    public function isComplete()
    {
        $courseActivityCount = $this->courseActivities()->count();
        $publishedLessonCount = $this->lessons()->where('status', 'published')->count();

        return $courseActivityCount == $publishedLessonCount;
    }

    public function checkNumber() {
        if( $this->course && $this->course->numbershow ){
            return true;
        }
        return false;
    }
}
