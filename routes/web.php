<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Frontend\HomepageController;
use App\Http\Controllers\Instructor\DashboardController;
use App\Http\Controllers\Student\StudentHomeController;
use App\Http\Controllers\Builder\LandingPageBuilderController;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|
| These routes are accessible to all users (both authenticated and guest).
| This includes homepage, authentication, public course listings, and
| developer utilities.
|
*/

// ========================================
// PUBLIC ROUTES
// ========================================

Route::get('/', [HomepageController::class, 'homepage'])->name('homepage');
Route::view('/error-design', 'errors.404')->name('error.design');

// Public course routes (accessible to all users)
Route::get('/courses', [CourseController::class, 'publicIndex'])->name('courses.public.index');
Route::get('/courses/{slug}', [CourseController::class, 'publicOverview'])->name('courses.public.overview');

// Public landing pages
Route::get('/landing/{slug}', [LandingPageBuilderController::class, 'show'])->name('landing.show');

// AI Bootcamp Landing Page
Route::get('/ai-for-advertising-bootcamp-25', function () {
    return view('landing.ai-bootcamp');
})->name('ai.bootcamp.landing');

// ========================================
// ROLE-BASED DASHBOARD REDIRECT
// ========================================

Route::get('/home', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    $user = Auth::user();
    
    switch($user->user_role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'instructor':
            return redirect()->route('instructor.dashboard');
        case 'student':
            return redirect()->route('students.dashboard');
        default:
            return redirect()->route('homepage');
    }
})->name('home')->middleware('auth');

// ========================================
// AUTHENTICATION ROUTES (GUEST ONLY)
// ========================================

Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', function () {
        if (request()->has('signature')) {
            $user = User::where('session_id', request()->signature)->first();
            if ($user) {
                Auth::login($user);
                $user->update(['session_id' => null]);
                return redirect()->intended($user->user_role . '/dashboard');
            }
        }
        return view('auth.login');
    })->name('login');

    // Registration Routes
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');

    // Social Login Routes
    Route::get('/login/{provider}', [LoginController::class, 'socialLogin'])->whereIn('provider', ['facebook', 'google', 'apple'])->name('social.login');
    Route::get('/login/{provider}/callback', [LoginController::class, 'handleProviderCallback'])->whereIn('provider', ['facebook', 'google', 'apple'])->name('social.callback');
});

// Logout Route (Authenticated users only)
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ========================================
// EMAIL VERIFICATION ROUTES
// ========================================

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [VerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.resend');
});

// ========================================
// IMPERSONATION ROUTES
// ========================================

Route::get('/switch/login-as-instructor/{session}/{user}/{instructor}', [HomepageController::class, 'loginAsInstructor'])->name('switch.login.instructor');
Route::get('/switch/login-as-student/{session}/{user}/{student}', [HomepageController::class, 'loginAsStudent'])->name('switch.login.student');
Route::get('/switch/instructor-login-as-student/{session}/{user}/{student}', [DashboardController::class, 'loginAsStudent'])->name('switch.instructor.login.student');
Route::get('/switch/back-to-pavilion/{user}', [StudentHomeController::class, 'backToPavilion'])->name('switch.back.pavilion');

// ========================================
// ADMIN ROUTES
// ========================================

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('e-learning/course/admin/dashboard');
    })->name('admin.dashboard');
});

// ========================================
// DEVELOPER UTILITY ROUTES
// ========================================

if (app()->environment(['local', 'staging'])) {
    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('clear-compiled');
        return redirect()->route('home');
    })->name('dev.clear.cache');

    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        return redirect()->route('home');
    })->name('dev.storage.link');
}