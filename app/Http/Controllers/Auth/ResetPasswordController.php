<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\InstructorModuleSetting;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm(Request $request, $token = null){

        $email = $request->email;
        $subdomain = explode('.', request()->getHost())[0];
        if($subdomain == 'app'){
            return view('custom-auth/passwords/reset')->with(['token' => $token, 'email' => $email]);
        }
        $instrcutor = User::where('subdomain', $subdomain)->firstOrFail();
        $instrcutorModuleSettings = InstructorModuleSetting::where('instructor_id', $instrcutor->id)->first();

        if ($instrcutorModuleSettings) {
            $loginPageStyle = json_decode($instrcutorModuleSettings->value);
        } else {
            $loginPageStyle = json_decode("{'primary_color':','secondary_color':','lp_layout':','meta_title':','meta_desc':'}");
        }

        if (isset($loginPageStyle) && property_exists($loginPageStyle, 'lp_layout')) {
            if ($loginPageStyle->lp_layout == 'fullwidth') {
                return view('custom-auth/passwords/reset2')->with(['token' => $token, 'email' => $email]);
            } elseif ($loginPageStyle->lp_layout == 'default') {
                return view('custom-auth/passwords/reset')->with(['token' => $token, 'email' => $email]);
            } elseif ($loginPageStyle->lp_layout == 'leftsidebar') {
                return view('custom-auth/passwords/reset5')->with(['token' => $token, 'email' => $email]);
            } elseif ($loginPageStyle->lp_layout == 'rightsidebar') {
                return view('custom-auth/passwords/reset4')->with(['token' => $token, 'email' => $email]);
            } else {
                return view('custom-auth/passwords/reset')->with(['token' => $token, 'email' => $email]);
            }
        } else {
            return view('custom-auth/passwords/reset')->with(['token' => $token, 'email' => $email]);
        }
    }
}
