<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'course_id',
        'certificate_clr',
        'accent_clr',
        'style',
        'logo',
        'signature',
    ];

    public function course()
    {
        return $this->hasOne(Course::class,'id','course_id');
    }

}
