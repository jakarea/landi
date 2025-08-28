<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserCreated;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class RegisterController extends Controller implements CreatesNewUsers
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses Fortify to
    | provide this functionality.
    |
     */



    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'user_role' => ['required', 'string', 'in:student,instructor'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'company_name' => ['nullable', 'string', 'max:255', 'required_if:user_role,instructor'],
        ]);
    }

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm(): View
    {
        return view('/auth/register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request): RedirectResponse
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user));

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return redirect($this->redirectTo);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function create(array $data): User
    {
        $serverName = request()->getHost();
        $subdomain = explode('.', $serverName)[0];
        
        $email_verified_at = $data['user_role'] === 'student' ? now() : null;
        $subdomain = $data['user_role'] === 'instructor' ? null : $subdomain;

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'email_verified_at' => $email_verified_at,
            'company_name' => $data['company_name'] ?? '',
            'user_role' => $data['user_role'],
            'password' => Hash::make($data['password']),
            'subdomain' => $subdomain
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function registered(Request $request, User $user): RedirectResponse
    {
        // Send the registration email
        Mail::to($user)->send(new UserCreated($user));

        // Log out the user since email verification is required for instructors
        if ($user->user_role === 'instructor') {
            auth()->logout();
            return redirect()->route('login')
                ->with('success', 'Your account has been created. Please check your email for verification.');
        }

        // For students, redirect to home with success message
        return redirect($this->redirectTo)
            ->with('success', 'Your account has been created successfully.');
    }

}
