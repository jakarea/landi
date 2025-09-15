<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LiveClassController extends Controller
{
    public function index()
    {
        $liveClasses = LiveClass::with('course')
            ->forInstructor(Auth::id())
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        return view('instructor.live-classes.index', compact('liveClasses'));
    }

    public function create()
    {
        $courses = Course::where('instructor_id', Auth::id())
                        ->where('status', 'active')
                        ->select('id', 'title')
                        ->get();

        return view('instructor.live-classes.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'course_id' => 'required|exists:courses,id',
            'start_time' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15|max:300',
            'zoom_meeting_id' => 'required|string|max:255',
            'zoom_join_url' => 'required|url|max:500',
            'zoom_password' => 'nullable|string|max:100'
        ], [
            'title.required' => 'ক্লাসের নাম প্রয়োজন',
            'course_id.required' => 'কোর্স নির্বাচন করুন',
            'course_id.exists' => 'বৈধ কোর্স নির্বাচন করুন',
            'start_time.required' => 'শুরুর সময় প্রয়োজন',
            'start_time.after' => 'ভবিষ্যতের সময় নির্বাচন করুন',
            'duration_minutes.required' => 'সময়কাল প্রয়োজন',
            'duration_minutes.min' => 'সর্বনিম্ন ১৫ মিনিট',
            'duration_minutes.max' => 'সর্বোচ্চ ৫ ঘন্টা',
            'zoom_meeting_id.required' => 'Zoom মিটিং ID প্রয়োজন',
            'zoom_join_url.required' => 'Zoom যোগদান লিঙ্ক প্রয়োজন',
            'zoom_join_url.url' => 'বৈধ URL দিন'
        ]);

        // Verify course belongs to instructor
        $course = Course::where('id', $request->course_id)
                       ->where('instructor_id', Auth::id())
                       ->firstOrFail();

        try {
            // Create live class record with manual Zoom data
            $liveClass = LiveClass::create([
                'title' => $request->title,
                'description' => $request->description,
                'instructor_id' => Auth::id(),
                'course_id' => $request->course_id,
                'start_time' => $request->start_time,
                'duration_minutes' => $request->duration_minutes,
                'zoom_meeting_id' => $request->zoom_meeting_id,
                'zoom_start_url' => $request->zoom_join_url, // Same as join URL for manual entry
                'zoom_join_url' => $request->zoom_join_url,
                'zoom_password' => $request->zoom_password,
                'zoom_response' => null // No API response for manual entry
            ]);

            return redirect()->route('instructor.live-classes.index')
                           ->with('success', 'লাইভ ক্লাস সফলভাবে তৈরি হয়েছে');

        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'লাইভ ক্লাস তৈরি করতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }

    public function show(LiveClass $liveClass)
    {
        $this->authorize('view', $liveClass);
        $liveClass->load('course');
        
        return view('instructor.live-classes.show', compact('liveClass'));
    }

    public function edit(LiveClass $liveClass)
    {
        $this->authorize('update', $liveClass);
        
        $courses = Course::where('instructor_id', Auth::id())
                        ->where('status', 'active')
                        ->select('id', 'title')
                        ->get();

        return view('instructor.live-classes.edit', compact('liveClass', 'courses'));
    }

    public function update(Request $request, LiveClass $liveClass)
    {
        $this->authorize('update', $liveClass);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'course_name' => 'nullable|string|max:255',
            'start_time' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15|max:300',
            'zoom_meeting_id' => 'required|string|max:255',
            'zoom_join_url' => 'required|url|max:500',
            'zoom_password' => 'nullable|string|max:100'
        ], [
            'title.required' => 'ক্লাসের নাম প্রয়োজন',
            'start_time.required' => 'শুরুর সময় প্রয়োজন',
            'start_time.after' => 'ভবিষ্যতের সময় নির্বাচন করুন',
            'duration_minutes.required' => 'সময়কাল প্রয়োজন',
            'zoom_meeting_id.required' => 'Zoom মিটিং ID প্রয়োজন',
            'zoom_join_url.required' => 'Zoom যোগদান লিঙ্ক প্রয়োজন',
            'zoom_join_url.url' => 'বৈধ URL দিন'
        ]);

        // Get first active course for instructor
        $course = Course::where('instructor_id', Auth::id())
                       ->where('status', 'active')
                       ->first();

        try {
            // Update live class with manual Zoom data
            $liveClass->update([
                'title' => $request->title,
                'description' => $request->description,
                'course_id' => $course ? $course->id : null,
                'course_name' => $request->course_name,
                'start_time' => $request->start_time,
                'duration_minutes' => $request->duration_minutes,
                'zoom_meeting_id' => $request->zoom_meeting_id,
                'zoom_start_url' => $request->zoom_join_url, // Same as join URL
                'zoom_join_url' => $request->zoom_join_url,
                'zoom_password' => $request->zoom_password,
                'zoom_response' => null // No API response for manual entry
            ]);

            return redirect()->route('instructor.live-classes.index')
                           ->with('success', 'লাইভ ক্লাস সফলভাবে আপডেট হয়েছে');

        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'লাইভ ক্লাস আপডেট করতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }

    public function destroy(LiveClass $liveClass)
    {
        $this->authorize('delete', $liveClass);

        try {
            // Delete Zoom meeting if exists
            if ($liveClass->zoom_meeting_id) {
                $this->deleteZoomMeeting($liveClass->zoom_meeting_id);
            }

            $liveClass->delete();

            return redirect()->route('instructor.live-classes.index')
                           ->with('success', 'লাইভ ক্লাস সফলভাবে মুছে ফেলা হয়েছে');

        } catch (\Exception $e) {
            return back()->with('error', 'লাইভ ক্লাস মুছতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }

    public function start(LiveClass $liveClass)
    {
        $this->authorize('start', $liveClass);

        if (!$liveClass->zoom_join_url) {
            return back()->with('error', 'Zoom লিংক পাওয়া যাচ্ছে না');
        }

        // Update status to live if it's time
        if ($liveClass->is_live || $liveClass->is_upcoming) {
            $liveClass->update(['status' => 'live']);
            return redirect($liveClass->zoom_join_url);
        }

        return back()->with('error', 'ক্লাস শুরু করার সময় হয়নি');
    }
}