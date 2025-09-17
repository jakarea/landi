<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Models\BundleCourse;
use App\Models\Cart;
use App\Models\Certificate;
use App\Models\Checkout;
use App\Models\Course;
use App\Models\course_like;
use App\Models\CourseActivity;
use App\Models\CourseEnrollment;
use App\Models\CourseLog;
use App\Models\CourseReview;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Notification;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\CarbonInterval;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class StudentHomeController extends Controller
{
    // dashboard
    public function dashboard(){

        $user = User::where('id', Auth::id())->first();
        $user->session_id = null;
        $user->save();

        if (isset($_COOKIE['userIdentifier'])) {
            $userIdentifier = $_COOKIE['userIdentifier'];
        } else {
            $userIdentifier = '';
        }


        Cart::where('user_identifier', $userIdentifier)
        ->update(['user_id' => Auth::id()]);

        // Optimized eager loading to prevent N+1 queries
        // Show approved courses (can access) and pending courses (paid but waiting approval)
        $enrolments = CourseEnrollment::with([
            'course' => function($query) {
                $query->select('id', 'title', 'slug', 'thumbnail', 'instructor_id', 'user_id')
                      ->with([
                          'modules' => function($moduleQuery) {
                              $moduleQuery->select('id', 'course_id', 'status')
                                         ->where('status', 'published')
                                         ->with(['lessons' => function($lessonQuery) {
                                             $lessonQuery->select('id', 'module_id', 'status')
                                                        ->where('status', 'published');
                                         }]);
                          }
                      ]);
            }
        ])
        ->where('user_id', Auth::user()->id)
        ->whereIn('status', [CourseEnrollment::STATUS_APPROVED, CourseEnrollment::STATUS_PENDING])
        ->orderBy('id', 'desc')
        ->paginate(12);

        $cartCount = Cart::where('user_id', auth()->id())->count();
        
        // Optimize liked courses with proper eager loading
        $likeCourses = course_like::with([
            'course' => function($query) {
                $query->select('id', 'title', 'slug', 'thumbnail', 'user_id', 'instructor_id');
            }
        ])
        ->where('user_id', Auth::user()->id)
        ->get();
        $totalTimeSpend = CourseActivity::where('user_id', Auth::user()->id)->where('is_completed',1)->sum('duration');

        $totalHours = floor($totalTimeSpend / 3600);
        $totalMinutes = floor(($totalTimeSpend % 3600) / 60);

        $timeSpentData = CourseActivity::select(
            'user_id',
            DB::raw('DATE_FORMAT(created_at, "%b") as month'),
            DB::raw('MONTH(created_at) as month_number'),
            DB::raw('SUM(duration) as time_spent')
        )
        ->groupBy('user_id', 'month', 'month_number')
        ->orderBy('user_id', 'asc')
        ->orderBy('month_number', 'asc')
        ->get();

        $currentMonthData = CourseActivity::selectRaw('SUM(duration) as total_duration')
        ->whereMonth('created_at', now()->month)
        ->first();

        $previousMonthData = CourseActivity::selectRaw('SUM(duration) as total_duration')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->first();

        if ($currentMonthData && $previousMonthData) {
            $currentMonthDuration = $currentMonthData->total_duration;
            $previousMonthDuration = $previousMonthData->total_duration;

            if ($previousMonthDuration != 0) {
                $percentageChange = (($currentMonthDuration - $previousMonthDuration) / $previousMonthDuration) * 100;
            } else {
                $percentageChange = 0;
            }
        } else {
            $percentageChange = 0;
        }

        // Get all user's completed lessons in one query for progress calculation
        $completedLessonsData = CourseActivity::where('user_id', Auth::id())
            ->where('is_completed', true)
            ->pluck('lesson_id', 'course_id')
            ->groupBy('course_id')
            ->map(function($lessons) {
                return $lessons->count();
            });

        //  count course statics using optimized progress calculation
        $notStartedCount = 0;
        $inProgressCount = 0;
        $completedCount = 0;

        if ($enrolments) {
            foreach ($enrolments as $enrolment) {
                if ($enrolment->course) {
                    // Calculate progress using already loaded data
                    $totalLessons = $enrolment->course->modules->sum(function($module) {
                        return $module->lessons->count();
                    });
                    
                    $completedLessonsCount = $completedLessonsData->get($enrolment->course->id, 0);
                    
                    $progress = 0;
                    if ($totalLessons > 0) {
                        $progress = ($completedLessonsCount / $totalLessons) * 100;
                    }

                    if ($progress == 0) {
                        $notStartedCount++;
                    } elseif ($progress > 0 && $progress < 99) {
                        $inProgressCount++;
                    } elseif ($progress >= 99) {
                        $completedCount++;
                    }
                }
            }
        }

        // Avr hr
        // $sum_of_duration = CourseActivity::selectRaw('SUM(duration) as total_duration')
        //                                     ->where(['user_id' => auth()->user()->id, 'is_completed' => 1])
        //                                     ->get();


        $sum_of_duration = CourseActivity::where('user_id', Auth::user()->id)->where('is_completed',1)->avg('duration');

        $total_hr = 0;
        $total_min = 0;
        $total_hr = floor($sum_of_duration / 3600);
        $total_min = floor(($sum_of_duration % 3600) / 60);
        // Enrolled
         $total_enrolled = DB::table('course_user')
                    ->where('user_id', auth()->user()->id)
                    ->where('status', CourseEnrollment::STATUS_APPROVED)
                    ->selectRaw('COUNT(DISTINCT course_id) as enrolled')
                    ->first();
        $enrolled = $total_enrolled->enrolled;

        // Optimize certificate courses - use already loaded enrollments
        $certificateCourses = $enrolments->getCollection()->pluck('course')->filter()->sortByDesc('id')->values();

        return view('e-learning/course/students/dashboard', compact('enrolments','total_hr','total_min','enrolled','likeCourses','totalTimeSpend','totalHours','totalMinutes','timeSpentData','percentageChange','notStartedCount','inProgressCount','completedCount','certificateCourses'));
    }

    // dashboard
    public function enrolled(Request $request){
        // Enhanced filtering with new request parameters
        $title = $request->get('title', '');
        $status = $request->get('status', '');
        $category = $request->get('category', '');
        $instructor = $request->get('instructor', '');
        $progress = $request->get('progress', '');

        // Optimized eager loading to prevent N+1 queries
        $enrolments = CourseEnrollment::with([
            'course' => function($query) {
                $query->select('id', 'title', 'slug', 'short_description', 'thumbnail', 'instructor_id', 'categories')
                      ->with([
                          'user:id,name,avatar',
                          'reviews:id,course_id,star,comment',
                          'modules' => function($moduleQuery) {
                              $moduleQuery->select('id', 'course_id', 'status')
                                         ->where('status', 'published')
                                         ->with(['lessons' => function($lessonQuery) {
                                             $lessonQuery->select('id', 'module_id', 'status')
                                                        ->where('status', 'published');
                                         }]);
                          }
                      ]);
            }
        ])
        ->where('user_id', Auth::id())
        ->whereIn('status', [CourseEnrollment::STATUS_APPROVED, CourseEnrollment::STATUS_PENDING]);

        $cartCount = Cart::where('user_id', auth()->id())->count();

        // Title search - search in both course title and description
        if (!empty($title)) {
            $enrolments->whereHas('course', function ($query) use ($title) {
                $query->where('title', 'LIKE', '%' . $title . '%')
                      ->orWhere('short_description', 'LIKE', '%' . $title . '%');
            });
        }

        // Category filter
        if (!empty($category)) {
            $enrolments->whereHas('course', function ($query) use ($category) {
                $query->where('categories', 'LIKE', '%' . $category . '%');
            });
        }

        // Instructor filter
        if (!empty($instructor)) {
            $enrolments->whereHas('course.user', function ($query) use ($instructor) {
                $query->where('name', 'LIKE', '%' . $instructor . '%');
            });
        }

        // Progress filter (based on CourseLog completion)
        if (!empty($progress)) {
            if ($progress == 'not_started') {
                $enrolments->whereDoesntHave('course.courseLogs', function ($query) {
                    $query->where('user_id', Auth::id());
                });
            } elseif ($progress == 'in_progress') {
                $enrolments->whereHas('course.courseLogs', function ($query) {
                    $query->where('user_id', Auth::id());
                })->whereHas('course', function ($query) {
                    // Has logs but not completed all lessons
                    $query->whereRaw('(SELECT COUNT(DISTINCT lesson_id) FROM course_logs WHERE course_logs.course_id = courses.id AND course_logs.user_id = ?) < (SELECT COUNT(*) FROM lessons WHERE lessons.course_id = courses.id)', [Auth::id()]);
                });
            } elseif ($progress == 'completed') {
                $enrolments->whereHas('course', function ($query) {
                    // All lessons completed
                    $query->whereRaw('(SELECT COUNT(DISTINCT lesson_id) FROM course_logs WHERE course_logs.course_id = courses.id AND course_logs.user_id = ?) = (SELECT COUNT(*) FROM lessons WHERE lessons.course_id = courses.id)', [Auth::id()]);
                });
            }
        }

        // Enhanced sorting with fixed table references
        if ($status) {
            if ($status == 'oldest') {
                $enrolments->orderBy('created_at', 'asc');
            } elseif ($status == 'best_rated') {
                $enrolments->join('courses', 'course_enrollments.course_id', '=', 'courses.id')
                    ->leftJoin('course_reviews', 'course_reviews.course_id', '=', 'courses.id')
                    ->select('course_enrollments.*')
                    ->selectRaw('AVG(course_reviews.star) as avg_rating')
                    ->groupBy('course_enrollments.id')
                    ->orderBy('avg_rating', 'desc');
            } elseif ($status == 'most_purchased') {
                $enrolments->join('courses', 'course_enrollments.course_id', '=', 'courses.id')
                    ->leftJoin('course_enrollments as ce2', 'ce2.course_id', '=', 'courses.id')
                    ->select('course_enrollments.*')
                    ->selectRaw('COUNT(ce2.course_id) as enrollment_count')
                    ->where('ce2.status', CourseEnrollment::STATUS_APPROVED)
                    ->groupBy('course_enrollments.course_id')
                    ->orderBy('enrollment_count', 'desc');
            } elseif ($status == 'newest') {
                $enrolments->orderBy('created_at', 'desc');
            } elseif ($status == 'recently_accessed') {
                $enrolments->leftJoin('course_logs', function ($join) {
                    $join->on('course_logs.course_id', '=', 'course_enrollments.course_id')
                         ->where('course_logs.user_id', Auth::id());
                })
                ->select('course_enrollments.*')
                ->selectRaw('MAX(course_logs.updated_at) as last_accessed')
                ->groupBy('course_enrollments.id')
                ->orderBy('last_accessed', 'desc');
            }
        } else {
            $enrolments->orderBy('created_at', 'desc');
        }

        $enrolments = $enrolments->paginate(12)->withQueryString();

        // Get all user's completed lessons for progress calculation
        $completedLessons = CourseActivity::where('user_id', Auth::id())
            ->where('is_completed', true)
            ->pluck('lesson_id', 'course_id')
            ->groupBy('course_id')
            ->map(function($lessons) {
                return $lessons->count();
            });

        // Calculate progress for each enrollment using already loaded data
        foreach ($enrolments as $enrolment) {
            if ($enrolment->course) {
                $totalLessons = $enrolment->course->modules->sum(function($module) {
                    return $module->lessons->count();
                });
                
                $completedCount = $completedLessons->get($enrolment->course->id, 0);
                
                $progress = 0;
                if ($totalLessons > 0) {
                    $progress = ($completedCount / $totalLessons) * 100;
                }
                
                $enrolment->course->progress = number_format($progress, 0);
            }
        }

        // Extract categories and instructors from already loaded data
        $availableCategories = $enrolments->getCollection()
            ->pluck('course.categories')
            ->filter()
            ->flatMap(function ($categories) {
                return explode(',', $categories);
            })
            ->map('trim')
            ->unique()
            ->sort()
            ->values();

        $availableInstructors = $enrolments->getCollection()
            ->pluck('course.user.name')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('e-learning/course/students/enrolled', compact(
            'enrolments', 
            'cartCount', 
            'availableCategories', 
            'availableInstructors'
        ));
    }

    // all course list
    public function index(){

        $title = isset($_GET['title']) ? $_GET['title'] : '';
        $cat = isset($_GET['cat']) ? $_GET['cat'] : '';
        $courses = Course::orderBy('id','desc');
        if(!empty($title)){
            $titles = explode( ' ', $title);
            $courses->where('title','like','%'.trim($titles[0]).'%');
            if(isset($titles[1])){
                $courses->where('title','like','%'.trim($titles[1]).'%');
            }
        }
        $courses = $courses->paginate(12);

        return view('e-learning/course/students/home',compact('courses'));
    }

    // catalog course list
    public function catalog(Request $request){
        // Show all published courses from all instructors
        $courses = Course::where('status','published')->with('user','reviews');

        $bundleCourse = BundleCourse::orderBy('id','desc')->get();
        $mainCategories = $courses->pluck('categories');

        $cat = isset($_GET['cat']) ? $_GET['cat'] : '';
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : '';

        if(!empty($title)){
            $titles = explode( ' ', $title);
            $courses->where('title','like','%'.trim($titles[0]).'%');
            $bundleCourse->where('title','like','%'.trim($titles[0]).'%');
            if(isset($titles[1])){
                $courses->where('title','like','%'.trim($titles[1]).'%');
                $bundleCourse->where('title','like','%'.trim($titles[1]).'%');
            }
        }

        if ($status == 'best_rated') {
            $courses = Course::leftJoin('course_reviews', 'courses.id', '=', 'course_reviews.course_id')
                ->select('courses.*', DB::raw('COALESCE(AVG(course_reviews.star), 0) as avg_star'))
                ->groupBy('courses.id')
                ->where('courses.user_id', $instructor->id)
                ->where('status','published')
                ->orderBy('avg_star', 'desc');

        }

        if ($status == 'most_purchased') {
            $courses = Course::leftJoin('checkouts', 'courses.id', '=', 'checkouts.course_id')
                ->select('courses.*')
                ->groupBy('courses.id')
                ->where('courses.user_id', $instructor->id)
                ->where('courses.status','published')
                ->orderBy(DB::raw('COUNT(checkouts.course_id)'), 'desc');

        }

        if ($status) {
            if ($status == 'oldest') {
                $courses->orderBy('id', 'asc');
            }

            if ($status == 'newest') {
                $courses->orderBy('id', 'desc');
            }
        }else{
            $courses->orderBy('id', 'desc');
        }

        if(!empty($cat)){
            $cats = explode( ' ', $cat);
            $courses->where('categories','like','%'.trim($cats[0]).'%');
            if(isset($cats[1])){
                $courses->where('cat','like','%'.trim($cats[1]).'%');
            }
        }
        $unique_array = [];
        foreach($mainCategories as $category){
            $cats = explode(",", $category);
            foreach($cats as $cat){
                $unique_array[] = strtolower($cat);
            }
        }
        $categories = array_unique($unique_array);
        $courses = $courses->paginate(12);

        $cartCourses = Cart::where('user_id', auth()->id())->get();

        return view('e-learning/course/students/catalog',compact('cartCourses','courses','categories', 'bundleCourse'));
    }

    // account Management
    public function accountManagement(){

        $userId = Auth()->user()->id;
        $user = User::find($userId);
        $checkout = Checkout::where('user_id', $userId)->with('course')->get();
        return view('settings/students/account-management',compact('user', 'checkout'));
    }

    // course show
    public function show($slug)
    {
        $course = Course::where('slug', $slug)->with('modules.lessons','user')->where('status','published')->first();
        if (!$course) {
            return redirect()->back()->with('error','No course found!');
        }

        // Check if user is enrolled in this course
        $enrollment = CourseEnrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->where('status', CourseEnrollment::STATUS_APPROVED)
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.courses')->with('error', 'You are not enrolled in this course or your enrollment is not approved yet.');
        }

        $lesson_files = Lesson::where('course_id',$course->id)
        ->where('status','published')
        ->select('lesson_file as file')->get();
        $group_files = [];

        foreach($lesson_files as $lesson_file){
            if(!empty($lesson_file->file)){
                $file_name = $lesson_file->file;
                $file_arr = explode('.', $lesson_file->file);
                $extention = $file_arr[1];
                if (!in_array($extention, $group_files)) {
                    $group_files[] = $extention;
                }
            }
        }

        //end group file
        if ($course && $course->categories) {
            $categoryArray = explode(',', $course->categories);
            $relatedCourses = Course::where('instructor_id', $course->instructor_id)
            ->where('status','published')
            ->where('id', '!=', $course->id)
            ->where(function ($query) use ($categoryArray) {
                foreach ($categoryArray as $category) {
                    $query->orWhere('categories', 'like', '%' . trim($category) . '%');
                }
            })
            ->take(3)
            ->get();
        }

        $course_reviews = CourseReview::where('course_id', $course->id)->with('user')->get();
        $course_like = course_like::where('course_id', $course->id)
                                  ->where('user_id', Auth::user()->id)
                                  ->where('instructor_id', $course->user_id)
                                  ->first();
        $liked = '';
        if ($course_like ) {
            $liked = 'active';
        }

        // Set enrollment status for view
        $isUserEnrolled = true; // User is enrolled since we checked this earlier
        
        // Get user's completed lessons for this course
        $userCompletedLessons = [];
        if (Auth::check()) {
            $completedLessons = CourseActivity::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->where('is_completed', true)
                ->pluck('lesson_id')
                ->toArray();
            $userCompletedLessons = array_flip($completedLessons);
            
        }
        
        // Get user's enrolled courses for related courses check
        $userEnrolledCourses = [];
        if (Auth::check()) {
            $enrolledCourseIds = CourseEnrollment::where('user_id', Auth::id())
                ->where('status', CourseEnrollment::STATUS_APPROVED)
                ->pluck('course_id')
                ->toArray();
            $userEnrolledCourses = array_flip($enrolledCourseIds);
        }
        
        // Get first lesson for the course
        $firstLesson = null;
        foreach ($course->modules->where('status', 'published') as $module) {
            $firstLessonInModule = $module->lessons->where('status', 'published')->first();
            if ($firstLessonInModule) {
                $firstLesson = $firstLessonInModule;
                break;
            }
        }
        
        // Calculate course metrics
        $totalModules = $course->modules->count();
        $totalLessons = $course->modules->map(function ($module) {
            return $module->lessons()->where('status', 'published')->count();
        })->sum();

        $totalCompleteLessons = CourseActivity::where('course_id', $course->id)
            ->where('user_id', Auth::id())
            ->whereNotNull('is_completed')
            ->count();
            
        $progress = 0;
        if($totalLessons && $totalCompleteLessons) {
            $progress = ($totalCompleteLessons / $totalLessons) * 100;
        }
        $progress = number_format($progress, 0);


        // Get the last lesson from course log to auto-load
         $courseLog = CourseLog::where('course_id', $course->id)
                                ->where('user_id', auth()->user()->id)
                                ->orderBy('updated_at', 'desc')
                                ->first();
         
         $currentLesson = null;
         $currentModule = null;
         $playUrl = null;

         if ($courseLog) {
             $currentLesson = Lesson::find($courseLog->lesson_id);
             if ($currentLesson) {
                 $currentModule = Module::find($currentLesson->module_id);
                 if ($currentLesson->type == 'video') {
                     $playUrl = $currentLesson->video_link;
                 } elseif($currentLesson->type == 'audio') {
                     $playUrl = $currentLesson->audio;
                 } elseif($currentLesson->type == 'text') {
                     $playUrl = $currentLesson->text;
                 }
             }
         }
         
         // If no course log found, use first lesson
         if (!$currentLesson) {
             $currentLesson = $firstLesson;
             if ($currentLesson) {
                 $currentModule = Module::find($currentLesson->module_id);
             }
         }



        if ($course) {
            return view('e-learning/course/students/show', compact('course','group_files','course_reviews','liked','course_like','totalLessons','totalModules','relatedCourses','currentLesson','currentModule','playUrl','isUserEnrolled','userCompletedLessons','userEnrolledCourses','firstLesson','progress'));
        } else {
            return redirect('students/dashboard')->with('error', 'Course not found!');
        }
    }

    public function fileDownload($course_id,$file_extension){

          $lesson_files = Lesson::where('course_id',$course_id)->select('lesson_file as file')->get();
            foreach($lesson_files as $lesson_file){
                if(!empty($lesson_file->file)){
                    $file_name = $lesson_file->file;
                    $file_arr = explode('.', $file_name);
                    $extension = $file_arr['1'];
                    if($file_extension == $extension){
                        $files[] = public_path($file_name);
                }
                }
            }
        $zip = new ZipArchive;
        $zipFileName = $file_extension.'_'.time().'.zip';
        $is_have_file = '';
        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file) {

                if(file_exists($file)){
                    $zip->addFile($file, basename($file));
                }else{
                   $is_have_file = 'There are no files in your storage!!!!';
                   break;
                }
            }
            if(!empty($is_have_file)){
                return redirect('students/courses')->with('error', $is_have_file);
            }
            $zip->close();

            // Set appropriate headers for the download
            header('Content-Type: application/zip');
            header("Content-Disposition: attachment; filename=" . $zipFileName);
            header('Content-Length: ' . filesize($zipFileName));
            header("Pragma: no-cache");
            header("Expires: 0");
            readfile($zipFileName);

            // Delete the zip file after download
            unlink($zipFileName);
            exit;
        } else {
            // Handle the case when the zip file could not be created
            echo 'Failed to create the zip file.';
        }
    }

    public function cousreDownloadPDF($course_id){
        $lesson_files = Lesson::where('course_id',$course_id)->select('lesson_file as file')->get();
        foreach($lesson_files as $lesson_file){
            $file_name = $lesson_file->file;
            $file_arr = explode('.', $lesson_file->file);
            $extention = $file_arr[1];
            if($extention == 'pdf'){
                $pdfFiles[] = $file_name;
           }
        }

        $zipFileName = 'PDF_'.time().'.zip';
        $zip = new ZipArchive;

        if ($zip->open(public_path('uploads/lessons/files/'.$zipFileName), ZipArchive::CREATE) === TRUE) {
            foreach ($pdfFiles as $file) {
                if (file_exists(public_path('uploads/lessons/files/'.$file))) {
                    $zip->addFile(public_path('uploads/lessons/files/'.$file), basename($file));
                }
            }
            $zip->close();
            return response()->download(public_path('uploads/lessons/files/'.$zipFileName))->deleteFileAfterSend(true);
        } else {
            // handle error here
        }
    }

    public function certificateDownload($slug)
    {
            $course = Course::where('slug', $slug)
            ->with('certificate')
            ->first();

            if (!$course) {
                return redirect()->back()->with('error','There is no certificate found for this Course');
            }

            $courseDate = CourseActivity::where('user_id', Auth::user()->id)
            ->where('is_completed', 1)
            ->orderBy('updated_at', 'desc')
            ->first();

            if (!$courseDate) {
                return redirect()->back()->with('error','There is no certificate found for this Course');
            }

            $certStyle = Certificate::where('instructor_id',$course->user_id)->where('course_id',$course->id)->first();

            if (!$certStyle) {
                $certificate_path = 'certificates/download/certificate1';
            }

            if ($certStyle) {
                if ($certStyle->style == 3) {
                    $certificate_path = 'certificates/download/certificate1';

                }elseif ($certStyle->style == 2) {
                    $certificate_path = 'certificates/download/certificate2';

                }elseif ($certStyle->style == 1) {
                    $certificate_path = 'certificates/download/certificate3';
                }else{
                    $certificate_path = 'certificates/download/certificate1';
                }
            }

            $signature = $certStyle ? $certStyle->signature : '';
            $logo = $certStyle ? $certStyle->logo : '';

            $pdf = PDF::loadView($certificate_path, ['course' => $course, 'courseDate' => $courseDate->updated_at , 'signature' => $signature, 'logo' => $logo]);

            return $pdf->download($course->title.'-certificate.pdf');

    }

    public function certificateView($slug)
    {
            $course = Course::where('slug', $slug)
            ->with('certificate')
            ->first();

            if (!$course) {
                return redirect()->back()->with('error','There is no certificate found for this Course');
            }

            $courseDate = CourseActivity::where('user_id', Auth::user()->id)
            ->where('is_completed', 1)
            ->orderBy('updated_at', 'desc')
            ->first();

            if (!$courseDate) {
                return redirect()->back()->with('error','There is no certificate found for this Course');
            }

            $certStyle = Certificate::where('instructor_id',$course->user_id)->first();

            if (!$certStyle) {
                $certificate_show_path = 'certificates/show/certificate1';
            }

            if ($certStyle) {
                if ($certStyle->style == 3) {
                    $certificate_show_path = 'certificates/show/certificate1';

                }elseif ($certStyle->style == 2) {
                    $certificate_show_path = 'certificates/show/certificate2';

                }elseif ($certStyle->style == 1) {
                    $certificate_show_path = 'certificates/show/certificate3';
                }else{
                    $certificate_show_path = 'certificates/show/certificate1';
                }
            }

            $signature = '';

            if (!empty($certStyle->signature)) {
                $signature = $certStyle->signature;
            }else{
                $signature = 'assets/images/certificate/one/signature.png';
            }
            return view($certificate_show_path, ['course' => $course, 'courseDate' => $courseDate->updated_at , 'signature' => $signature]);

    }

    // course overview
    public function overview($slug)
    {
        $course = Course::where('slug', $slug)->with('modules.lessons','user')->first();
        $promo_video_link = '';
        if($course->promo_video != ''){
            $ytarray=explode("/", $course->promo_video);
            $ytendstring=end($ytarray);
            $ytendarray=explode("?v=", $ytendstring);
            $ytendstring=end($ytendarray);
            $ytendarray=explode("&", $ytendstring);
            $ytcode=$ytendarray[0];
            $promo_video_link = $ytcode;
        }

        $cartCourses = Cart::where('user_id', auth()->id())->get();

        $course_reviews = CourseReview::where('course_id', $course->id)->with('user')->get();
        $course_like = course_like::where('course_id', $course->id)->where('user_id', Auth::user()->id)->first();

        $courseEnrolledNumber = Checkout::where('course_id',$course->id)->count();

        $liked = '';
        if ($course_like ) {
            $liked = 'active';
        }

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

            return view('e-learning/course/students/overview', compact('course','promo_video_link','course_reviews','related_course','cartCourses','liked','courseEnrolledNumber'));
        } else {
            return redirect('students/dashboard')->with('error', 'Course not found!');
        }
    }

      // my course details
    public function courseDetails($slug){
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access course details.');
        }

        $userId = Auth::id();
        
        // Create cache key for this course and user
        $cacheKey = "course_details_{$slug}_user_{$userId}";
        
        // Try to get from cache first (cache for 10 minutes)
        $courseData = cache()->remember($cacheKey, 600, function() use ($slug, $userId) {
            return Course::where('slug', $slug)
                ->with([
                    'user',
                    'modules' => function($query) {
                        $query->where('status', 'published')
                              ->with(['lessons' => function($lessonQuery) {
                                  $lessonQuery->where('status', 'published')
                                             ->select('id', 'module_id', 'title', 'type', 'video_link', 'audio', 'duration', 'status');
                              }]);
                    },
                    'reviews' => function($query) {
                        $query->with('user:id,name,avatar');
                    },
                    'enrollments' => function($query) {
                        $query->where('status', CourseEnrollment::STATUS_APPROVED);
                    }
                ])
                ->first();
        });
        
        $course = $courseData;
        
        if (!$course) {
            return redirect()->route('student.dashboard')->with('error', 'Course not found!');
        }

        // Check if user is enrolled in this course (using eager loaded data)
        $enrollment = $course->enrollments->where('user_id', $userId)->first();
        
        if (!$enrollment) {
            return redirect()->route('student.courses')->with('error', 'You are not enrolled in this course or your enrollment is not approved yet.');
        }

        // Get course statistics (using eager loaded data)
        $courseEnrolledNumber = $course->enrollments->count();

        // Get course reviews (using eager loaded data)
        $course_reviews = $course->reviews;
        $totalReviews = $course_reviews->count();

        // Get completed lessons for this user in a single query with caching
        $completedLessonsCacheKey = "user_{$userId}_course_{$course->id}_completed_lessons";
        $completedLessonIds = cache()->remember($completedLessonsCacheKey, 300, function() use ($course, $userId) {
            return CourseActivity::where([
                'course_id' => $course->id,
                'user_id' => $userId, 
                'is_completed' => 1
            ])->pluck('lesson_id')->toArray();
        });
        
        // Create a lookup array for completed lessons for O(1) access
        $completedLessonsLookup = array_flip($completedLessonIds);

        // Mark lessons as completed using the lookup array
        foreach ($course->modules as $module) {
            foreach ($module->lessons as $lesson) {
                $lesson->completed = isset($completedLessonsLookup[$lesson->id]) ? 1 : 0;
            }
        }
        
        // Cache user's enrollment status and completed lessons for helpers
        app()->instance('user_enrolled_courses', collect([$course->id]));
        app()->instance('user_completed_lessons', collect($completedLessonIds));
        
        // Prepare data for view to avoid multiple helper calls
        $isUserEnrolled = true; // We already verified enrollment above
        $userCompletedLessons = $completedLessonsLookup; // For quick lookup in blade
        $firstLesson = null;
        $currentLesson = null;
        $totalModules = $course->modules->count();
        $totalLessons = $course->modules->sum(function($module) {
            return $module->lessons->count();
        });
        
        // Get first lesson if exists
        foreach ($course->modules as $module) {
            if ($module->lessons->count() > 0) {
                $firstLesson = $module->lessons->first();
                break;
            }
        }
        
        // Set current lesson (you can modify this logic based on your needs)
        $currentLesson = $firstLesson;
        
        // Check if user likes this course
        $liked = \App\Models\course_like::where('course_id', $course->id)
            ->where('user_id', $userId)
            ->exists() ? 'active' : '';

        return view('e-learning/course/students/myCourse', compact(
            'course',
            'totalReviews',
            'courseEnrolledNumber',
            'course_reviews',
            'enrollment',
            'isUserEnrolled',
            'userCompletedLessons',
            'firstLesson',
            'currentLesson',
            'totalModules',
            'totalLessons',
            'liked'
        ));
    }

    public function storeCourseLog(Request $request)
    {
        $courseId = (int)$request->input('courseId');
        $lessonId = (int)$request->input('lessonId');
        $moduleId = (int)$request->input('moduleId');
        $userId = auth()->check() ? auth()->id() : 1;

        if (!$courseId || !$lessonId || !$moduleId) {
            return response()->json(['error' => 'Missing required parameters'], 400);
        }

        $course = Course::find($courseId);
        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        try {
            $existingRecord = CourseLog::where('course_id', $courseId)
                                     ->where('user_id', $userId)
                                     ->first();
            
            if ($existingRecord) {
                $existingRecord->update([
                    'instructor_id' => $course->user_id,
                    'module_id' => $moduleId,
                    'lesson_id' => $lessonId,
                ]);
            } else {
                CourseLog::create([
                    'course_id' => $courseId,
                    'user_id' => $userId,
                    'instructor_id' => $course->user_id,
                    'module_id' => $moduleId,
                    'lesson_id' => $lessonId,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Lesson logged successfully']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to log lesson'], 500);
        }
    }

    /**
     * Student activties lesson complete
     */
    public function storeActivity(Request $request)
    {
        $courseId = (int)$request->input('courseId');
        $lessonId = (int)$request->input('lessonId');
        $moduleId = (int)$request->input('moduleId');
        $duration = (int)$request->input('duration', 0);
        $instructorId = (int)$request->input('instructorId');
        $userId = (int)$request->input('userId');
        
        // If userId is not provided in request, try to get from auth
        if (!$userId && Auth::check()) {
            $userId = Auth::user()->id;
        }
        
        if (!$userId) {
            return response()->json(['error' => 'User ID is required'], 400);
        }


        if (!$courseId || !$lessonId || !$moduleId) {
            return response()->json(['error' => 'Missing required parameters'], 400);
        }

        $course = Course::find($courseId);
        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        if (!$instructorId) {
            $instructorId = $course->user_id;
        }

        try {
            $courseActivity = CourseActivity::updateOrCreate(
                [
                    'lesson_id' => $lessonId, 
                    'module_id' => $moduleId,
                    'user_id' => $userId
                ],
                [
                    'course_id' => $courseId,
                    'instructor_id' => $instructorId,
                    'is_completed' => true,
                    'duration' => $duration
                ]
            );

            CourseLog::updateOrCreate(
                [
                    'course_id' => $courseId,
                    'user_id' => $userId
                ],
                [
                    'instructor_id' => $instructorId,
                    'module_id' => $moduleId,
                    'lesson_id' => $lessonId,
                ]
            );

            cache()->forget("user_{$userId}_course_{$courseId}_completed_lessons");
            cache()->forget("course_details_{$course->slug}_user_{$userId}");

            return response()->json([
                'success' => true,
                'message' => 'Lesson completed successfully',
                'lesson_id' => $lessonId,
                'course_id' => $courseId,
                'module_id' => $moduleId
            ]);

        } catch (\Exception $e) {
            \Log::error('Course Activity Save Error: ' . $e->getMessage(), [
                'courseId' => $courseId,
                'lessonId' => $lessonId,
                'moduleId' => $moduleId,
                'userId' => $userId,
                'instructorId' => $instructorId
            ]);
            return response()->json(['error' => 'Failed to save activity: ' . $e->getMessage()], 500);
        }
    }

    public function activitiesList()
    {
        $userId = Auth::id();
        
        // Enable query logging for performance monitoring
        if (config('app.debug')) {
            DB::enableQueryLog();
        }
        
        // Cache all dashboard data together
        $dashboardData = Cache::remember("dashboard_data_user_{$userId}", 180, function() use ($userId) {
            // Get enrolled courses from multiple sources  
            $enrolledCourseIds = collect();
            
            // From CourseEnrollment model
            $courseEnrollments = CourseEnrollment::where('user_id', $userId)
                ->where('status', 'approved')
                ->pluck('course_id');
            $enrolledCourseIds = $enrolledCourseIds->merge($courseEnrollments);
            
            // From Checkout model
            $checkoutEnrollments = Checkout::where('user_id', $userId)
                ->whereNotNull('course_id')
                ->pluck('course_id');
            $enrolledCourseIds = $enrolledCourseIds->merge($checkoutEnrollments);
            
            // Remove duplicates
            $enrolledCourseIds = $enrolledCourseIds->unique();
            
            // Get all course activities for this user in one query
            $allUserActivities = CourseActivity::where('user_id', $userId)
                ->select('course_id', 'lesson_id', 'is_completed', 'duration', 'created_at')
                ->get()
                ->groupBy('course_id');
            
            // Get all activity stats in one query
            $activityStats = CourseActivity::where('user_id', $userId)
                ->where('is_completed', 1)
                ->selectRaw('COUNT(*) as lessons_completed, SUM(duration) as time_spent')
                ->first();
            
            return [
                'enrolledCourseIds' => $enrolledCourseIds,
                'allUserActivities' => $allUserActivities,
                'activityStats' => $activityStats
            ];
        });
        
        $enrolledCourseIds = $dashboardData['enrolledCourseIds'];
        $allUserActivities = $dashboardData['allUserActivities'];
        $activityStats = $dashboardData['activityStats'];
        
        // Get courses with optimized eager loading
        $courseActivities = Course::whereIn('id', $enrolledCourseIds)
            ->with([
                'modules' => function($query) {
                    $query->where('status', 'published')
                          ->with(['lessons' => function($lessonQuery) {
                              $lessonQuery->where('status', 'published')
                                          ->select('id', 'module_id', 'course_id', 'status');
                          }]);
                }
            ])
            ->select('id', 'title', 'slug', 'user_id')
            ->orderby('id', 'desc')
            ->paginate(12);
        
        // Calculate activity statistics efficiently
        $totalEnrolledCourses = $enrolledCourseIds->count();
        $completedCourses = 0;
        $inProgressCourses = 0;
        $notStartedCourses = 0;
        $totalLessons = 0;
        
        // Get chart data from cache
        $chartData = Cache::remember("chart_data_user_{$userId}", 300, function() use ($userId) {
            // Monthly progress data for chart
            $monthlyProgressData = CourseActivity::where('user_id', $userId)
                ->where('is_completed', 1)
                ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as completed_lessons, SUM(duration) as total_duration')
                ->groupBy('month', 'year')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();
            
            // Weekly activity data for line chart (last 8 weeks)
            $weeklyActivityData = CourseActivity::where('user_id', $userId)
                ->where('is_completed', 1)
                ->where('created_at', '>=', now()->subWeeks(8))
                ->selectRaw('WEEK(created_at) as week, YEAR(created_at) as year, COUNT(*) as lessons_count, SUM(duration) as duration')
                ->groupBy('week', 'year')
                ->orderBy('year', 'asc')
                ->orderBy('week', 'asc')
                ->get();
                
            return [
                'monthlyProgressData' => $monthlyProgressData,
                'weeklyActivityData' => $weeklyActivityData
            ];
        });
        
        // Course completion data calculation - optimized
        $courseCompletionData = [];
        foreach ($courseActivities as $course) {
            // Calculate total lessons for this course efficiently
            $courseLessons = $course->modules->sum(function($module) {
                return $module->lessons->count(); // Already filtered in eager loading
            });
            $totalLessons += $courseLessons;
            
            // Calculate progress efficiently using pre-loaded data
            $courseActivitiesData = $allUserActivities->get($course->id, collect());
            $completedLessons = $courseActivitiesData->where('is_completed', 1)->count();
            $progress = $courseLessons > 0 ? round(($completedLessons / $courseLessons) * 100, 2) : 0;
            
            if ($progress >= 100) {
                $completedCourses++;
            } elseif ($progress > 0) {
                $inProgressCourses++;
            } else {
                $notStartedCourses++;
            }
            
            $courseCompletionData[] = [
                'course_name' => $course->title,
                'progress' => $progress,
                'total_lessons' => $courseLessons
            ];
        }
        
        // Use cached activity stats
        $totalLessonsCompleted = $activityStats->lessons_completed ?? 0;
        $totalTimeSpent = $activityStats->time_spent ?? 0;
        
        // Convert time to hours and minutes
        $totalHours = floor($totalTimeSpent / 3600);
        $totalMinutes = floor(($totalTimeSpent % 3600) / 60);
        
        // Extract chart data from cache
        $monthlyProgressData = $chartData['monthlyProgressData'];
        $weeklyActivityData = $chartData['weeklyActivityData'];

        // Get top popular courses with static caching (user-specific data added after)
        $topCourses = Cache::remember('popular_courses_base_v3', 600, function() {
            return Course::with(['user'])
                ->where('status', 'approved')
                ->withCount(['checkouts as total_enrollments' => function($query) {
                    $query->whereNotNull('course_id');
                }])
                ->orderBy('total_enrollments', 'desc')
                ->limit(5)
                ->get();
        });
        
        // Add user-specific data efficiently
        $courseIds = $topCourses->pluck('id');
        $userEnrollments = CourseEnrollment::where('user_id', $userId)
            ->whereIn('course_id', $courseIds)
            ->select('course_id', 'status')
            ->get()
            ->keyBy('course_id');
        
        $allCourses = $topCourses->map(function ($course) use ($enrolledCourseIds, $userEnrollments, $allUserActivities) {
            $isEnrolled = $enrolledCourseIds->contains($course->id);
            $enrollment = $userEnrollments->get($course->id);
            
            // Calculate progress efficiently using pre-loaded data
            $progress = 0;
            if ($isEnrolled && $allUserActivities->has($course->id)) {
                $courseActivitiesData = $allUserActivities->get($course->id);
                $completedCount = $courseActivitiesData->where('is_completed', 1)->count();
                // Simple progress calculation - can be enhanced if needed
                $progress = min($completedCount * 10, 100); // Rough estimate
            }
            
            $course->is_enrolled = $isEnrolled;
            $course->enrollment_status = $enrollment ? $enrollment->status : null;
            $course->progress = $progress;
            
            return $course;
        });
        
        // Log query count for performance monitoring
        if (config('app.debug')) {
            $queries = DB::getQueryLog();
        }
        
        return view('e-learning/course/students/activity', compact(
            'courseActivities',
            'totalEnrolledCourses',
            'completedCourses', 
            'inProgressCourses',
            'notStartedCourses',
            'totalTimeSpent',
            'totalHours',
            'totalMinutes',
            'totalLessonsCompleted',
            'totalLessons',
            'monthlyProgressData',
            'courseCompletionData',
            'weeklyActivityData',
            'allCourses'
        ));
    }

    public function review(Request $request, $slug){
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $userId = Auth::user()->id;
        $lessons = Lesson::orderby('id', 'desc')->paginate(10);
        $modules = Module::orderby('id', 'desc')->paginate(10);
        $course = Course::where('slug', $slug)->with('user')->first();
        
        if (!$course) {
            return redirect()->back()->with('error', 'Course not found!');
        }
        
        $course_reviews = CourseReview::where('course_id', $course->id)->where('user_id',$userId)->first();
        if($course_reviews){
            $course_reviews->comment = $request->comment;
            $course_reviews->star = $request->star;
            $course_reviews->save();
        }else{
            $review = new CourseReview([
                'user_id'   => $userId,
                'course_id' => $course->id,
                'instructor_id' => $course->user_id,
                'star'      => $request->star,
                'comment'   => $request->comment,
            ]);
            $review->save();

            // set notification for instructor
                $notify = new Notification([
                    'user_id'   => Auth::user()->id,
                    'instructor_id' => $course->user_id,
                    'course_id' => $course->id,
                    'type'      => 'instructor',
                    'message'   => "review",
                    'status'   => 'unseen',
                ]);
                $notify->save();
        }

        return redirect()->route('student.courses.learn', ['slug' => $slug] )->with('message', 'comment submitted successfully!');
    }

    public function certificate()
    {
        $myCoursesList = Checkout::where('user_id', Auth()->id())->get();
        $certificateCourses = Course::whereIn('id',$myCoursesList->pluck('course_id'))->orderby('id', 'desc')->paginate(12);
        return view('e-learning/course/students/certifiate',compact('certificateCourses'));
    }

    public function message()
    {
        return view('e-learning/course/students/message-2');
    }

    public function courseLike($course_id, $ins_id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        
        // Check if the current user has liked this course
        $course_liked = course_like::where('course_id', $course_id)
                                  ->where('instructor_id', $ins_id)
                                  ->where('user_id', $user->id)
                                  ->first();

        if ($course_liked) {
             $course_liked->delete();
             $status = 'unliked';
        }else{
            $course_like = new course_like([
                'course_id' => $course_id,
                'instructor_id' => $ins_id,
                'user_id' => $user->id,
                'status' => 1,
            ]);
            $course_like->save();

            $status = 'liked';
        }

        return response()->json(['message' => $status]);
    }

    public function courseUnLike($course_id, $ins_id)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }
        
        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'User not authenticated');
        }
        
        // Check if the current user has liked this course
        $course_liked = course_like::where('course_id', $course_id)
                                  ->where('instructor_id', $ins_id)
                                  ->where('user_id', $user->id)
                                  ->first();

        if ($course_liked) {
             $course_liked->delete();
             $status = 'unliked';
        }

        return redirect()->back()->with('success', 'Course Unlike Successfully Done!');
    }

    /**
     * Modern Student Dashboard (New Design)
     */
    public function modernDashboard()
    {
        $user = User::where('id', Auth::id())->first();
        $user->session_id = null;
        $user->save();

        // Get enrolled courses with progress tracking
        $enrolments = Checkout::with('course')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(12);
        
        // Calculate total watch time
        $totalTimeSpend = CourseActivity::where('user_id', Auth::user()->id)->where('is_completed', 1)->sum('duration');
        $totalHours = floor($totalTimeSpend / 3600);
        $totalMinutes = floor(($totalTimeSpend % 3600) / 60);

        // Course completion statistics
        $notStartedCount = 0;
        $inProgressCount = 0;
        $completedCount = 0;

        if ($enrolments) {
            foreach ($enrolments as $enrolment) {
                if ($enrolment->course) {
                    $allCourses = StudentActitviesProgress(auth()->user()->id, $enrolment->course->id);
                    if ($allCourses == 0) {
                        $notStartedCount++;
                    } elseif ($allCourses > 0 && $allCourses < 99) {
                        $inProgressCount++;
                    } elseif ($allCourses == 100) {
                        $completedCount++;
                    }
                }
            }
        }

        // Get achievements data
        $achievements = $this->calculateAchievements($totalHours, $completedCount, $enrolments->count());

        // Get certificates
        $myCoursesList = Checkout::where('user_id', Auth()->id())->get();
        $certificateCourses = Course::whereIn('id', $myCoursesList->pluck('course_id'))->orderby('id', 'desc')->get();

        return view('e-learning/course/students/dashboard', compact(
            'enrolments', 'totalHours', 'totalMinutes', 'notStartedCount', 
            'inProgressCount', 'completedCount', 'achievements', 'certificateCourses'
        ));
    }

    /**
     * Enrolled Courses Page
     */
    public function enrolledCourses()
    {
        $queryParams = request()->except('page');
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : '';

        // Get checkout enrollments (approved/paid courses)
        $checkoutEnrollments = Checkout::with('course.reviews')->where('user_id', Auth::user()->id)->get();

        // Get CourseEnrollment entries (including pending AI bootcamp enrollments)
        $courseEnrollments = CourseEnrollment::with(['course.reviews', 'course.user'])
            ->where('user_id', Auth::user()->id)
            ->get();

        // Combine and transform both types of enrollments
        $allEnrollments = collect();

        // Add checkout enrollments
        foreach ($checkoutEnrollments as $checkout) {
            if ($checkout->course) {
                $allEnrollments->push((object)[
                    'id' => $checkout->id,
                    'course' => $checkout->course,
                    'status' => 'approved', // Checkout entries are always approved
                    'enrollment_type' => 'checkout',
                    'payment_method' => $checkout->payment_method ?? 'paid',
                    'amount' => $checkout->amount,
                    'created_at' => $checkout->created_at,
                    'transaction_id' => $checkout->payment_id ?? null,
                    'instructor_name' => $checkout->course->user->name ?? 'Unknown'
                ]);
            }
        }

        // Add course enrollments (AI bootcamp, etc.)
        foreach ($courseEnrollments as $enrollment) {
            if ($enrollment->course) {
                $allEnrollments->push((object)[
                    'id' => $enrollment->id,
                    'course' => $enrollment->course,
                    'status' => $enrollment->status, // payment_pending, pending, approved, rejected
                    'enrollment_type' => 'course_enrollment',
                    'payment_method' => $enrollment->payment_method,
                    'amount' => $enrollment->amount,
                    'created_at' => $enrollment->created_at,
                    'transaction_id' => $enrollment->transaction_id,
                    'rejection_reason' => $enrollment->rejection_reason,
                    'instructor_name' => $enrollment->course->user->name ?? 'Unknown'
                ]);
            }
        }

        // Apply filters
        if (!empty($title)) {
            $allEnrollments = $allEnrollments->filter(function ($enrollment) use ($title) {
                return stripos($enrollment->course->title, $title) !== false;
            });
        }

        // Apply sorting
        if ($status) {
            if ($status == 'oldest') {
                $allEnrollments = $allEnrollments->sortBy('created_at');
            } elseif ($status == 'newest') {
                $allEnrollments = $allEnrollments->sortByDesc('created_at');
            }
        } else {
            $allEnrollments = $allEnrollments->sortByDesc('created_at');
        }

        // Paginate manually
        $currentPage = request()->input('page', 1);
        $perPage = 12;
        $offset = ($currentPage - 1) * $perPage;
        $items = $allEnrollments->slice($offset, $perPage)->values();

        $enrolments = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $allEnrollments->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'pageName' => 'page']
        );
        $enrolments->withQueryString();

        return view('e-learning/course/students/enrolled', compact('enrolments'));
    }

    /**
     * Achievements Page
     */
    public function achievements()
    {
        $user = Auth::user();
        
        // Calculate achievements based on user activity
        $totalTimeSpend = CourseActivity::where('user_id', $user->id)->where('is_completed', 1)->sum('duration');
        $totalHours = floor($totalTimeSpend / 3600);
        
        $completedCourses = Checkout::where('user_id', $user->id)->count();
        $enrolledCourses = Checkout::where('user_id', $user->id)->count();
        
        $achievements = $this->calculateAchievements($totalHours, $completedCourses, $enrolledCourses);
        
        return view('e-learning/course/students/achievements', compact('achievements', 'totalHours', 'completedCourses'));
    }

    /**
     * Student Notifications
     */
    public function notifications()
    {
        $notifications = Notification::where('user_id', Auth::user()->id)
                                   ->orderBy('created_at', 'desc')
                                   ->paginate(20);

        return view('student.notifications', compact('notifications'));
    }

    /**
     * Mark single notification as read
     */
    public function markNotificationAsRead($id)
    {
        $notification = Notification::where('id', $id)
                                  ->where('user_id', Auth::user()->id)
                                  ->first();

        if ($notification) {
            $notification->update(['status' => 'seen']);
            return response()->json(['success' => true, 'message' => 'Notification marked as read']);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllNotificationsAsRead()
    {
        Notification::where('user_id', Auth::user()->id)
                   ->where('status', 'unseen')
                   ->update(['status' => 'seen']);

        return response()->json(['success' => true, 'message' => 'All notifications marked as read']);
    }


    /**
     * Calculate user achievements based on activity
     */
    private function calculateAchievements($totalHours, $completedCourses, $enrolledCourses)
    {
        $achievements = [
            'first_enrollment' => [
                'title' => 'প্রথম এনরোলমেন্ট',
                'description' => 'প্রথম কোর্সে ভর্তি হয়েছেন',
                'icon' => 'fas fa-graduation-cap',
                'earned' => $enrolledCourses > 0,
                'color' => 'success'
            ],
            'first_course_complete' => [
                'title' => 'প্রথম কোর্স সম্পন্ন',
                'description' => 'প্রথমবার একটি কোর্স শেষ করেছেন',
                'icon' => 'fas fa-trophy',
                'earned' => $completedCourses > 0,
                'color' => 'warning'
            ],
            'five_hours_watched' => [
                'title' => '৫ ঘণ্টা শিক্ষা',
                'description' => '৫ ঘণ্টা ভিডিও দেখেছেন',
                'icon' => 'fas fa-clock',
                'earned' => $totalHours >= 5,
                'color' => 'info'
            ],
            'ten_hours_watched' => [
                'title' => '১০ ঘণ্টা শিক্ষা',
                'description' => '১০ ঘণ্টা ভিডিও দেখেছেন',
                'icon' => 'fas fa-fire',
                'earned' => $totalHours >= 10,
                'color' => 'danger'
            ],
            'dedicated_learner' => [
                'title' => 'নিবেদিতপ্রাণ শিক্ষার্থী',
                'description' => '৫০ ঘণ্টা শিক্ষা সম্পন্ন করেছেন',
                'icon' => 'fas fa-star',
                'earned' => $totalHours >= 50,
                'color' => 'primary'
            ],
            'course_collector' => [
                'title' => 'কোর্স সংগ্রাহক',
                'description' => '৫টি কোর্স সম্পন্ন করেছেন',
                'icon' => 'fas fa-medal',
                'earned' => $completedCourses >= 5,
                'color' => 'success'
            ]
        ];

        return $achievements;
    }

    public function backToPavilion($userId)
    {
        $user_id = decrypt($userId);
        $user = User::find($user_id);

        if ($user->user_role == 'instructor') {
            Auth::logout();
            Auth::login($user);

            $keysToForget = ['userId', 'userRole'];
            foreach ($keysToForget as $key) {
                if (session()->has($key)) {
                    session()->forget($key);
                }
            }
            return redirect()->route('instructor.dashboard');
        } elseif ($user->user_role == 'admin') {
            Auth::logout();
            $keysToForget = ['userId', 'userRole'];
            foreach ($keysToForget as $key) {
                if (session()->has($key)) {
                    session()->forget($key);
                }
            }
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('student.dashboard');
    }

    // ========================================
    // NEW CLEAN URL STRUCTURE METHODS
    // ========================================

    /**
     * Courses catalog - /student/courses/
     */
    public function courses(Request $request)
    {
        // Get enrolled course IDs using the existing isEnrolled helper logic
        $userId = auth()->id();
        
        // Get all courses first
        $allCourses = Course::where('status', 'active')->get();
        
        // Filter to only enrolled courses
        $enrolledCourses = $allCourses->filter(function($course) use ($userId) {
            // Check CourseEnrollment table
            $enrollment = CourseEnrollment::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->where('status', 'approved')
                ->first();
                
            if ($enrollment) {
                return true;
            }
            
            // Check course_user pivot table
            $pivotEnrollment = DB::table('course_user')
                ->where('user_id', $userId)
                ->where('course_id', $course->id)
                ->first();
                
            if ($pivotEnrollment) {
                return true;
            }
            
            // Check Checkout table
            $checkout = Checkout::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->first();
                
            return $checkout ? true : false;
        });
        
        // Apply search filter if provided
        if ($request->filled('title')) {
            $enrolledCourses = $enrolledCourses->filter(function($course) use ($request) {
                return stripos($course->title, $request->title) !== false;
            });
        }
        
        // Apply sorting
        switch ($request->get('status')) {
            case 'newest':
                $enrolledCourses = $enrolledCourses->sortByDesc('created_at');
                break;
            case 'oldest':
                $enrolledCourses = $enrolledCourses->sortBy('created_at');
                break;
            default:
                $enrolledCourses = $enrolledCourses->sortByDesc('updated_at');
                break;
        }
        
        // Paginate the results
        $currentPage = request()->input('page', 1);
        $perPage = 12;
        $offset = ($currentPage - 1) * $perPage;
        $courses = $enrolledCourses->slice($offset, $perPage)->values();
        
        $courses = new \Illuminate\Pagination\LengthAwarePaginator(
            $courses,
            $enrolledCourses->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'pageName' => 'page']
        );
        $courses->withQueryString();
        
        // Get cart courses for the current user
        $cartCourses = collect();
        if (auth()->check()) {
            $cartCourses = Cart::where('user_id', auth()->id())->get();
        }
        
        return view('e-learning.course.students.catalog', compact('courses', 'cartCourses'));
    }

    /**
     * Course overview for enrolled students - /student/courses/{slug}/
     */
    public function courseOverview($slug)
    {
        return $this->courseDetails($slug);
    }

    /**
     * Course learning interface - /student/courses/{slug}/learn/
     */
    public function courseLearn($slug)
    {
        return $this->courseDetails($slug);
    }

    /**
     * Student certificates - /student/certificates/
     */
    public function certificates()
    {
        return $this->certificate();
    }

    /**
     * Course activities - /student/activities/
     */
    public function activities()
    {
        return $this->activitiesList();
    }

    /**
     * Complete activity - /student/activities/complete/
     */
    public function completeActivity(Request $request)
    {
        return $this->storeActivities($request);
    }

    /**
     * Reset course progress for a student
     */
    public function resetCourse(Request $request)
    {
        try {
            $request->validate([
                'course_id' => 'required|integer|exists:courses,id'
            ]);

            $courseId = $request->course_id;
            $userId = Auth::id();

            // Verify that the user is enrolled in this course
            $enrollment = CourseEnrollment::where('user_id', $userId)
                                        ->where('course_id', $courseId)
                                        ->where('status', 'approved')
                                        ->first();

            if (!$enrollment) {
                return response()->json([
                    'success' => false,
                    'message' => 'আপনি এই কোর্সে এনরোল নেই বা কোর্সটি অনুমোদিত নয়।'
                ], 403);
            }

            DB::beginTransaction();

            try {
                // Delete all course logs for this user and course
                CourseLog::where('user_id', $userId)
                         ->where('course_id', $courseId)
                         ->delete();

                // Delete all course activities for this user and course
                CourseActivity::where('user_id', $userId)
                              ->where('course_id', $courseId)
                              ->delete();

                DB::commit();


                return response()->json([
                    'success' => true,
                    'message' => 'কোর্সটি সফলভাবে রিসেট করা হয়েছে। আপনি এখন নতুন করে শুরু করতে পারেন।'
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                
                Log::error('Course reset failed during database operation', [
                    'user_id' => $userId,
                    'course_id' => $courseId,
                    'error' => $e->getMessage(),
                    'timestamp' => now()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'ডেটাবেস অপারেশনে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।'
                ], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'অবৈধ ডেটা প্রদান করা হয়েছে।'
            ], 422);
        } catch (\Exception $e) {
            Log::error('Course reset failed', [
                'user_id' => Auth::id(),
                'course_id' => $request->course_id ?? null,
                'error' => $e->getMessage(),
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'কোর্স রিসেট করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।'
            ], 500);
        }
    }

}
