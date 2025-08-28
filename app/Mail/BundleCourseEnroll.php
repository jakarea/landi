<?php

namespace App\Mail;
use App\Models\BundleCourse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BundleCourseEnroll extends Mailable
{
    use Queueable, SerializesModels;

    public $course;

    public function __construct(BundleCourse $course)
    {
        $this->course = $course;
    }

    public function build()
    {
        return $this->markdown('emails.course.enroll')
            ->subject('Course Enrollment Success')
            ->with('course', $this->course); 
    }
}