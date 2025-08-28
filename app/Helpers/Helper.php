<?php

use App\Models\User;
use Stripe\Stripe;
use Vimeo\Vimeo as VimeoSDK;
use Vimeo\Laravel\Facades\Vimeo;



/**
 * Helper function to check logged in user is connected with stripe or not if connected then show connected and store data in $account
 */
if (!function_exists('isConnectedWithStripe')) {
    function isConnectedWithStripe()
    {
        $user = auth()->user();
        $account = null;
        $status = '';

        if ($user->stripe_secret_key && $user->stripe_public_key) {
            Stripe::setApiKey($user->stripe_secret_key);
            // Retrieve the user's stripe data based on user_id
            $account = \Stripe\Account::retrieve($user->stripe_account_id);
            $status = 'Connected';

            if (!$account) {
                // Stripe account not found, show alert or redirect
                $status = 'Not Connected';
                return [$account, $status];
            }
        } else {
            // User is not authenticated
            $status = 'Not Connected';
            return [$account, $status];
        }

        return [$account, $status];
    }
}

/**
 * Helper function to check logged in user role is student and check if user has enrolled in course or not
 */
if (!function_exists('isEnrolled')) {
    function isEnrolled($course_id)
    {
        $user = auth()->user();
        $enrolled = false;

        if ($user) {
            // Check if we have cached enrollment data first
            $cachedEnrolledCourses = app()->bound('user_enrolled_courses') 
                ? app('user_enrolled_courses') 
                : null;
            
            if ($cachedEnrolledCourses && $cachedEnrolledCourses->contains($course_id)) {
                $enrolled = true;
            } else {
                // Fallback to database query if not cached
                $enrollment = \App\Models\CourseEnrollment::where('user_id', $user->id)
                    ->where('course_id', $course_id)
                    ->where('status', \App\Models\CourseEnrollment::STATUS_APPROVED)
                    ->first();

                if ($enrollment) {
                    $enrolled = true;
                }
            }
        }

        return $enrolled;
    }
}

/**
 * Helper function to Get first lesson by course id
 */
if (!function_exists('getFirstLesson')) {
    function getFirstLesson($courseId)
    {
        $lesson = \App\Models\Lesson::where('course_id', $courseId)->orderBy('id', 'asc')->first();
        return $lesson;
    }
}

/**
 * Helper function to check vimeo data is connected or not
 */
if (!function_exists('isVimeoConnected')) {
    function isVimeoConnected($insId)
    {
        $userId = $insId;
        $vimeoData = null;
        $status = '';

        if ($userId) {
            $vimeoData = \App\Models\VimeoData::where('user_id', $userId)->first();

            if (!$vimeoData) {
                $status = 'Not Connected';
                return [$vimeoData, $status];
            } else {
                $vimeo = new \Vimeo\Vimeo($vimeoData->client_id, $vimeoData->client_secret, $vimeoData->access_key);

                try {
                    $response = $vimeo->request('/me');
                    $accountName = $response['body']['name'];
                    $status = 'Connected';
                } catch (\Vimeo\Exceptions\VimeoUploadException $e) {
                    $status = 'Invalid Credentials';
                    return [$vimeoData, $status];
                } catch (\Exception $e) {
                    $status = 'Connection Failed';
                    return [$vimeoData, $status];
                }
            }
        } else {
            // User is not authenticated
            $status = 'Not Connected';
            return [$vimeoData, $status];
        }

        return [$vimeoData, $status, $accountName];
    }
}

/**
 * Helper function to check if user has completed lesson or not
 */
if (!function_exists('isLessonCompleted')) {
    function isLessonCompleted($lesson_id)
    {
        $user = auth()->user();
        $completed = false;

        if ($user) {
            // Check if we have cached completed lessons data first
            $cachedCompletedLessons = app()->bound('user_completed_lessons') 
                ? app('user_completed_lessons') 
                : null;
            
            if ($cachedCompletedLessons && $cachedCompletedLessons->contains($lesson_id)) {
                $completed = true;
            } else {
                // Fallback to database query if not cached
                $lesson = \App\Models\CourseActivity::where('user_id', $user->id)
                                                    ->where('lesson_id', $lesson_id)
                                                    ->where('is_completed', true)
                                                    ->first();

                if ($lesson) {
                    $completed = true;
                }
            }
        }

        return $completed;
    }
}

/**
 * Helper function to total course count by instructor
 */
if (!function_exists('totalCourseByInstructor')) {
    function totalCourseByInstructor($user_id)
    {
        $totalCourse = \App\Models\Course::where('user_id', $user_id)->count();
        return $totalCourse;
    }
}

