<?php

namespace App\Http\Controllers\Instructor;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Notification;
use App\Models\Chat;
use App\Models\ManagePage;
use App\Models\Checkout;
use App\Models\CourseEnrollment;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $userId = Auth::user()->id;

        // Get earnings from both checkouts and approved manual enrollments
        $checkout = Checkout::where('instructor_id', $userId);

        if ($request->duration == "one_month") {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        } elseif ($request->three_month) {
            $startDate = now()->subMonths(3);
            $endDate = now();
        } elseif ($request->duration == "six_month") {
            $startDate = now()->subMonths(6);
            $endDate = now();
        } elseif ($request->duration == "one_year") {
            $startDate = now()->subYear();
            $endDate = now();
        } else {
            $startDate = null;
            $endDate = null;
        }

        if ($startDate && $endDate) {
            $totalAmounts = $checkout->whereBetween('created_at', [$startDate, $endDate])->sum('amount');
        } else {
            $totalAmounts = 0;
        }

        // Calculate total earnings from both sources
        $checkoutEarnings = $checkout->sum('amount');
        
        // Get earnings from approved manual enrollments (bKash, Rocket, Nagad)
        $manualEarnings = CourseEnrollment::where('instructor_id', $userId)
            ->where('status', CourseEnrollment::STATUS_APPROVED)
            ->whereIn('payment_method', ['bkash', 'nogod', 'rocket'])
            ->sum('amount');
            
        $totalAmounts = $checkoutEarnings + $manualEarnings;


        $user = User::where('id', $userId)->first();
        $user->session_id = null;
        $user->save();


        $messages = [];
        // $messages = Chat::where('receiver_id',$userId)->orWhere('sender_id',$userId)->groupBy('receiver_id','sender_id')->take(3)->get();
        $analytics_title = 'Yearly Analytics';
        $compear = '1 year';
          $categories = [];
          $courses = 0;
          $students = [];
          $currentMonthEnrolledStudents = [];
          $previousMonthEnrolledStudents = [];

            if ($request->has('duration')) {
                $duration = $request->query('duration');
                if($duration === 'one_month'){
                    $analytics_title = 'Monthly Analytics';
                    $compear = ' month';
                    $firstDayOfCurrentMonth =  Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
                    $lastDayOfCurrentMonth =  Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
                    $firstDayOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d H:i:s');
                    $lastDayOfPreviousMonth = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d H:i:s');
                    // Get both checkout and approved manual enrollments for the period
                    $checkoutEnrolments = Checkout::where('instructor_id', Auth::user()->id)
                                    ->whereBetween('created_at', [$firstDayOfCurrentMonth, $lastDayOfCurrentMonth])
                                    ->orderBy('id', 'desc')->get();
                    
                    $manualEnrolments = CourseEnrollment::where('instructor_id', Auth::user()->id)
                                    ->where('status', CourseEnrollment::STATUS_APPROVED)
                                    ->whereIn('payment_method', ['bkash', 'nogod', 'rocket'])
                                    ->whereBetween('created_at', [$firstDayOfCurrentMonth, $lastDayOfCurrentMonth])
                                    ->orderBy('id', 'desc')->get();
                    
                    // Merge both collections
                    $enrolments = $checkoutEnrolments->merge($manualEnrolments);

                }elseif ($duration === 'three_months') {
                    $analytics_title = 'Quarterly Analytics';
                    $compear = '3 month';
                    $firstDayOfCurrentMonth =  Carbon::now()->subMonth(3)->startOfMonth()->format('Y-m-d H:i:s');
                    $lastDayOfCurrentMonth =  Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
                    $firstDayOfPreviousMonth = Carbon::now()->subMonth(6)->startOfMonth()->format('Y-m-d H:i:s');
                    $lastDayOfPreviousMonth = Carbon::now()->subMonth(3)->endOfMonth()->format('Y-m-d H:i:s');
                    // Get both checkout and approved manual enrollments for the period
                    $checkoutEnrolments = Checkout::where('instructor_id', Auth::user()->id)
                                    ->whereBetween('created_at', [$firstDayOfPreviousMonth, $lastDayOfCurrentMonth])
                                    ->orderBy('id', 'desc')->get();
                    
                    $manualEnrolments = CourseEnrollment::where('instructor_id', Auth::user()->id)
                                    ->where('status', CourseEnrollment::STATUS_APPROVED)
                                    ->whereIn('payment_method', ['bkash', 'nogod', 'rocket'])
                                    ->whereBetween('created_at', [$firstDayOfPreviousMonth, $lastDayOfCurrentMonth])
                                    ->orderBy('id', 'desc')->get();
                    
                    // Merge both collections
                    $enrolments = $checkoutEnrolments->merge($manualEnrolments);

                } elseif ($duration === 'six_months') {
                    $analytics_title = 'Biannually Analytics';
                    $compear = '6 month';
                    $firstDayOfCurrentMonth =  Carbon::now()->subMonth(6)->startOfMonth()->format('Y-m-d H:i:s');
                    $lastDayOfCurrentMonth =  Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
                    $firstDayOfPreviousMonth = Carbon::now()->subMonth(12)->startOfMonth()->format('Y-m-d H:i:s');
                    $lastDayOfPreviousMonth = Carbon::now()->subMonth(6)->endOfMonth()->format('Y-m-d H:i:s');
                    // Get both checkout and approved manual enrollments for the period
                    $checkoutEnrolments = Checkout::where('instructor_id', Auth::user()->id)
                                ->whereBetween('created_at', [$firstDayOfPreviousMonth, $lastDayOfCurrentMonth])
                                ->orderBy('id', 'desc')->get();
                    
                    $manualEnrolments = CourseEnrollment::where('instructor_id', Auth::user()->id)
                                ->where('status', CourseEnrollment::STATUS_APPROVED)
                                ->whereIn('payment_method', ['bkash', 'nogod', 'rocket'])
                                ->whereBetween('created_at', [$firstDayOfPreviousMonth, $lastDayOfCurrentMonth])
                                ->orderBy('id', 'desc')->get();
                    
                    // Merge both collections
                    $enrolments = $checkoutEnrolments->merge($manualEnrolments);
                } elseif ($duration === 'one_year') {

                    $firstDayOfCurrentMonth =  Carbon::now()->startOfYear()->format('Y-m-d H:i:s');
                    $lastDayOfCurrentMonth =  Carbon::now()->endOfYear()->format('Y-m-d H:i:s');
                    $firstDayOfPreviousMonth = Carbon::now()->subYear()->startOfYear()->format('Y-m-d H:i:s');
                    $lastDayOfPreviousMonth = Carbon::now()->subYear()->endOfYear()->format('Y-m-d H:i:s');
                    // Get both checkout and approved manual enrollments for the period
                    $checkoutEnrolments = Checkout::where('instructor_id', Auth::user()->id)
                                ->whereBetween('created_at', [$firstDayOfPreviousMonth, $lastDayOfCurrentMonth])
                                ->orderBy('id', 'desc')->get();
                    
                    $manualEnrolments = CourseEnrollment::where('instructor_id', Auth::user()->id)
                                ->where('status', CourseEnrollment::STATUS_APPROVED)
                                ->whereIn('payment_method', ['bkash', 'nogod', 'rocket'])
                                ->whereBetween('created_at', [$firstDayOfPreviousMonth, $lastDayOfCurrentMonth])
                                ->orderBy('id', 'desc')->get();
                    
                    // Merge both collections
                    $enrolments = $checkoutEnrolments->merge($manualEnrolments);
                }
           }else{
            $firstDayOfCurrentMonth = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
            $lastDayOfCurrentMonth = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
            $firstDayOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d H:i:s');
            $lastDayOfPreviousMonth = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d H:i:s');
            // Get both checkout and approved manual enrollments
            $checkoutEnrolments = Checkout::where('instructor_id', Auth::user()->id)->orderBy('id', 'desc')->get();
            $manualEnrolments = CourseEnrollment::where('instructor_id', Auth::user()->id)
                            ->where('status', CourseEnrollment::STATUS_APPROVED)
                            ->whereIn('payment_method', ['bkash', 'nogod', 'rocket'])
                            ->orderBy('id', 'desc')->get();
            // Merge both collections  
            $enrolments = $checkoutEnrolments->merge($manualEnrolments);
           }

          $currentMonthEnrollment = $this->getEnrollmentData(Auth::user()->id, $firstDayOfCurrentMonth, $lastDayOfCurrentMonth);
          $previousMonthEnrollment = $this->getEnrollmentData(Auth::user()->id, $firstDayOfPreviousMonth, $lastDayOfPreviousMonth);

          $currentMonthTotalSell = $currentMonthEnrollment->sum('amount');
          $previousMonthTotalSell = $previousMonthEnrollment->sum('amount');
          $percentageChange = 0;
          if($previousMonthTotalSell){
              $percentageChange = (($currentMonthTotalSell - $previousMonthTotalSell) / abs($previousMonthTotalSell)) * 100;
          }
          $formattedPercentageChangeOfEarning = round($percentageChange, 2);
            if ($request->has('duration')) {
            $duration = $request->query('duration');
            $currentDate = Carbon::now();
            $currentMonthStartDate = $currentDate->startOfMonth();
            $currentMonthEndDate = $currentDate->endOfMonth();
            if ($duration === 'three_months' || $duration === 'six_months') {
                $monthsAgo = $duration === 'three_months' ? 2 : 5;
                $previousMonthsAgo = $duration === 'three_months' ? 3 : 11;
                $threeMonthsAgoStartDate = $currentDate->subMonths($monthsAgo)->startOfMonth()->format('Y-m-d H:i:s');
                $previousMonthsAgoStartDate = $currentDate->subMonths($previousMonthsAgo)->startOfMonth()->format('Y-m-d H:i:s');
                $currentMonthEnrollments = Checkout::where('instructor_id', Auth::user()->id)
                    ->whereBetween('created_at', [ $currentMonthEndDate , $threeMonthsAgoStartDate])
                    ->get();
                $previousMonthEnrollments = Checkout::where('instructor_id', Auth::user()->id)
                    ->whereBetween('created_at', [$previousMonthsAgoStartDate, $threeMonthsAgoStartDate])
                    ->get();
            } elseif ($duration === 'one_year') {

                $firstdayOfCurrentYear = $currentDate->startOfYear()->format('Y-m-d H:i:s');
                $lastDayOfCurrentYear = $currentDate->endOfYear()->format('Y-m-d H:i:s');
                $firstDayOfPreviousYear = $currentDate->subYear()->startOfYear()->format('Y-m-d H:i:s');
                $lastDayOfPreviousYear = $currentDate->subYear()->endOfYear()->format('Y-m-d H:i:s');
                $currentMonthEnrollments = Checkout::where('instructor_id', Auth::user()->id)
                    ->whereBetween('created_at', [ $firstdayOfCurrentYear, $lastDayOfCurrentYear])
                    ->get();
                $previousMonthEnrollments = Checkout::where('instructor_id', Auth::user()->id)
                    ->whereBetween('created_at', [$lastDayOfPreviousYear, $firstDayOfPreviousYear])
                    ->get();
            } else {
                $currentMonthEnrollments = Checkout::where('instructor_id', Auth::user()->id)
                    ->whereYear('created_at', '=', now()->year)
                    ->whereMonth('created_at', '=', now()->month)
                    ->get();

                $previousMonthEnrollments = Checkout::where('instructor_id', Auth::user()->id)
                    ->whereYear('created_at', '=', now()->subMonth()->year)
                    ->whereMonth('created_at', '=', now()->subMonth()->month)
                    ->get();
            }
        }else{
            $currentMonthEnrollments = Checkout::where('instructor_id', Auth::user()->id)
                ->whereYear('created_at', '=', now()->year)
                ->whereMonth('created_at', '=', now()->month)
                ->get();

            $previousMonthEnrollments = Checkout::where('instructor_id', Auth::user()->id)
                ->whereYear('created_at', '=', date('Y', strtotime('-1 month')))
                ->whereMonth('created_at', '=', date('m', strtotime('-1 month')))
                ->get();
        }

          $activeInActiveStudents = $this->getActiveInActiveStudents($enrolments);
          $earningByDates = $this->getEarningByDates($enrolments);
          $earningByMonth = $this->getEarningByMonth($enrolments);
          $course_wise_payments = $this->getCourseWisePayments($enrolments);


        foreach ($enrolments as $enrolment) {
                $students[$enrolment->user_id] = $enrolment->created_at;
            }
            
        // Also get students from course_user pivot table
        $courseUserStudents = DB::table('course_user')
            ->join('courses', 'course_user.course_id', '=', 'courses.id')
            ->where('courses.user_id', Auth::user()->id)  // Where instructor owns the course
            ->select('course_user.user_id', 'course_user.created_at')
            ->get();
            
        foreach ($courseUserStudents as $courseUser) {
            // Add to students array if not already present (from checkouts)
            if (!isset($students[$courseUser->user_id])) {
                $students[$courseUser->user_id] = $courseUser->created_at;
            }
        }

            if ($request->has('duration')) {
                $duration = $request->query('duration');

                if ($duration === 'one_month') {
                    $currentDate = Carbon::now();
                    $currentMonthStartDate = $currentDate->startOfMonth()->format('Y-m-d H:i:s');
                    $currentMonthEndDate = $currentDate->endOfMonth()->format('Y-m-d H:i:s');

                    $currentMonthCourse = Course::where('user_id', Auth::user()->id)
                        ->whereYear('created_at', '=', now()->year)
                        ->whereMonth('created_at', '=', now()->month)
                        ->count();
                    $previousMonthCourse = Course::where('user_id', Auth::user()->id)
                        ->whereYear('created_at', '=', date('Y', strtotime('-1 month')))
                        ->whereMonth('created_at', '=', date('m', strtotime('-1 month')))
                        ->count();

                    $courses = Course::where('user_id', Auth::user()->id)->whereBetween('created_at', [$currentMonthStartDate, $currentMonthEndDate])->get();

                } elseif ($duration === 'three_months') {

                    $currentDate = Carbon::now();
                    $currentMonthStartDate = $currentDate->startOfMonth()->format('Y-m-d H:i:s');
                    $currentMonthEndDate = $currentDate->endOfMonth()->format('Y-m-d H:i:s');
                    $threeMonthsAgoStartDate = $currentDate->subMonths(2)->startOfMonth()->format('Y-m-d H:i:s');
                    $sixMonthsAgoStartDate = $currentDate->subMonths(5)->startOfMonth()->format('Y-m-d H:i:s');

                    $currentMonthCourse = Course::where('user_id', Auth::user()->id)
                        ->whereBetween('created_at', [$threeMonthsAgoStartDate, $currentMonthEndDate])
                        ->count();
                    $previousMonthCourse = Course::where('user_id', Auth::user()->id)
                        ->whereBetween('created_at', [$sixMonthsAgoStartDate, $threeMonthsAgoStartDate])
                        ->count();

                    $courses = Course::where('user_id', Auth::user()->id)->whereBetween('created_at', [$threeMonthsAgoStartDate, $currentMonthEndDate])->get();

                } elseif ($duration === 'six_months') {

                    $currentDate = Carbon::now();
                    $currentMonthStartDate = $currentDate->startOfMonth()->format('Y-m-d H:i:s');
                    $currentMonthEndDate = $currentDate->endOfMonth()->format('Y-m-d H:i:s');
                    $threeMonthsAgoStartDate = $currentDate->subMonths(2)->startOfMonth()->format('Y-m-d H:i:s');
                    $sixMonthsAgoStartDate = $currentDate->subMonths(5)->startOfMonth()->format('Y-m-d H:i:s');
                    $previousSixMonthsAgoStartDate = $currentDate->subMonths(11)->startOfMonth()->format('Y-m-d H:i:s');

                    $currentMonthCourse = Course::where('user_id', Auth::user()->id)
                        ->whereBetween('created_at', [$threeMonthsAgoStartDate, $currentMonthEndDate])
                        ->count();
                    $previousMonthCourse = Course::where('user_id', Auth::user()->id)
                        ->whereBetween('created_at', [$previousSixMonthsAgoStartDate, $sixMonthsAgoStartDate])
                        ->count();

                    $courses = Course::where('user_id', Auth::user()->id)->whereBetween('created_at', [$sixMonthsAgoStartDate, $currentMonthEndDate])->get();

                } elseif ($duration === 'one_year') {
                    $firstdayOfCurrentYear =  Carbon::now()->startOfYear()->format('Y-m-d H:i:s');
                    $lastDayOfCurrentYear =  Carbon::now()->endOfYear()->format('Y-m-d H:i:s');
                    $firstDayOfPreviousYear = Carbon::now()->subYear()->startOfYear()->format('Y-m-d H:i:s');
                    $lastDayOfPreviousYear = Carbon::now()->subYear()->endOfYear()->format('Y-m-d H:i:s');

                    $currentMonthCourse = Course::where('user_id', Auth::user()->id)
                        ->whereBetween('created_at', [$firstdayOfCurrentYear, $lastDayOfCurrentYear])
                        ->count();
                    $previousMonthCourse = Course::where('user_id', Auth::user()->id)
                        ->whereBetween('created_at', [$firstDayOfPreviousYear, $lastDayOfPreviousYear])
                        ->count();

                $courses = Course::where('user_id', Auth::user()->id)->whereBetween('created_at', [$firstdayOfCurrentYear, $lastDayOfCurrentYear])->get();

                }

            }else{
                $currentMonthCourse = Course::where('user_id', Auth::user()->id)
                    ->whereYear('created_at', '=', now()->year)
                    ->whereMonth('created_at', '=', now()->month)
                    ->count();
                $previousMonthCourse = Course::where('user_id', Auth::user()->id)
                    ->whereYear('created_at', '=', date('Y', strtotime('-1 month')))
                    ->whereMonth('created_at', '=', date('m', strtotime('-1 month')))
                    ->count();

                $courses = Course::where('user_id', Auth::user()->id)->get();

            }

          if ($previousMonthCourse === 0) {
              $percentageOfCourse = ($currentMonthCourse > 0) ? 100 : 0;
          } else {
              $percentageOfCourse = (($currentMonthCourse - $previousMonthCourse) / abs($previousMonthCourse)) * 100;
          }


          $allCategories = $courses->pluck('categories');
          $unique_array = [];
          foreach ($allCategories as $category) {
              $cats = explode(",", $category);
              foreach ($cats as $cat) {
                  $unique_array[] = strtolower($cat);
              }
          }


          foreach ($currentMonthEnrollments as $enrolment) {
              $currentMonthEnrolledStudents[$enrolment->user_id] = $enrolment->created_at;
          }
          foreach ($previousMonthEnrollments as $enrolment) {
              $previousMonthEnrolledStudents[$enrolment->user_id] = $enrolment->created_at;
          }
          
          // Also get students from course_user table for current period
          if (isset($firstDayOfCurrentMonth) && isset($lastDayOfCurrentMonth)) {
              $currentCourseUsers = DB::table('course_user')
                  ->join('courses', 'course_user.course_id', '=', 'courses.id')
                  ->where('courses.user_id', Auth::user()->id)
                  ->whereBetween('course_user.created_at', [$firstDayOfCurrentMonth, $lastDayOfCurrentMonth])
                  ->select('course_user.user_id', 'course_user.created_at')
                  ->get();
                  
              foreach ($currentCourseUsers as $courseUser) {
                  if (!isset($currentMonthEnrolledStudents[$courseUser->user_id])) {
                      $currentMonthEnrolledStudents[$courseUser->user_id] = $courseUser->created_at;
                  }
              }
          }
          
          // Also get students from course_user table for previous period
          if (isset($firstDayOfPreviousMonth) && isset($lastDayOfPreviousMonth)) {
              $previousCourseUsers = DB::table('course_user')
                  ->join('courses', 'course_user.course_id', '=', 'courses.id')
                  ->where('courses.user_id', Auth::user()->id)
                  ->whereBetween('course_user.created_at', [$firstDayOfPreviousMonth, $lastDayOfPreviousMonth])
                  ->select('course_user.user_id', 'course_user.created_at')
                  ->get();
                  
              foreach ($previousCourseUsers as $courseUser) {
                  if (!isset($previousMonthEnrolledStudents[$courseUser->user_id])) {
                      $previousMonthEnrolledStudents[$courseUser->user_id] = $courseUser->created_at;
                  }
              }
          }

          $currentMonthEnrolledStudentsCount = count($currentMonthEnrolledStudents);
        //   dd($currentMonthEnrolledStudentsCount);

          $previousMonthEnrolledStudentsCount = count($previousMonthEnrolledStudents);

          if ($previousMonthEnrolledStudentsCount === 0) {
              $percentageChangeOfStudentEnroll = ($currentMonthEnrolledStudentsCount > 0) ? 100 : 0;
          } else {
              $percentageChangeOfStudentEnroll = (($currentMonthEnrolledStudentsCount - $previousMonthEnrolledStudentsCount) / abs($previousMonthEnrolledStudentsCount)) * 100;
          }

          $formatedPercentageChangeOfStudentEnroll = number_format($percentageChangeOfStudentEnroll, 2);
          $formatedPercentageOfCourse = number_format($percentageOfCourse, 2);


        // course active or not count
        $activeCourses = 0;
        $draftCourses = 0;

        if ($courses) {
            foreach ($courses as $course) {

                if ($course->status == 'draft') {
                    $draftCourses++;
                } elseif ($course->status == 'published') {
                    $activeCourses++;
                }
            }
        }


        return view('dashboard/instructor/analytics-tailwind', compact('categories', 'courses', 'students', 'enrolments', 'course_wise_payments', 'activeInActiveStudents', 'earningByDates','earningByMonth','messages','formatedPercentageChangeOfStudentEnroll','formatedPercentageOfCourse','formattedPercentageChangeOfEarning','activeCourses','draftCourses','currentMonthEnrolledStudentsCount','analytics_title','compear','totalAmounts'));

    }


    private function getEnrollmentData($instructorId, $startDate, $endDate)
    {
        // Get both checkout and approved manual enrollments
        $checkoutData = Checkout::where('instructor_id', $instructorId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('id', 'desc')
            ->get();
            
        $manualData = CourseEnrollment::where('instructor_id', $instructorId)
            ->where('status', CourseEnrollment::STATUS_APPROVED)
            ->whereIn('payment_method', ['bkash', 'nogod', 'rocket'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('id', 'desc')
            ->get();
        
        return $checkoutData->merge($manualData);
    }

    public function analytics()
    {

        $recentUpdates = Notification::where('instructor_id',Auth::user()->id)->where('type','instructor')->orderBy('id','desc')->get();
        $payments = Checkout::courseEnrolledByInstructor()->where('instructor_id',Auth::user()->id)->paginate(12);
        $courses = Course::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(6);

        return view('dashboard/instructor/dashboard',compact('courses','payments','recentUpdates'));
    }

    // instructor notification
    public function notifications()
    {

        $currentYear = Carbon::now()->subDays(365);
        $today = Carbon::now();

        $data = Notification::leftJoin('users', 'notifications.user_id', '=', 'users.id')
            ->where('notifications.instructor_id', Auth::user()->id)  // Specify the table for instructor_id
            ->where('notifications.type', 'instructor')
            ->where('notifications.created_at', '>', $currentYear)
            ->join('courses', 'notifications.course_id', '=', 'courses.id')
            ->select('notifications.id', 'courses.thumbnail AS thumbnail', 'courses.title AS title', 'notifications.type','notifications.user_id','notifications.course_id',  'notifications.message', 'users.avatar', 'notifications.created_at')
            ->orderBy('notifications.created_at', 'DESC')
            ->get();


        // Get today's date
        $today = now();

        // Initialize arrays for each category
        $todays = [];
        $yestardays = [];
        $sevenDays = [];
        $thirtyDays = [];
        $lastOneYears = [];

        foreach ($data as $item) {
            $createdAt = $item['created_at']; // Assuming 'created_at' is already a Carbon instance

            // Calculate the interval in days
            $interval = $today->diffInDays($createdAt);

            if ($interval == 0) {
                // Today
                $todays[] = $item;
            } elseif ($interval == 1) {
                // Yesterday
                $yestardays[] = $item;
            } elseif ($interval > 2 && $interval <= 7) {
                // Last 7 days
                $sevenDays[] = $item;
            } elseif ($interval >= 8 && $interval <= 30) {

                $thirtyDays[] = $item;
            } elseif ($interval >= 31 && $interval <= 365) {

                $lastOneYears[] = $item;
            }
        }


        return view('instructor.notification',compact('todays','yestardays','sevenDays','thirtyDays','lastOneYears'));

    }

    // instructor notification delete
    public function notifyRemove($domain, $id)
    {
        $notify = Notification::find($id);
        $notify->delete();
        return redirect()->back()->with('success','Notification deleted successfully');
    }

    private function getActiveInActiveStudents($data)
    {
        $activeCountByDate = [];
        $inactiveCountByDate = [];

        $currentDate = Carbon::now();
        $dates = [];
        $active_students = [];
        $inactive_students = [];

        foreach ($data as $record) {
            $createdAt = Carbon::parse($record['created_at']);

            $endDate = Carbon::parse($record['end_date']);
            if ($currentDate < $endDate) {
                $status = 'active';
            } else {
                $status = 'inactive';
            }

            $createdDate = $createdAt->format('Y-m-d');
            $dates[] = $createdDate;
            if (!isset($activeCountByDate[$createdDate])) {
                $activeCountByDate[$createdDate] = 0;
            }

            if (!isset($inactiveCountByDate[$createdDate])) {
                $inactiveCountByDate[$createdDate] = 0;
            }

            if ($status === 'active') {
                $activeCountByDate[$createdDate]++;
            } else {
                $inactiveCountByDate[$createdDate]++;
            }
            $active_students[] = $activeCountByDate[$createdDate];
            $inactive_students[] = $inactiveCountByDate[$createdDate];
        }
        return ['dates' => $dates, 'active_students' => $active_students, 'inactive_students' => $inactive_students];
    }

    private function getEarningByDates($data)
    {
        $earningsByDate = [];

        foreach ($data as $record) {
            $createdAt = Carbon::parse($record['created_at']);
            $amount = $record['amount'];

            $createdDate = $createdAt->format('Y-m-d');

            if (!isset($earningsByDate[$createdDate])) {
                $earningsByDate[$createdDate] = 0;
            }

            $earningsByDate[$createdDate] += $amount;
        }

        return $earningsByDate;
    }

    private function getEarningByMonth($data)
    {
        $monthlySums = array_fill(0, 12, 0);

        // Iterate through the data array
        foreach ($data as $item) {
            // Extract the month from the created_at value
            $createdAt = Carbon::parse($item['created_at']);
            $month = intval($createdAt->format('m'));

            // Add the amount to the corresponding month's sum
            $monthlySums[$month - 1] += $item['amount'];
        }

        return $monthlySums;

    }

    private function getCourseWisePayments($enrolments)
    {
        $course_wise_payments = [];
        foreach ($enrolments as $enrolment) {
            $students[$enrolment->user_id] = $enrolment->user;
            if ($enrolment->course) {

                $title = substr($enrolment->course->title, 0, 20);
                if (strlen($enrolment->course->title) > 20) {
                    $title .= "...";
                }
                if (isset($course_wise_payments[$title])) {
                    $course_wise_payments[$title] = $course_wise_payments[$title] + $enrolment->amount;
                } else {
                    $course_wise_payments[$title] = $enrolment->amount;
                }
            }
        }
        return $course_wise_payments;
    }

    public function manageAccess(){

       $managePage = ManagePage::where('instructor_id',Auth::user()->id)->first();

       if ($managePage) {
            $permission = json_decode($managePage->pagePermissions);
       }else{
            $permission = json_decode('{"dashboard":1,"homePage":1,"messagePage":1,"certificatePage":1}');
       }

        return view('dashboard/instructor/access-page',compact('permission'));
    }

    public function pageAccess(Request $request){

        $validatedData = $request->validate([
            'dashboard' => 'boolean',
            'homePage' => 'boolean',
            'messagePage' => 'boolean',
            'certificatePage' => 'boolean',
        ]);

        $permissions = [
            'dashboard' => $request->input('dashboard', 0),
            'homePage' => $request->input('homePage', 0),
            'messagePage' => $request->input('messagePage', 0),
            'certificatePage' => $request->input('certificatePage', 0),
        ];

        $permissionsJson = json_encode($permissions);

        $managePage = ManagePage::updateOrCreate(
            ['instructor_id' => Auth::user()->id],
            ['pagePermissions' => $permissionsJson]
        );

        return redirect()->back()->with('success', 'Access permissions updated successfully');
    }


    public function earnings(Request $request)
    {
        $instructorId = Auth::user()->id;
        
        // Get checkout earnings - use course relationship instead of instructor_id
        $checkoutQuery = Checkout::whereHas('course', function($query) use ($instructorId) {
                $query->where('user_id', $instructorId);
            })
            ->with(['user', 'course'])
            ->orderBy('created_at', 'desc');
        
        // Get manual enrollment earnings - use course relationship instead of instructor_id   
        $manualQuery = CourseEnrollment::whereHas('course', function($query) use ($instructorId) {
                $query->where('user_id', $instructorId);
            })
            ->where('status', CourseEnrollment::STATUS_APPROVED)
            ->whereIn('payment_method', ['bkash', 'nogod', 'rocket'])
            ->with(['student', 'course'])
            ->orderBy('created_at', 'desc');
            
        // Apply filters to both queries
        if ($request->has('method') && $request->method) {
            $checkoutQuery->where('payment_method', $request->method);
            $manualQuery->where('payment_method', $request->method);
        }
        
        if ($request->has('date_from') && $request->date_from) {
            $checkoutQuery->whereDate('created_at', '>=', $request->date_from);
            $manualQuery->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $checkoutQuery->whereDate('created_at', '<=', $request->date_to);
            $manualQuery->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Get results and merge them
        $checkoutEarnings = $checkoutQuery->get();
        $manualEarnings = $manualQuery->get();
        $allEarnings = $checkoutEarnings->merge($manualEarnings)->sortByDesc('created_at');
        
        // Manual pagination
        $perPage = 15;
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $earnings = new \Illuminate\Pagination\LengthAwarePaginator(
            $allEarnings->slice($offset, $perPage)->values(),
            $allEarnings->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        // Calculate totals from both sources - use course relationship
        $totalCheckoutEarnings = Checkout::whereHas('course', function($query) use ($instructorId) {
                $query->where('user_id', $instructorId);
            })->sum('amount');
        $totalManualEarnings = CourseEnrollment::whereHas('course', function($query) use ($instructorId) {
                $query->where('user_id', $instructorId);
            })
            ->where('status', CourseEnrollment::STATUS_APPROVED)
            ->whereIn('payment_method', ['bkash', 'nogod', 'rocket'])
            ->sum('amount');
        $totalEarnings = $totalCheckoutEarnings + $totalManualEarnings;
        
        $monthlyCheckoutEarnings = Checkout::whereHas('course', function($query) use ($instructorId) {
                $query->where('user_id', $instructorId);
            })
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');
        $monthlyManualEarnings = CourseEnrollment::whereHas('course', function($query) use ($instructorId) {
                $query->where('user_id', $instructorId);
            })
            ->where('status', CourseEnrollment::STATUS_APPROVED)
            ->whereIn('payment_method', ['bkash', 'nogod', 'rocket'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');
        $monthlyEarnings = $monthlyCheckoutEarnings + $monthlyManualEarnings;
            
        $paymentMethods = ['bkash', 'nogod', 'rocket'];
        
        // Get all students from users table with user_role 'student'
        $students = User::where('user_role', 'student')
            ->orderBy('name')
            ->get();
        
        // Get instructor's courses
        $instructorCourses = Course::where('user_id', $instructorId)
            ->where('status', 'published')
            ->orderBy('title')
            ->get();
        
        return view('dashboard.instructor.earnings-tailwind', compact('earnings', 'totalEarnings', 'monthlyEarnings', 'paymentMethods', 'students', 'instructorCourses'));
    }

    /**
     * Show all students with option to grant free access
     */
    public function students(Request $request)
    {
        $search = $request->get('search');
        $instructorId = Auth::id();
        
        // Get students from checkout table (paid enrollments)
        $checkoutStudentsQuery = Checkout::whereHas('course', function($query) use ($instructorId) {
                $query->where('user_id', $instructorId);
            })
            ->with(['user', 'course'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%')
                      ->orWhere('email', 'LIKE', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc');

        // Get students from course_user pivot table (all enrollments including manual)
        $pivotStudentsQuery = DB::table('course_user')
            ->join('courses', 'course_user.course_id', '=', 'courses.id')
            ->join('users', 'course_user.user_id', '=', 'users.id')
            ->where('courses.user_id', $instructorId)
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('users.name', 'LIKE', '%' . $search . '%')
                      ->orWhere('users.email', 'LIKE', '%' . $search . '%');
                });
            })
            ->select(
                'users.id as user_id',
                'users.name',
                'users.email', 
                'users.avatar',
                'courses.id as course_id',
                'courses.title as course_title',
                'courses.thumbnail as course_thumbnail',
                'course_user.amount',
                'course_user.payment_method',
                'course_user.status',
                'course_user.created_at',
                'course_user.start_at',
                'course_user.end_at',
                DB::raw("'pivot' as enrollment_type")
            )
            ->orderBy('course_user.created_at', 'desc');

        // Get paginated results
        $checkoutStudents = $checkoutStudentsQuery->paginate(5, ['*'], 'checkout_page');
        $pivotStudents = $pivotStudentsQuery->paginate(5, ['*'], 'pivot_page');  

        // For combined view, merge all and paginate manually
        $allCheckouts = $checkoutStudentsQuery->get();
        $allPivots = $pivotStudentsQuery->get();
        
        // Combine all enrollments for pagination
        $combinedStudents = collect();
        
        // Add checkout students
        foreach ($allCheckouts as $checkout) {
            $combinedStudents->push((object)[
                'type' => 'checkout',
                'user_id' => $checkout->user_id,
                'user' => $checkout->user,
                'course' => $checkout->course,
                'amount' => $checkout->amount,
                'payment_method' => $checkout->payment_method,
                'created_at' => \Carbon\Carbon::parse($checkout->created_at),
                'start_date' => $checkout->start_date ? \Carbon\Carbon::parse($checkout->start_date) : null,
                'end_date' => $checkout->end_date ? \Carbon\Carbon::parse($checkout->end_date) : null,
                'enrollment' => $checkout
            ]);
        }
        
        // Add pivot students (exclude duplicates from checkout)
        $checkoutUserIds = $allCheckouts->pluck('user_id')->toArray();
        foreach ($allPivots as $pivot) {
            // Create a unique key combining user_id and course_id to avoid duplicates
            $uniqueKey = $pivot->user_id . '_' . $pivot->course_id;
            if (!in_array($uniqueKey, $checkoutUserIds)) {
                $user = (object)['id' => $pivot->user_id, 'name' => $pivot->name, 'email' => $pivot->email, 'avatar' => $pivot->avatar];
                $course = (object)['id' => $pivot->course_id, 'title' => $pivot->course_title, 'thumbnail' => $pivot->course_thumbnail];
                
                $combinedStudents->push((object)[
                    'type' => 'pivot',
                    'unique_key' => $uniqueKey,
                    'user_id' => $pivot->user_id,
                    'user' => $user,
                    'course' => $course,
                    'amount' => $pivot->amount,
                    'payment_method' => $pivot->payment_method,
                    'status' => $pivot->status,
                    'created_at' => \Carbon\Carbon::parse($pivot->created_at),
                    'start_date' => $pivot->start_at ? \Carbon\Carbon::parse($pivot->start_at) : null,
                    'end_date' => $pivot->end_at ? \Carbon\Carbon::parse($pivot->end_at) : null,
                    'enrollment' => $pivot
                ]);
            }
        }
        
        // Sort by created_at desc
        $combinedStudents = $combinedStudents->sortByDesc('created_at');
        
        // Manual pagination for combined results
        $perPage = 15;
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $students = new \Illuminate\Pagination\LengthAwarePaginator(
            $combinedStudents->slice($offset, $perPage)->values(),
            $combinedStudents->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Get instructor's courses for the grant access modal
        $instructorCourses = Course::where('user_id', $instructorId)
            ->select('id', 'title', 'price', 'offer_price', 'thumbnail')
            ->orderBy('title')
            ->get();

        // Calculate total unique students enrolled in this instructor's courses
        $checkoutUserIds = Checkout::whereHas('course', function($query) use ($instructorId) {
                $query->where('user_id', $instructorId);
            })->distinct()->pluck('user_id');
            
        $pivotUserIds = DB::table('course_user')
            ->join('courses', 'course_user.course_id', '=', 'courses.id')
            ->where('courses.user_id', $instructorId)
            ->distinct()
            ->pluck('course_user.user_id');
        
        $allUniqueUserIds = $checkoutUserIds->merge($pivotUserIds)->unique();
        $totalStudents = $allUniqueUserIds->count();

        // Calculate total earnings from all sources
        $checkoutEarnings = Checkout::whereHas('course', function($query) use ($instructorId) {
                $query->where('user_id', $instructorId);
            })
            ->where('payment_status', 'completed')
            ->sum('amount');
            
        $pivotEarnings = DB::table('course_user')
            ->join('courses', 'course_user.course_id', '=', 'courses.id')
            ->where('courses.user_id', $instructorId)
            ->where('course_user.paid', true)
            ->sum('course_user.amount');
            
        $totalEarnings = $checkoutEarnings + $pivotEarnings;

        return view('dashboard.instructor.students-tailwind', compact('students', 'instructorCourses', 'totalStudents', 'totalEarnings', 'checkoutStudents', 'pivotStudents'));
    }

    /**
     * Show individual student profile
     */
    public function showStudentProfile($studentId)
    {
        $student = User::where('user_role', 'student')
            ->where('id', $studentId)
            ->with(['enrollments' => function($query) {
                $query->whereHas('course', function($courseQuery) {
                    $courseQuery->where('user_id', Auth::id());
                })->with('course:id,title,thumbnail,price,offer_price');
            }])
            ->firstOrFail();

        // Get instructor's courses that this student is NOT enrolled in
        $enrolledCourseIds = $student->enrollments->pluck('course_id')->toArray();
        
        $availableCourses = Course::where('user_id', Auth::id())
            ->whereNotIn('id', $enrolledCourseIds)
            ->select('id', 'title', 'price', 'offer_price', 'thumbnail')
            ->orderBy('title')
            ->get();

        return view('instructor.students.profile', compact('student', 'availableCourses'));
    }

    public function addEarning(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:bkash,nogod,rocket',
            'transaction_id' => 'nullable|string|min:5|max:100',
            'sender_number' => 'nullable|string|max:15',
            'payment_date' => 'nullable|date|before_or_equal:today',
            'notes' => 'nullable|string|max:500'
        ], [
            'user_id.required' => 'শিক্ষার্থী নির্বাচন করুন',
            'course_id.required' => 'কোর্স নির্বাচন করুন',
            'amount.required' => 'পেমেন্ট পরিমাণ প্রবেশ করান',
            'amount.min' => 'পেমেন্ট পরিমাণ কমপক্ষে ১ টাকা হতে হবে',
            'payment_method.required' => 'পেমেন্ট পদ্ধতি নির্বাচন করুন',
            'transaction_id.min' => 'ট্রানজেকশন আইডি কমপক্ষে ৫ অক্ষর হতে হবে',
            'payment_date.before_or_equal' => 'পেমেন্টের তারিখ আজকের তারিখের চেয়ে বড় হতে পারে না',
        ]);
        
        // Get the course to enroll the student
        $course = Course::findOrFail($request->course_id);
        
        // Check if student is already enrolled in this course
        $existingEnrollment = $course->students()->wherePivot('user_id', $request->user_id)->exists();
        
        if ($existingEnrollment) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'এই শিক্ষার্থী ইতিমধ্যে এই কোর্সে ভর্তি আছে!');
        }
        
        // Check if transaction ID is provided and already exists
        if ($request->transaction_id) {
            $existingTransaction = Checkout::where('transaction_id', $request->transaction_id)
                ->where('payment_method', $request->payment_method)
                ->first();
                
            if ($existingTransaction) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'এই ট্রানজেকশন আইডি ইতিমধ্যে ব্যবহৃত হয়েছে!');
            }
        }
        
        try {
            DB::beginTransaction();
            
            $start_date = now();
            $end_date = now()->addYear(); // 1 year access
            
            // Step 1: Attach the student to the course (course_user pivot table)
            $course->students()->attach($request->user_id, [
                'payment_method' => $request->payment_method,
                'amount' => $request->amount,
                'paid' => true,
                'start_at' => $start_date,
                'end_at' => $end_date,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Step 2: Create checkout record for tracking
            $checkout = new Checkout();
            $checkout->user_id = $request->user_id;
            $checkout->course_id = $request->course_id;
            $checkout->instructor_id = Auth::user()->id;
            $checkout->amount = $request->amount;
            $checkout->payment_method = $request->payment_method;
            $checkout->transaction_id = $request->transaction_id ?: 'MANUAL_' . time() . '_' . $request->user_id;
            $checkout->sender_number = $request->sender_number;
            $checkout->payment_date = $request->payment_date ? $request->payment_date : now();
            $checkout->payment_status = 'completed';
            $checkout->status = 'completed';
            $checkout->is_manual = true;
            $checkout->notes = $request->notes;
            $checkout->start_date = $start_date;
            $checkout->end_date = $end_date;
            $checkout->payment_id = 'MANUAL_' . strtoupper($request->payment_method) . '_' . time();
            
            // Store additional payment details as JSON
            $checkout->payment_details = [
                'added_by' => Auth::user()->id,
                'added_at' => now(),
                'method_display_name' => $request->payment_method,
                'verification_status' => 'verified'
            ];
            
            $checkout->save();
            
            // Step 3: Create notification for instructor
            $instructorNotification = new Notification([
                'user_id' => $request->user_id,
                'instructor_id' => Auth::user()->id,
                'course_id' => $request->course_id,
                'type' => 'instructor',
                'message' => 'manual_enrollment',
                'status' => 'unseen',
            ]);
            $instructorNotification->save();
            
            // Step 4: Create notification for student (optional)
            $studentNotification = new Notification([
                'user_id' => $request->user_id,
                'instructor_id' => Auth::user()->id,
                'course_id' => $request->course_id,
                'type' => 'student',
                'message' => 'enrolled',
                'status' => 'unseen',
            ]);
            $studentNotification->save();
            
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'পেমেন্ট যোগ করতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
        
        return redirect()->back()->with('success', 'পেমেন্ট সফলভাবে যোগ করা হয়েছে!');
    }

    // login as student
    public function loginAsStudent($userSessionId, $userId, $stuId)
    {

        if (!$userId || !$userSessionId) {
            return redirect('/login')->with('error', 'Failed to Login as Student');
        }

        $instructorUserId = Crypt::decrypt($userId);

        $instructorUser = User::find($instructorUserId);

        $keysToForget = ['userId', 'userRole'];

        foreach ($keysToForget as $key) {
            if (session()->has($key)) {
                session()->forget($key);
            }
        }
        session(['userId' => encrypt($instructorUser->id), 'userRole' => $instructorUser->user_role]);

        if (!$instructorUser) {
            return redirect('/login')->with('error', 'Failed to Login as Student');
        }

        $reqSessionId = Crypt::decrypt($userSessionId);
        $dbSessionId = Crypt::decrypt($instructorUser->session_id);

        if ($reqSessionId === $dbSessionId && $stuId) {
            $studentUserId = Crypt::decrypt($stuId);
            $studentUser = User::find($studentUserId);

            if ($studentUser) {
                Auth::logout();
                Auth::login($studentUser);
                return redirect('student/dashboard')->with('success', 'You have successfully logged into the profile of '.$studentUser->name);
            }
        }

        return redirect('/login')->with('error', 'Failed to Login as Student');
    }

}
