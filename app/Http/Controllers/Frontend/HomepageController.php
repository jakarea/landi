<?php

namespace App\Http\Controllers\Frontend;

use Auth;
use App\Models\Cart;
use App\Models\User;
use App\Models\PageSection;
use App\Models\Course;
use App\Models\BundleCourse;
use App\Models\Checkout;
use App\Models\CourseReview;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;

class HomepageController extends Controller
{
    /**
     * Display the homepage with latest 6 courses
     *
     * @return \Illuminate\Http\Response
     */
    public function homepage()
    {
        // Get latest 6 published courses
        $latestCourses = Course::where('status', 'published')
                             ->with(['user', 'modules.lessons'])
                             ->orderBy('created_at', 'desc')
                             ->limit(6)
                             ->get();

        // Calculate course statistics
        foreach ($latestCourses as $course) {
            // Calculate total duration
            $totalDurationSeconds = 0;
            $totalLessons = 0;
            
            foreach ($course->modules->where('status', 'published') as $module) {
                foreach ($module->lessons->where('status', 'published') as $lesson) {
                    $totalLessons++;
                    if (isset($lesson->duration) && is_numeric($lesson->duration) && $lesson->duration > 0) {
                        $totalDurationSeconds += $lesson->duration;
                    }
                }
            }
            
            // Convert duration from seconds to hours and minutes
            $course->total_hours = floor($totalDurationSeconds / 3600);
            $course->total_minutes = floor(($totalDurationSeconds % 3600) / 60);
            
            // If total time is still 0 but we have lessons, set a minimum time
            if ($course->total_hours == 0 && $course->total_minutes == 0 && $totalLessons > 0) {
                $course->total_minutes = $totalLessons * 5; // 5 minutes per lesson estimate
                $course->total_hours = floor($course->total_minutes / 60);
                $course->total_minutes = $course->total_minutes % 60;
            }
            $course->total_lessons = $totalLessons;
            $course->total_modules = $course->modules->where('status', 'published')->count();
            
            // Get enrollment count
            $course->enrolled_count = Checkout::where('course_id', $course->id)->count();
            
            // Get average rating
            $reviews = CourseReview::where('course_id', $course->id)->get();
            $course->average_rating = $reviews->count() > 0 ? $reviews->avg('star') : 0;
            $course->review_count = $reviews->count();
        }

        $sections = PageSection::where('pageName','home')->get();
        
        // Get active reviews ordered by display_order
        $reviews = Review::where('is_active', true)
                        ->orderBy('display_order', 'asc')
                        ->get();

        return view('welcome', compact('latestCourses','sections', 'reviews'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all user who are instructor use auth service provider

        return view('instructor/admin/chart');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function courseDetails($slug)
    {
        $course = Course::where('slug', $slug)->with('modules.lessons')->firstOrFail();
        $promo_video_link = '';
        if ($course->promo_video != '') {
            $ytarray = explode("/", $course->promo_video);
            $ytendstring = end($ytarray);
            $ytendarray = explode("?v=", $ytendstring);
            $ytendstring = end($ytendarray);
            $ytendarray = explode("&", $ytendstring);
            $ytcode = $ytendarray[0];
            $promo_video_link = $ytcode;
        }

        $course_reviews = CourseReview::where('course_id', $course->id)->get();
        $courseEnrolledNumber = Checkout::where('course_id', $course->id)->count();

        $userIdentifier = isset($_COOKIE['userIdentifier']) ? $_COOKIE['userIdentifier'] : null;

        $cartCourses = Cart::where(function ($query) use ($userIdentifier) {
            if (auth()->id()) {
                $query->where('user_id', auth()->id());
            } else {
                $query->Where('user_identifier', $userIdentifier);
            }
        })->get();

        $related_course = [];
        if ($course) {
            if($course->categories){
                $categoryArray = explode(',', $course->categories);

                $related_course = Course::where('instructor_id', $course->instructor_id)
                ->where('status','published')
                ->where('id', '!=', $course->id)
                ->where(function ($query) use ($categoryArray) {
                    foreach ($categoryArray as $category) {
                        $query->orWhere('categories', 'like', '%' . trim($category) . '%');
                    }
                })
                ->take(4)
                ->get();
            }


            return view('frontend.course-details', compact('course', 'promo_video_link', 'course_reviews', 'related_course', 'courseEnrolledNumber','cartCourses'));
        } else {
            return redirect('/')->with('error', 'Course not found!');
        }
    }


    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $instructors = User::where('user_role', 'instructor')->where('id', $id)->first();
        $courses = Course::where('user_id', $id)->get();
        return view('frontend.course', compact('instructors', 'courses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // login as instructor
    public function loginAsInstructor($userSessionId, $userId, $insId)
    {

        if (!$userId || !$userSessionId) {
            return redirect('/login')->with('error', 'Failed to Login as Instructor');
        }

        $adminUserId = Crypt::decrypt($userId);
        $adminUser = User::find($adminUserId);

        if (!$adminUser) {
            return redirect('/login')->with('error', 'Failed to Login as Instructor');
        }

        $reqSessionId = Crypt::decrypt($userSessionId);
        $dbSessionId = Crypt::decrypt($adminUser->session_id);

        $keysToForget = ['userId', 'userRole'];

        foreach ($keysToForget as $key) {
            if (session()->has($key)) {
                session()->forget($key);
            }
        }
        session(['userId' => encrypt($adminUser->id), 'userRole' => $adminUser->user_role]);

        if ($reqSessionId === $dbSessionId && $insId) {
            $instructorUserId = Crypt::decrypt($insId);
            $instructorUser = User::find($instructorUserId);

            if ($instructorUser) {
                Auth::login($instructorUser);

                return redirect('instructor/dashboard')->with('success', 'You have successfully logged into the profile of ' . $instructorUser->name);
            }
        }

        return redirect('/login')->with('error', 'Failed to Login as Instructor');
    }

    // login as student
    public function loginAsStudent($userSessionId, $userId, $stuId)
    {
        if (!$userId || !$userSessionId) {
            return redirect('/login')->with('error', 'Failed to Login as Student');
        }

        $adminUserId = Crypt::decrypt($userId);
        $adminUser = User::find($adminUserId);

        if (!$adminUser) {
            return redirect('/login')->with('error', 'Failed to Login as Student');
        }

        $reqSessionId = Crypt::decrypt($userSessionId);
        $dbSessionId = Crypt::decrypt($adminUser->session_id);

        $keysToForget = ['userId', 'userRole'];

        foreach ($keysToForget as $key) {
            if (session()->has($key)) {
                session()->forget($key);
            }
        }
        session(['userId' => encrypt($adminUser->id), 'userRole' => $adminUser->user_role]);

        if ($reqSessionId === $dbSessionId && $stuId) {
            $studentUserId = Crypt::decrypt($stuId);
            $studentUser = User::find($studentUserId);

            if ($studentUser) {
                Auth::login($studentUser);

                return redirect('student/')->with('success', 'You have successfully logged into the profile of ' . $studentUser->name);
            }
        }

        return redirect('/login')->with('error', 'Failed to Login as Student');
    }

    // ========================================
    // NEW CLEAN URL STRUCTURE METHODS
    // ========================================

    /**
     * About page - /about/
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Contact page - /contact/
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Help & Support page - /help/
     */
    public function help()
    {
        return view('pages.help');
    }
}