/**
 * Helper function to total student enrolled course of logged in instructor and count by instructor
 */
if (!function_exists('totalEnrolledOfStudentByInstructor')) {
    function totalEnrolledOfStudentByInstructor($user_id)
    {
        $course = \App\Models\Course::where('user_id', $user_id)->get();

        $enrolled = \App\Models\CourseEnrollment::whereIn('course_id', $course->pluck('id'))
            ->where('status', \App\Models\CourseEnrollment::STATUS_APPROVED)
            ->count();
        return $enrolled;
    }
}

/**
 * Helper function to total earning of logged in instructor
 */
if (!function_exists('totalEarningByInstructor')) {
    function totalEarningByInstructor($user_id)
    {
        $course = \App\Models\Course::where('user_id', $user_id)->get();

        $earning = \App\Models\CourseEnrollment::whereIn('course_id', $course->pluck('id'))
            ->where('status', \App\Models\CourseEnrollment::STATUS_APPROVED)
            ->sum('amount');
        return $earning;
    }
}


/**
 * Helper function to count total enrolled of course by student
 */
if (!function_exists('totalEnrolledByStudent')) {
    function totalEnrolledByStudent($user_id)
    {
        $totalEnrolled = \App\Models\CourseEnrollment::where('user_id', $user_id)
            ->where('status', \App\Models\CourseEnrollment::STATUS_APPROVED)
            ->count();
        return $totalEnrolled;
    }
}

/**
 * Helper function to count total complete lessons by student
 */
if (!function_exists('totalCompleteLessonsByStudent')) {
    function totalCompleteLessonsByStudent($user_id)
    {
        $totalCompleteLessons = \App\Models\CourseActivity::where('user_id', $user_id)->count();
        return $totalCompleteLessons;
    }
}

/**
 * Helper function to count total complete CourseReviews by student
 */
if (!function_exists('totalCompleteCourseReviewsByStudent')) {
    function totalCompleteCourseReviewsByStudent($user_id)
    {
        $totalCompleteCourseReviews = \App\Models\CourseReview::where('user_id', $user_id)->count();
        return $totalCompleteCourseReviews;
    }
}

/**
 * Helper function to count total amount paid by student
 */
if (!function_exists('totalAmountPaidByStudent')) {
    function totalAmountPaidByStudent($user_id)
    {
        $totalAmountPaid = \App\Models\CourseEnrollment::where('user_id', $user_id)
            ->where('status', \App\Models\CourseEnrollment::STATUS_APPROVED)
            ->sum('amount');
        return $totalAmountPaid;
    }
}

/*
* Helper function to get the instructor's module setting value by key.
*/
if (!function_exists('modulesetting')) {
    /**
     * Get the module setting value by key.
     *
     * @param string $key
     * @return mixed|null
     */
    // function modulesetting($key)
    // {
    //     $request = app('request');
    //     $subdomain = $request->getHost(); // Get the host (e.g., "teacher1.learncosy.local")
    //     $segments = explode('.', $subdomain); // Split the host into segments
    //     $sub_domain = $segments[0]; // Get the first segment as the subdomain

    //     if ($sub_domain) {
    //         $instructor = User::where('subdomain', $sub_domain)->where('user_role','instructor')->first();

    //         if (!$instructor) {
    //             return redirect($sub_domain . '/dashboard');
    //         }

    //         $setting = \App\Models\InstructorModuleSetting::where('instructor_id', $instructor->id)->first();

    //         if ($setting) {
    //             $setting->value = json_decode($setting->value);

    //             if ($key == 'logo') {
    //                 return $setting->logo ?? null;
    //             } elseif ($key == 'image') {
    //                 return $setting->image ?? null;
    //             } elseif ($key == 'lp_bg_image') {
    //                 return $setting->lp_bg_image ?? null;
    //             } elseif ($key == 'favicon') {
    //                 return $setting->favicon ?? null;
    //             } else {
    //                 return $setting->value->$key ?? null;
    //             }
    //         }
    //     } elseif (Auth::check() && Auth::user()->user_role == 'admin') {
    //         return null;
    //     }

    //     return null;
    // }

}





/**
 * Helper function to check student CourseLog and count total complete lessons by student
 */
