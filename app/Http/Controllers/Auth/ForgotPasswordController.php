<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;

use App\Models\InstructorModuleSetting;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        $subdomain = explode('.', request()->getHost())[0];
        if($subdomain != 'app'){
            $instrcutor = User::where('subdomain', $subdomain)->firstOrFail();
            $instrcutorModuleSettings = InstructorModuleSetting::where('instructor_id', $instrcutor->id)->first();

            if ($instrcutorModuleSettings) {
                $loginPageStyle = json_decode($instrcutorModuleSettings->value);
            } else {
                $loginPageStyle = json_decode("{'primary_color':','secondary_color':','lp_layout':','meta_title':','meta_desc':'}");
            }

            if (isset($loginPageStyle) && property_exists($loginPageStyle, 'lp_layout')) {
                if ($loginPageStyle->lp_layout == 'fullwidth') {
                    return view('custom-auth/passwords/email2');
                } elseif ($loginPageStyle->lp_layout == 'default') {
                    return view('custom-auth/passwords/email');
                } elseif ($loginPageStyle->lp_layout == 'leftsidebar') {
                    return view('custom-auth/passwords/email5');
                } elseif ($loginPageStyle->lp_layout == 'rightsidebar') {
                    return view('custom-auth/passwords/email4');
                } else {
                    return view('custom-auth/passwords/email');
                }
            } else {
                return view('custom-auth.passwords.email');
            }
        }
        return view('custom-auth.passwords.email');
    }


    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()->with('success', trans($response));
    }

}
