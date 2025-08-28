<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use DataTables;
use ZipArchive;
use App\Models\Cart;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Checkout;
use App\Models\CourseLog;
use App\Models\Certificate;
use App\Models\course_like;
use Illuminate\Support\Str;
use App\Models\BundleCourse;
use App\Models\BundleSelect;
use App\Models\CourseReview;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\CourseActivity;


class CourseController extends Controller
{
    // course list
    public function index(){

        $queryParams = request()->except('page');

        $title = isset($_GET['title']) ? $_GET['title'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : '';

        $courses = Course::where('user_id', Auth::user()->id);

        if ($title) {
            $courses->where(function ($query) use ($title) {
                $categories = explode(',', trim($title));
                foreach ($categories as $category) {
                    $query->orWhere('categories', 'like', '%' . trim($category) . '%');
                }
            });
        }

        if ($status) {
            if ($status == 'oldest') {
                $courses->orderBy('id', 'asc');
            }

            if ($status == 'best_rated') {
                $courses = Course::leftJoin('course_reviews', 'courses.id', '=', 'course_reviews.course_id')
                ->select('courses.*', DB::raw('COALESCE(AVG(course_reviews.star), 0) as avg_star'))
                ->groupBy('courses.id')
                ->where('courses.user_id', Auth::user()->id)
                ->orderBy('avg_star', 'desc');
            }

            if ($status == 'most_purchased') {
                $courses = Course::with(['user','reviews'])
                ->withCount('checkouts as sale_count')
                ->where('user_id', auth()->id())
                ->orderByDesc('sale_count','desc');
            }

            if ($status == 'newest') {
                $courses->orderBy('id', 'desc');
            }
        }else{
            $courses->orderBy('id', 'desc');
        }

        $courses = $courses->paginate(12)->appends($queryParams);

        return view('e-learning/course/instructor/list',compact('courses'));
    }

    // course show
    public function show( $id)
    {
        $course = Course::where('id', $id)
                       ->where('instructor_id', Auth::user()->id)
                       ->with('modules.lessons','user')
                       ->first();
        
        if (!$course) {
            return redirect('instructor/courses')->with('error', 'Course not found or you are not authorized to view it!');
        }

        //start group file
        $lesson_files = Lesson::where('course_id',$course->id)->select('lesson_file as file')->get();
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

        $relatedCourses = [];
    
        if($course->categories){
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

        $totalModules = $course->modules->where('status', 'published')->count();

        // $totalLessons = $course->modules->sum(function ($module) {
        //     return $module->lessons->filter(function ($lesson) {
        //         return $lesson->status == 'published';
        //     })->count();
        // });
    
        $totalLessons = $course->modules->filter(function ($module) {
            return $module->status === 'published';
        })->map(function ($module) {
            return $module->lessons()->where('status', 'published')->count();
        })->sum();


        // last playing video
  
        $courseLog = CourseLog::where('course_id', $course->id)->where('user_id',auth()->user()->id)->first();
        $currentLessonVideo = NULL;
        $currentLesson = NULL;

        if ($courseLog) {
            $lesson = Lesson::find($courseLog->lesson_id);
            if ($lesson) {
               $currentLesson = $lesson;
               $currentLessonVideo = str_replace("/videos/", "", $lesson->video_link);
            }
        }

        return view('e-learning/course/instructor/show', compact('course','course_reviews','relatedCourses','totalModules','totalLessons','group_files','currentLessonVideo','currentLesson'));
    }


    // course overview
    public function overview( $slug)
    {

        $title = 'Course Overview';
        $course = Course::where('slug', $slug)->with('modules.lessons','user')->firstOrFail();
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

        $course_reviews = CourseReview::where('course_id', $course->id)->with('user')->get();
        $courseEnrolledNumber = Checkout::where('course_id',$course->id)->count();
        
        // Calculate course statistics with better fallbacks
        $publishedModules = $course->modules->where('status', 'published');
        
        // If no published modules, try all modules (might not have status field)
        if ($publishedModules->count() == 0) {
            $publishedModules = $course->modules;
        }
        
        $totalModules = $publishedModules->count();
        
        // Calculate total lessons and duration
        $totalLessons = 0;
        $totalDurationSeconds = 0;
        
        foreach ($publishedModules as $module) {
            $publishedLessons = $module->lessons->where('status', 'published');
            
            // If no published lessons, try all lessons in the module
            if ($publishedLessons->count() == 0) {
                $publishedLessons = $module->lessons;
            }
            
            $totalLessons += $publishedLessons->count();
            
            foreach ($publishedLessons as $lesson) {
                if (isset($lesson->duration) && is_numeric($lesson->duration)) {
                    $totalDurationSeconds += $lesson->duration;
                }
            }
        }
        
        // Convert duration to hours and minutes (assuming duration is in seconds)
        $totalHours = floor($totalDurationSeconds / 3600);
        $totalMinutes = floor(($totalDurationSeconds % 3600) / 60);
        
        // If still zero but we have lessons, assume durations are in minutes
        if ($totalDurationSeconds == 0 && $totalLessons > 0) {
            $totalDurationMinutes = 0;
            foreach ($publishedModules as $module) {
                $publishedLessons = $module->lessons->where('status', 'published');
                if ($publishedLessons->count() == 0) {
                    $publishedLessons = $module->lessons;
                }
                
                foreach ($publishedLessons as $lesson) {
                    if (isset($lesson->duration) && is_numeric($lesson->duration)) {
                        $totalDurationMinutes += $lesson->duration; // Assume it's in minutes
                    }
                }
            }
            $totalHours = floor($totalDurationMinutes / 60);
            $totalMinutes = $totalDurationMinutes % 60;
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

            return view('e-learning/course/instructor/overview', compact('title','course','promo_video_link','course_reviews','related_course','courseEnrolledNumber','totalModules','totalLessons','totalHours','totalMinutes'));
        } else {
            return redirect('instructor/dashboard')->with('error', 'Course not found!');
        }
    }

    public function storeCourseLog(Request $request){

        $courseId = (int)$request->input('courseId');
        $lessonId = (int)$request->input('lessonId');
        $moduleId = (int)$request->input('moduleId');
        $userId = auth()->user()->id;

        $existingCourse = Course::find($courseId);
        $courseLog = CourseLog::where('course_id', $courseId)->where('user_id',$userId)->first();

        if(!$courseLog){
            // Get the actual instructor ID from the course
            $instructorId = $existingCourse ? ($existingCourse->instructor_id ?: $existingCourse->user_id) : $userId;
            
            $courseLogInfo = new CourseLog([
                'course_id' => $courseId,
                'instructor_id' => $instructorId,
                'module_id' => $moduleId,
                'lesson_id' => $lessonId,
                'user_id'   => $userId,
            ]);
            $courseLogInfo->save();
            return response()->json([
                'message' => 'course log save successfully',
                'course_id' => $courseId,
                'instructor_id' => $instructorId,
                'module_id' => $moduleId,
                'lesson_id' => $lessonId,
                'user_id'   => $userId,
            ]);
        }else{
            // Get the actual instructor ID from the course
            $instructorId = $existingCourse ? ($existingCourse->instructor_id ?: $existingCourse->user_id) : $userId;
            
            $courseLog->course_id = $courseId;
            $courseLog->instructor_id = $instructorId;
            $courseLog->module_id = $moduleId;
            $courseLog->lesson_id = $lessonId;
            $courseLog->user_id = $userId;

            $courseLog->update();
            return response()->json([
                'message' => 'course log updated',
                'course_id' => $courseId,
                'instructor_id' => $instructorId,
                'module_id' => $moduleId,
                'lesson_id' => $lessonId,
                'user_id'   => $userId,
            ]);
        }

    }

    // Public course overview (accessible to all users)
    public function publicIndex(Request $request)
    {
        $title = 'All Courses';
        $search = $request->get('search');
        $category = $request->get('category');
        $level = $request->get('level');
        $sort = $request->get('sort', 'latest');

        // Base query for published courses
        $courses = Course::where('status', 'published')
                        ->with(['user', 'modules.lessons']);

        // Apply search filter
        if ($search) {
            $courses->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                      ->orWhere('short_description', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Apply category filter
        if ($category) {
            $courses->where('categories', 'like', '%' . $category . '%');
        }

        // Apply level filter - Note: level field doesn't exist in courses table
        // This filter is disabled until level field is added
        // if ($level) {
        //     $courses->where('level', $level);
        // }

        // Apply sorting
        switch ($sort) {
            case 'title_asc':
                $courses->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $courses->orderBy('title', 'desc');
                break;
            case 'price_asc':
                $courses->orderByRaw('COALESCE(offer_price, price, 999999) ASC');
                break;
            case 'price_desc':
                $courses->orderByRaw('COALESCE(offer_price, price, 0) DESC');
                break;
            case 'popular':
                // Sort by enrollment count (we'll calculate this)
                $courses->withCount(['checkouts as enrolled_count'])
                        ->orderBy('enrolled_count', 'desc');
                break;
            case 'latest':
            default:
                $courses->orderBy('created_at', 'desc');
                break;
        }

        // Paginate results
        $courses = $courses->paginate(12);

        // Calculate course statistics for each course more efficiently
        $courseIds = $courses->pluck('id')->toArray();
        
        // Get all enrollment counts from both checkouts and course_user tables
        $checkoutCounts = Checkout::whereIn('course_id', $courseIds)
            ->select('course_id', DB::raw('COUNT(*) as count'))
            ->groupBy('course_id')
            ->pluck('count', 'course_id')
            ->toArray();
            
        $courseUserCounts = DB::table('course_user')
            ->whereIn('course_id', $courseIds)
            ->select('course_id', DB::raw('COUNT(*) as count'))
            ->groupBy('course_id')
            ->pluck('count', 'course_id')
            ->toArray();
            
        // Merge the counts, taking the maximum of both
        $enrollmentCounts = [];
        foreach ($courseIds as $courseId) {
            $checkoutCount = $checkoutCounts[$courseId] ?? 0;
            $courseUserCount = $courseUserCounts[$courseId] ?? 0;
            $enrollmentCounts[$courseId] = max($checkoutCount, $courseUserCount);
        }
            
        // Get all review data in one query
        $reviewData = CourseReview::whereIn('course_id', $courseIds)
            ->select('course_id', DB::raw('AVG(star) as avg_rating'), DB::raw('COUNT(*) as review_count'))
            ->groupBy('course_id')
            ->get()
            ->keyBy('course_id');

        foreach ($courses as $course) {
            // Calculate total duration, lessons, and modules - be flexible with published status
            $availableModules = $course->modules->where('status', 'published');
            
            // If no published modules, use all modules
            if ($availableModules->count() == 0) {
                $availableModules = $course->modules;
            }
            
            $totalLessons = 0;
            $totalDurationSeconds = 0;
            
            foreach ($availableModules as $module) {
                $availableLessons = $module->lessons->where('status', 'published');
                
                // If no published lessons, use all lessons in the module
                if ($availableLessons->count() == 0) {
                    $availableLessons = $module->lessons;
                }
                
                $totalLessons += $availableLessons->count();
                
                foreach ($availableLessons as $lesson) {
                    if (isset($lesson->duration) && is_numeric($lesson->duration) && $lesson->duration > 0) {
                        $totalDurationSeconds += $lesson->duration;
                    }
                }
            }
            
            // Convert duration from seconds to hours and minutes
            $course->total_hours = floor($totalDurationSeconds / 3600);
            $course->total_minutes = floor(($totalDurationSeconds % 3600) / 60);
            
            // If total time is still 0 but we have lessons, estimate duration
            if ($course->total_hours == 0 && $course->total_minutes == 0 && $totalLessons > 0) {
                $estimatedMinutes = $totalLessons * 8; // 8 minutes per lesson average
                $course->total_hours = floor($estimatedMinutes / 60);
                $course->total_minutes = $estimatedMinutes % 60;
            }
            
            $course->total_lessons = $totalLessons;
            $course->total_modules = $availableModules->count();
            
            // Set enrollment count from cached data
            $course->enrolled_count = $enrollmentCounts[$course->id] ?? 0;
            
            // Set review data from cached data
            if (isset($reviewData[$course->id])) {
                $course->average_rating = round($reviewData[$course->id]->avg_rating, 1);
                $course->review_count = $reviewData[$course->id]->review_count;
            } else {
                $course->average_rating = 0;
                $course->review_count = 0;
            }
        }

        // Get available categories and levels for filters
        $categories = Course::where('status', 'published')
                           ->whereNotNull('categories')
                           ->pluck('categories')
                           ->flatMap(function ($category) {
                               return explode(',', $category);
                           })
                           ->map(function ($category) {
                               return trim($category);
                           })
                           ->filter()
                           ->unique()
                           ->sort()
                           ->values();

        // Levels array is empty since level field doesn't exist in courses table
        $levels = collect();

        return view('courses.index', compact('title', 'courses', 'categories', 'levels', 'search', 'category', 'level', 'sort'));
    }

    public function publicOverview($slug)
    {
        $title = 'Course Overview';
        
        // Optimized eager loading
        $course = Course::where('slug', $slug)
            ->where('status', 'published')
            ->with([
                'user:id,name,avatar,user_role',
                'modules' => function($query) {
                    $query->select('id', 'course_id', 'title', 'slug', 'status')
                          ->with(['lessons' => function($lessonQuery) {
                              $lessonQuery->select('id', 'module_id', 'title', 'duration', 'status');
                          }]);
                },
                'reviews' => function($query) {
                    $query->with('user:id,name,avatar');
                }
            ])
            ->firstOrFail();
        
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
        
        // Use the already loaded reviews
        $course_reviews = $course->reviews;
        
        // Get enrollment count from multiple sources and use the highest count
        $checkoutCount = Checkout::where('course_id',$course->id)->count();
        $courseUserCount = DB::table('course_user')->where('course_id', $course->id)->count();
        $courseEnrolledNumber = max($checkoutCount, $courseUserCount);
        
        // Optimized course statistics calculation using collections
        $availableModules = $course->modules->where('status', 'published');
        
        // If no published modules, use all modules
        if ($availableModules->count() == 0) {
            $availableModules = $course->modules;
        }
        
        $totalModules = $availableModules->count();
        
        // Calculate total lessons and duration using collection methods
        $totalLessons = 0;
        $totalDurationSeconds = 0;
        
        foreach ($availableModules as $module) {
            $availableLessons = $module->lessons->where('status', 'published');
            
            // If no published lessons, use all lessons in the module
            if ($availableLessons->count() == 0) {
                $availableLessons = $module->lessons;
            }
            
            $totalLessons += $availableLessons->count();
            $totalDurationSeconds += $availableLessons->sum(function($lesson) {
                return is_numeric($lesson->duration) ? $lesson->duration : 0;
            });
        }
        
        // Convert duration to hours and minutes (assuming duration is in seconds)
        $totalHours = floor($totalDurationSeconds / 3600);
        $totalMinutes = floor(($totalDurationSeconds % 3600) / 60);
        
        // If still zero but we have lessons, assume durations are in minutes
        if ($totalDurationSeconds == 0 && $totalLessons > 0) {
            $totalDurationMinutes = 0;
            foreach ($availableModules as $module) {
                $availableLessons = $module->lessons->where('status', 'published');
                if ($availableLessons->count() == 0) {
                    $availableLessons = $module->lessons;
                }
                
                $totalDurationMinutes += $availableLessons->sum(function($lesson) {
                    return is_numeric($lesson->duration) ? $lesson->duration : 0;
                });
            }
            $totalHours = floor($totalDurationMinutes / 60);
            $totalMinutes = $totalDurationMinutes % 60;
        }
        
        $related_course = [];
        
        if($course->categories){
            $categoryArray = explode(',', $course->categories);
            $related_course = Course::select('id', 'title', 'slug', 'thumbnail', 'price', 'offer_price', 'instructor_id')
                ->where('instructor_id', $course->instructor_id)
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
        
        return view('e-learning/course/public/overview', compact('title','course','promo_video_link','course_reviews','related_course','courseEnrolledNumber','totalModules','totalLessons','totalHours','totalMinutes'));
    }

        // course overview
        public function preview($model, $slug)
        {
            $title = 'Course Preview';
            $course = Course::where('slug', $slug)->with('modules.lessons','user')->firstOrFail();
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

            $course_reviews = CourseReview::where('course_id', $course->id)->with('user')->get();
            $courseEnrolledNumber = Checkout::where('course_id',$course->id)->count();

            $related_course = [];
            if ($course) {
                if($course->categories){
                    $categoryArray = explode(',', $course->categories);
                    $query = Course::query();

                    foreach ($categoryArray as $category) {
                        $query->orWhere('categories', 'like', '%' . trim($category) . '%');
                    }
                    $related_course = $query->take(4)->get();
                }


                return view('e-learning/course/instructor/overview', compact('title','course','promo_video_link','course_reviews','related_course','courseEnrolledNumber'));
            } else {
                return redirect('instructor/dashboard')->with('error', 'Course not found!');
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
              return redirect('admin/courses')->with('error', $is_have_file);
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

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            // Clear session
            if (session()->has('course_id')) {
                session()->forget('course_id');
            }

        // update bundle course for this course
        $selectedCourseValue = intval($id);
        $instructorId = Auth::user()->id;
        $bundleSelected = BundleCourse::where('instructor_id', $instructorId)
            ->where(function ($query) use ($selectedCourseValue) {
                $query->where('selected_course', 'LIKE', $selectedCourseValue . ',%')
                    ->orWhere('selected_course', 'LIKE', '%,' . $selectedCourseValue . ',%')
                    ->orWhere('selected_course', 'LIKE', '%,' . $selectedCourseValue);
            })
            ->get();
        foreach ($bundleSelected as $record) {
            $updatedSelectedCourse = str_replace($selectedCourseValue . ',', '', $record->selected_course);
            $updatedSelectedCourse = str_replace(',' . $selectedCourseValue, '', $updatedSelectedCourse);
            $updatedSelectedCourse = str_replace($selectedCourseValue, '', $updatedSelectedCourse);
            $record->selected_course = $updatedSelectedCourse;
            $record->save();
        }

        // delete bundleselected for this course
        $bundleSelection = BundleSelect::where(['course_id'=> $selectedCourseValue,'instructor_id' => $instructorId])->get();
        if ($bundleSelection) {
            foreach ($bundleSelection as $bundleSelected) {
                $bundleSelected->delete();
            }
        }

        // update cart
        $cartSelects = Cart::where(['course_id'=> $selectedCourseValue,'instructor_id' => $instructorId])->get();
        if ($cartSelects) {
            foreach ($cartSelects as $cartSelect) {
                $cartSelect->delete();
            }
        }

        // certificate delete
        $certificate = Certificate::where(['course_id'=> $selectedCourseValue,'instructor_id' => $instructorId])->first();
        if ($certificate) {
            $certificateOldLogo = public_path($certificate->logo);
            if (file_exists($certificateOldLogo)) {
                @unlink($certificateOldLogo);
            }

            $certificateOldSignature = public_path($certificate->signature);
            if (file_exists($certificateOldSignature)) {
                @unlink($certificateOldSignature);
            }
            $certificate->delete();
        }

        // checkout controller update
        $totalCheckout = Checkout::where(['course_id'=> $selectedCourseValue,'instructor_id' => $instructorId])->get();
        if ($totalCheckout) {
            foreach ($totalCheckout as $checkout) {
                $checkout->status = 'deleted';
                $checkout->save();
            }
        }

        // course activities
        $totalActivity = CourseActivity::where(['course_id'=> $selectedCourseValue,'instructor_id' => $instructorId])->get();
        if ($totalActivity) {
            foreach ($totalActivity as $activity) {
                $activity->delete();
            }
        }

        // course likes
        $course_likes = course_like::where(['course_id'=> $selectedCourseValue,'instructor_id' => $instructorId])->get();
        if ($course_likes) {
            foreach ($course_likes as $course_liked) {
                $course_liked->delete();
            }
        }

        // course Log
        $course_logs = CourseLog::where(['course_id'=> $selectedCourseValue,'instructor_id' => $instructorId])->get();
        if ($course_logs) {
            foreach ($course_logs as $course_log) {
                $course_log->delete();
            }
        }

        // course review
        $course_reviews = CourseReview::where(['course_id'=> $selectedCourseValue,'instructor_id' => $instructorId])->get();
        if ($course_reviews) {
            foreach ($course_reviews as $course_review) {
                $course_review->delete();
            }
        }

        // course users
        $course_useres = DB::table('course_user')->where(['course_id'=> $selectedCourseValue,'instructor_id' => $instructorId])->get();
        if ($course_useres) {
            foreach ($course_useres as $course_usere) {
                DB::table('course_user')
                ->where('id', $course_usere->id)
                ->delete();
            }
        }

        // delete notification for this course
        $course_notifications = Notification::where(['course_id'=> $selectedCourseValue,'instructor_id' => $instructorId])->get();
        if ($course_notifications) {
            foreach ($course_notifications as $course_notification) {
                $course_notification->delete();
            }
        }

        // delete main course
        $course = Course::where(['id'=> $selectedCourseValue,'user_id' => $instructorId])->first();

        if ($course) {
            //delete thumbnail
            $oldThumbnail = public_path($course->thumbnail);
            if (file_exists($oldThumbnail)) {
                @unlink($oldThumbnail);
            }
            //delete certficate
            $oldCertificate = public_path($course->sample_certificates);
            if (file_exists($oldCertificate)) {
                @unlink($oldCertificate);
            }
            //delete modules
            $modules = Module::where('course_id', $course->id)->get();
            foreach ($modules as $module) {
                //delete lessons
                $lessons = Lesson::where('module_id', $module->id)->get();
                foreach ($lessons as $lesson) {
                    //delete lesson thumbnail
                    $lessonOldThumbnail = public_path($lesson->thumbnail);
                    if (file_exists($lessonOldThumbnail)) {
                        @unlink($lessonOldThumbnail);
                    }
                    //delete lesson file
                    $lessonOldFile = public_path($lesson->lesson_file);
                    if (file_exists($lessonOldFile)) {
                        @unlink($lessonOldFile);
                    }

                    $lesson->delete();
                }
                $module->delete();
            }
            $course->delete();
            
            DB::commit();
            return redirect('instructor/courses')->with('success', 'Course deleted successfully!');
        } else {
            DB::rollBack();
            return redirect('instructor/courses')->with('error', 'Course not found or you are not authorized to delete it!');
        }
        
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Course deletion failed: ' . $e->getMessage());
            return redirect('instructor/courses')->with('error', 'Failed to delete course. Please try again.');
        }
    }

}
