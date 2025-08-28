<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Notification;
Use \Carbon\Carbon;


class NotificationController extends Controller
{
    public function notificationDetails()
    {
        $unseens = Notification::where('user_id',Auth::user()->id)->where('status','unseen')->select('id','user_id','status')->get();
        foreach ($unseens as $key => $unseen)
        {
            Notification::where('user_id',Auth::user()->id)->where('status','unseen')->update(['status'=>'seen']);
        }
        $currentYear = Carbon::now()->subDays(365);
        $today = Carbon::now();
       $data = Notification::leftJoin('users', 'notifications.user_id', '=', 'users.id')
       ->where('notifications.user_id', Auth::user()->id)
       ->whereYear('notifications.created_at', '>', $currentYear)
       ->join('courses', 'notifications.course_id', '=', 'courses.id')
       ->select('notifications.id', 'courses.thumbnail AS thumbnail','courses.title AS title', 'notifications.type','notifications.course_id', 'notifications.message', 'users.avatar', 'notifications.created_at')
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

        return view('instructor.notification.system',compact('todays','yestardays','sevenDays','thirtyDays','lastOneYears'));
    }

    public function destroy($id){
        // return $id;

        $notify = Notification::where('id', $id)->first();
        $notify->delete();

        return redirect()->back()->with('success', 'Notification Successfuly Deleted!');
    }
}
