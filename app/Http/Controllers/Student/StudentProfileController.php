<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\PasswordChanged;
use App\Models\Checkout;
use App\Models\CourseActivity;
use App\Mail\ProfileUpdated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class StudentProfileController extends Controller
{
    // profile show
    public function show()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        
        // Get purchased courses from Checkout table
        $checkout = Checkout::where('user_id', $id)->with('course.user')->get();
        
        // Get enrolled courses from CourseEnrollment table
        $enrolledCourses = \App\Models\CourseEnrollment::where('user_id', $id)
            ->where('status', 'approved')
            ->with('course.user')
            ->get();
            
        // Combine both collections for display
        $allEnrollments = collect();
        
        // Add checkout courses
        foreach ($checkout as $purchase) {
            if ($purchase->course) {
                $allEnrollments->push([
                    'type' => 'purchase',
                    'id' => $purchase->payment_id ?? $purchase->id,
                    'course' => $purchase->course,
                    'instructor' => $purchase->course->user,
                    'date' => $purchase->created_at,
                    'amount' => $purchase->amount,
                    'status' => $purchase->payment_status === 'completed' ? 'Paid' : $purchase->payment_status,
                    'original' => $purchase
                ]);
            }
        }
        
        // Add enrolled courses (free or approved)
        foreach ($enrolledCourses as $enrollment) {
            if ($enrollment->course) {
                $allEnrollments->push([
                    'type' => 'enrollment',
                    'id' => 'ENR-' . $enrollment->id,
                    'course' => $enrollment->course,
                    'instructor' => $enrollment->course->user,
                    'date' => $enrollment->created_at,
                    'amount' => $enrollment->amount ?? 0,
                    'status' => $enrollment->paid ? 'Paid' : 'Free Access',
                    'original' => $enrollment
                ]);
            }
        }
        
        // Sort by date (newest first)
        $allEnrollments = $allEnrollments->sortByDesc('date');
        
        // Get course likes for the current user
        $userLikes = \App\Models\course_like::where('user_id', $id)
            ->pluck('course_id')
            ->toArray();
        
        $totalTimeSpend = CourseActivity::where('user_id', $id)->where('is_completed',1)->sum('duration');
        
        return view('profile/students/profile',compact('user','checkout','allEnrollments','totalTimeSpend','userLikes'));
    }

    // profile edit
    public function edit()
    {
        $userId = Auth()->user()->id;
        $user = User::find($userId);
        return view('profile/students/edit',compact('user'));
    }

    public function update(Request $request)
    {
        $userId = Auth()->user()->id;

        $this->validate($request, [
            'name' => 'required|string',
            'short_bio' => 'string',
            'phone' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072', // 3MB
        ],
        [
            // 'base64_avatar' => 'Max file size is 5 MB!',
             'phone' => 'Phone Number is required'
        ]);


        $user = User::where('id', $userId)->first();
        $user->name = $request->name;
        $user->company_name = $request->company_name;
        $user->short_bio = $request->website;
        $user->social_links = implode(",",$request->social_links);
        $user->phone = $request->phone;
        $user->description = $request->description;
        $user->recivingMessage = $request->recivingMessage ? true : false;
        $user->email = $user->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }else{
            $user->password = $user->password;
        }

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar) {
                $oldFile = public_path($user->avatar);
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }
            
            // Upload new avatar
            $uploadPath = 'uploads/users';
            if (!file_exists(public_path($uploadPath))) {
                mkdir(public_path($uploadPath), 0755, true);
            }
            
            $slugg = Str::slug($request->name);
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $uniqueFileName = $slugg . '-' . uniqid() . '.' . $extension;
            
            $request->file('avatar')->move(public_path($uploadPath), $uniqueFileName);
            $user->avatar = $uploadPath . '/' . $uniqueFileName;
        }

        $user->save();

        // Send email
        Mail::to($user->email)->send(new ProfileUpdated($user));

        return redirect()->route('student.profile.edit', ['tab' => 'profile'])->with('success', 'Your Profile has been Updated successfully!');
    }

    // password update
    public function passwordUpdate()
    {
        // Redirect to edit page with password tab active
        return redirect()->route('student.profile.edit', ['tab' => 'password']);
    }

    public function postChangePassword(Request $request)
    {
        //  return $request->all();

        //validate password and confirm password
        $this->validate($request, [
            'password' => 'required|confirmed|min:6|string',
        ]);

        $userId = Auth()->user()->id;
        $user = User::where('id', $userId)->first();
        $user->password = Hash::make($request->password);
        $user->save();

         // Send email
         Mail::to($user->email)->send(new PasswordChanged($user));

        return redirect()->route('student.profile.edit', ['tab' => 'password'])->with('success', 'Your password has been changed successfully!');
    }

    public function coverUpload(Request $request)
    {

        if ($request->cover_photo != NULL) {

            $userId = $request->userId;
            $base64ImageCover = $request->cover_photo;
            $user = User::where('id', $userId)->first();

            if ($user->cover_photo) {
                $oldFile = public_path($user->cover_photo);
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }
            list($type, $data) = explode(';', $base64ImageCover);
            list(, $data) = explode(',', $data);
            $decodedImage = base64_decode($data);
            $slugg = Str::slug($user->name ?? 'user');
            $uniqueFileName = $slugg . '-' . uniqid() . '.png';
            
            // Create directory if it doesn't exist
            $uploadDir = public_path('uploads/users/');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Save directly to public/uploads/users/
            $filePath = $uploadDir . $uniqueFileName;
            file_put_contents($filePath, $decodedImage);
            
            // Store relative path in database
            $user->cover_photo = 'uploads/users/' . $uniqueFileName;

            $user->save();
            return response()->json(['message' => "UPLOADED"]);
         }

        return response()->json(['error' => 'No cover image uploaded'], 400);
    }

    // Password setup for new users
    public function setupPassword()
    {
        $user = Auth::user();

        // Check if user already has a permanent password (created via normal registration)
        if (!Str::startsWith($user->password, '$2y$')) {
            // This means it's a temporary password, show setup form
            return view('student.setup-password', compact('user'));
        }

        // If already has permanent password, redirect to dashboard
        return redirect()->route('student.dashboard');
    }

    public function storePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6|string',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        // Send welcome email
        Mail::to($user->email)->send(new PasswordChanged($user));

        return redirect()->route('student.dashboard')->with('success', 'আপনার পাসওয়ার্ড সফলভাবে সেট করা হয়েছে! এখন আপনি আপনার কোর্স অ্যাক্সেস করতে পারবেন।');
    }
}
