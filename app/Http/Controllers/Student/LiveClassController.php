<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveClassController extends Controller
{
    public function index()
    {
        // Get all enrolled course IDs for the student
        $enrolledCourseIds = CourseEnrollment::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->pluck('course_id')
            ->toArray();

        // Get live classes for enrolled courses
        $liveClasses = LiveClass::with(['course', 'instructor'])
            ->whereIn('course_id', $enrolledCourseIds)
            ->where('start_time', '>=', now()->subHours(6)) // Show classes from 6 hours ago
            ->orderBy('start_time', 'asc')
            ->get();

        // Group by upcoming, live, and recent
        $upcomingClasses = $liveClasses->filter(function ($class) {
            return $class->is_upcoming;
        });

        $liveClasses = $liveClasses->filter(function ($class) {
            return $class->is_live;
        });

        $recentClasses = $liveClasses->filter(function ($class) {
            return $class->is_ended && $class->start_time->greaterThan(now()->subHours(6));
        });

        return view('student.live-classes.index', compact(
            'upcomingClasses', 
            'liveClasses', 
            'recentClasses'
        ));
    }

    public function forCourse($courseId)
    {
        // Verify student is enrolled in this course
        $enrollment = CourseEnrollment::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.courses.show', $courseId)
                           ->with('error', 'আপনি এই কোর্সে ভর্তি নন');
        }

        $course = Course::with('instructor')->findOrFail($courseId);
        
        $liveClasses = LiveClass::with('instructor')
            ->where('course_id', $courseId)
            ->where('start_time', '>=', now()->subHours(6))
            ->orderBy('start_time', 'asc')
            ->get();

        return view('student.live-classes.course', compact('course', 'liveClasses'));
    }

    public function show(LiveClass $liveClass)
    {
        // Check if student can view this class
        if (!$liveClass->canJoin(Auth::id())) {
            return redirect()->route('student.live-classes.index')
                           ->with('error', 'আপনি এই ক্লাসে অংশগ্রহণ করতে পারবেন না');
        }

        $liveClass->load(['course', 'instructor']);
        
        return view('student.live-classes.show', compact('liveClass'));
    }

    public function join(LiveClass $liveClass)
    {
        // Check if student can join this class
        if (!$liveClass->canJoin(Auth::id())) {
            return back()->with('error', 'আপনি এই ক্লাসে অংশগ্রহণ করতে পারবেন না');
        }

        if (!$liveClass->zoom_join_url) {
            return back()->with('error', 'Zoom লিংক পাওয়া যাচ্ছে না');
        }

        // Check if class is live or about to start (within 10 minutes)
        if ($liveClass->is_live || $liveClass->start_time->diffInMinutes(now(), false) <= 10) {
            return redirect($liveClass->zoom_join_url);
        }

        return back()->with('error', 'ক্লাস এখনও শুরু হয়নি। ক্লাস শুরুর ১০ মিনিট আগে যোগ দিতে পারবেন।');
    }

    public function getUpcoming()
    {
        // API endpoint for upcoming classes (for AJAX requests)
        $enrolledCourseIds = CourseEnrollment::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->pluck('course_id')
            ->toArray();

        $upcomingClasses = LiveClass::with(['course', 'instructor'])
            ->whereIn('course_id', $enrolledCourseIds)
            ->upcoming()
            ->limit(5)
            ->orderBy('start_time', 'asc')
            ->get()
            ->map(function ($class) {
                return [
                    'id' => $class->id,
                    'title' => $class->title,
                    'course_title' => $class->course->title,
                    'instructor_name' => $class->instructor->name,
                    'start_time' => $class->start_time_bangla,
                    'time_until_start' => $class->time_until_start,
                    'duration' => $class->duration_human,
                    'is_live' => $class->is_live,
                    'can_join' => $class->canJoin(Auth::id()),
                    'join_url' => route('student.live-classes.join', $class->id)
                ];
            });

        return response()->json($upcomingClasses);
    }

    public function getLive()
    {
        // API endpoint for live classes (for AJAX requests)
        $enrolledCourseIds = CourseEnrollment::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->pluck('course_id')
            ->toArray();

        $liveClasses = LiveClass::with(['course', 'instructor'])
            ->whereIn('course_id', $enrolledCourseIds)
            ->live()
            ->orderBy('start_time', 'asc')
            ->get()
            ->map(function ($class) {
                return [
                    'id' => $class->id,
                    'title' => $class->title,
                    'course_title' => $class->course->title,
                    'instructor_name' => $class->instructor->name,
                    'start_time' => $class->start_time_bangla,
                    'duration' => $class->duration_human,
                    'is_live' => true,
                    'can_join' => $class->canJoin(Auth::id()),
                    'join_url' => route('student.live-classes.join', $class->id)
                ];
            });

        return response()->json($liveClasses);
    }
}