if (!function_exists('StudentActitviesProgress')) {
    function StudentActitviesProgress($user_id, $course_id)
    {
        $progress = 0;
        // $modules = \App\Models\Module::where('course_id', $course_id)->where('status','published')->pluck("id")->toArray();

        $course = \App\Models\Course::where('id', $course_id)->first();

        $totalLessons = $course->modules->filter(function ($module) {
            return $module->status === 'published';
        })->map(function ($module) {
            return $module->lessons()->where('status', 'published')->count();
        })->sum();



        // Get the total number of lessons in the course
        // $totalLessons = \App\Models\Lesson::where('course_id', $course_id)->where('status','published')->count();

        // Get the total number of completed lessons by the student for the specific course
        $totalCompleteLessons = \App\Models\CourseActivity::where('course_id', $course_id)
            ->where('user_id', $user_id)
            ->whereNotNull('is_completed')
            ->count();
        // Calculate the course progress percentage
        if($totalLessons && $totalCompleteLessons)
            $progress = ($totalCompleteLessons / $totalLessons) * 100;

        // format the progress percentage
        $progress = number_format($progress, 0);
        return $progress;
    }
}



if (!function_exists('secondsToHms')) {
    function secondsToHms($seconds) {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    }
}

/**
 * Helper function to studentRadarChart for student with label and progress
 */
if (!function_exists('studentRadarChart')) {
    function studentRadarChart($user_id)
    {
        $enrollments = \App\Models\CourseEnrollment::where('user_id', $user_id)
            ->where('status', \App\Models\CourseEnrollment::STATUS_APPROVED)
            ->get();
        $courseIds = $enrollments->pluck('course_id')->toArray();
        $courses = \App\Models\Course::whereIn('id', $courseIds)->get();
        $labels = [];
        $progress = [];
        $lesson = [];
        $modules = [];
        foreach ($courses as $course) {
            $labels[] = $course->title;
            $progress[] = intval(StudentActitviesProgress($user_id, $course->id));
            $lesson[] = \App\Models\Lesson::where('course_id', $course->id)->count();
            $modules[] = \App\Models\Module::where('course_id', $course->id)->count();
        }
        return [
            'labels' => $labels,
            'progress' => $progress,
            'lesson' => $lesson,
            'modules' => $modules,
        ];
    }
}

/**
 * Helper function to get unseenNotification
 */
if (!function_exists('unseenNotification')) {
    function unseenNotification()
    {
        return \App\Models\Notification::where('status', 'unseen')->where('user_id',Auth::user()->id)->count();
    }
}

/**
 * Helper function to get cartCount
 */
if (!function_exists('cartCount')) {
    function cartCount()
    {
        return \App\Models\Cart::where('user_id', auth()->id())->count();
    }
}

/**
 * Helper function to convert YouTube URL to embeddable format
 */
if (!function_exists('getYouTubeEmbedUrl')) {
    function getYouTubeEmbedUrl($url)
    {
        if (empty($url)) {
            return null;
        }

        // Handle different YouTube URL formats
        if (strpos($url, 'youtube.com/watch?v=') !== false) {
            // Standard YouTube URL
            preg_match('/youtube\.com\/watch\?v=([^&]+)/', $url, $matches);
            if (isset($matches[1])) {
                return 'https://www.youtube.com/embed/' . $matches[1] . '?modestbranding=1&showinfo=0&rel=0&disablekb=1';
            }
        } elseif (strpos($url, 'youtu.be/') !== false) {
            // Short YouTube URL
            preg_match('/youtu\.be\/([^?&]+)/', $url, $matches);
            if (isset($matches[1])) {
                return 'https://www.youtube.com/embed/' . $matches[1] . '?modestbranding=1&showinfo=0&rel=0&disablekb=1';
            }
        } elseif (strpos($url, 'youtube.com/embed/') !== false) {
            // Already embed format - add protection parameters if not present
            if (strpos($url, 'modestbranding=') === false) {
                $separator = strpos($url, '?') !== false ? '&' : '?';
                return $url . $separator . 'modestbranding=1&showinfo=0&rel=0&disablekb=1';
            }
            return $url;
        }

        return $url; // Return original if not YouTube
    }
}

/**
 * Helper function to get Vimeo embed URL
 */
if (!function_exists('getVimeoEmbedUrl')) {
    function getVimeoEmbedUrl($url)
    {
        if (empty($url)) {
            return null;
        }

        // Handle different Vimeo URL formats
        if (strpos($url, 'vimeo.com/') !== false) {
            preg_match('/vimeo\.com\/(?:.*\/)?(\d+)/', $url, $matches);
            if (isset($matches[1])) {
                return 'https://player.vimeo.com/video/' . $matches[1];
            }
        }

        return $url; // Return original if not standard Vimeo
    }
}
