<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Models\User;
use App\Models\Course;
use App\Models\Experience;
use App\Models\Certificate;
use Illuminate\Support\Str;
use App\Mail\ProfileUpdated;
use App\Mail\PasswordChanged;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileManagementController extends Controller
{

    // profile show
    public function show()
    {
        // dark mode preference session forgot
        if (session()->has('preferenceMode')) {
            session()->forget('preferenceMode');
        }

        $id = Auth::user()->id;
        $user = User::find($id);
        $courses = Course::where('user_id', $id)->get();
        $experiences = Experience::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        return view('profile/instructor/profile',compact('user','courses','experiences'));
    }

    // profile edit
    public function edit(Request $request, $domain, $experience_id = '')
    {

        $userId = Auth()->user()->id;
        $user = User::find($userId);
        $editExp = '';
        if($experience_id){
            $editExp = Experience::where('id', $experience_id)->first();
        }
        $experiences = Experience::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        $courses = Course::where('instructor_id', $userId)->get();
        $certificates = Certificate::where('instructor_id', $userId)->with('course')->orderBy('id','desc')->get();

        return view('profile/instructor/edit',compact('user','experiences','editExp','courses','certificates'));
    }

    public function deleteExperience($domain, $experience_id)
    {
        if($experience_id){
            $experiences = Experience::where(['id' => $experience_id, 'user_id' => Auth::user()->id])->firstOrFail();
            $experiences->delete();
        }
        return back()->with(["success" => "Experience deleted successfully!"]);
    }





    public function update(Request $request)
    {
        // return $request->all();
        $userId = auth()->user()->id;

        $this->validate($request, [
            'name' => 'required|string',
            'short_bio' => 'string',
            'phone' => 'required|string',
            'base64_avatar' => 'nullable|string',
            // 'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:5000',
        ],
        [
            'base64_avatar' => 'Max file size is 5 MB!',
             'phone' => 'Phone Number is required'
        ]);

        $user = User::where('id', $userId)->first();
        $user->name = $request->name;
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

        if ($request->base64_avatar != NULL) {
            $base64Image = $request->input('base64_avatar');
            if ($user->avatar) {
                $oldFile = public_path($user->avatar);
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }
            
            // Create uploads/users directory if it doesn't exist
            $uploadPath = public_path('uploads/users');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            list($type, $data) = explode(';', $base64Image);
            list(, $data) = explode(',', $data);
            $decodedImage = base64_decode($data);
            $slugg = Str::slug($request->name);
            $uniqueFileName = $slugg . '-' . uniqid() . '.png';
            $fullPath = $uploadPath . '/' . $uniqueFileName;
            
            // Save directly to public/uploads/users
            file_put_contents($fullPath, $decodedImage);
            $user->avatar = 'uploads/users/' . $uniqueFileName;
         }

        $user->save();

        // Send email
        Mail::to($user->email)->send(new ProfileUpdated($user));

        return redirect()->route('instructor.profile', config('app.subdomain'))->with('success', 'Your Profile has been Updated successfully!');
    }


    // password update
    public function passwordUpdate()
    {
        $userId = Auth()->user()->id;
        $user = User::find($userId);

        return view('profile/instructor/password-change',compact('user'));
    }

    public function postChangePassword(Request $request)
    {
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

        return redirect()->route('instructor.profile',['subdomain' => config('app.subdomain')])->with('success', 'Your password has been changed successfully!');
    }

   //  upload cover photo for instructor
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
        
        // Create uploads/users directory if it doesn't exist
        $uploadPath = public_path('uploads/users');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        list($type, $data) = explode(';', $base64ImageCover);
        list(, $data) = explode(',', $data);
        $decodedImage = base64_decode($data);
        $slugg = Str::slug($request->name);
        $uniqueFileName = $slugg . '-cover-' . uniqid() . '.png';
        $fullPath = $uploadPath . '/' . $uniqueFileName;
        
        // Save directly to public/uploads/users
        file_put_contents($fullPath, $decodedImage);
        $user->cover_photo = 'uploads/users/' . $uniqueFileName;

        $user->save();
        return response()->json(['message' => "UPLOADED"]);
     }

    return response()->json(['error' => 'No cover image uploaded'], 400);

   }

   /**
    * Update payment settings for instructor
    */
   public function updatePaymentSettings(Request $request)
   {
       $paymentType = $request->payment_type;
       $userId = Auth::id();

       $this->validate($request, [
           'payment_type' => 'required|in:bkash,nogod,rocket',
           $paymentType . '_number' => 'required|string|max:15',
       ]);

       $user = User::find($userId);
       
       switch($paymentType) {
           case 'bkash':
               $user->bkash_number = $request->bkash_number;
               break;
           case 'nogod':
               $user->nogod_number = $request->nogod_number;
               break;
           case 'rocket':
               $user->rocket_number = $request->rocket_number;
               break;
       }
       
       $user->save();

       return redirect()->back()->with('success', ucfirst($paymentType) . ' number updated successfully!');
   }
}
