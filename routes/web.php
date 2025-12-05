<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Frontend\HomepageController;
use App\Http\Controllers\Instructor\DashboardController;
use App\Http\Controllers\Student\StudentHomeController;
use App\Http\Controllers\Builder\LandingPageBuilderController;
use App\Http\Controllers\Admin\CMSManageController;
use App\Http\Controllers\LandingController;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes - Clean Folder Structure
|--------------------------------------------------------------------------
|
| Clean URL structure for guest users:
| / -> Homepage
| /courses/ -> Course catalog
| /courses/{slug}/ -> Course overview
| /auth/login/ -> Authentication
| /landing/ -> Landing pages
| /about/ -> About page
| /contact/ -> Contact page
| /help/ -> Help & support
|
*/

// ========================================
// MAIN HOMEPAGE
// ========================================

Route::get('/', [HomepageController::class, 'homepage'])->name('home'); 

// ========================================
// COURSES SECTION
// ========================================

Route::get('/courses/', [CourseController::class, 'publicIndex'])->name('courses');
Route::get('/fun-app/', [CourseController::class, 'funApp'])->name('fun.app');
Route::get('/courses/{slug}/', [CourseController::class, 'publicOverview'])->name('courses.overview');

// Course enrollment routes
Route::middleware('auth')->group(function () {
    Route::get('/courses/{slug}/enroll/', [\App\Http\Controllers\CourseEnrollmentController::class, 'show'])->name('courses.enroll');
    Route::post('/courses/{slug}/enroll/', [\App\Http\Controllers\CourseEnrollmentController::class, 'store'])->name('courses.enroll.store');
});

// ========================================
// BLOG SECTION (AI আপডেট)
// ========================================

Route::get('/ai-update/', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/ai-update/{slug}/', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

// ========================================
// COMING SOON PAGES
// ========================================

Route::get('/expert-connection/', function () {
    return view('coming-soon');
})->name('expert.connection');


// ========================================
// LANDING PAGES SECTION
// ========================================

Route::get('/landing/', [LandingPageBuilderController::class, 'index'])->name('landing');
Route::get('/landing/{slug}/', [LandingPageBuilderController::class, 'show'])->name('landing.show');

// AI for Advertising Bootcamp Static Landing Page
Route::get('/ai-for-advertising-bootcamp-25', [LandingController::class, 'aiBootcamp'])->name('ai-bootcamp-25');
Route::get('/AI-for-Advertising-Bootcamp-25/', [LandingController::class, 'aiBootcamp'])->name('ai-bootcamp-25-alt');

// AI Bootcamp Enrollment
Route::post('/ai-for-advertising-bootcamp-25', [LandingController::class, 'enrollBootcamp'])->name('ai-bootcamp.enroll');

// ========================================
// ABOUT & INFORMATION PAGES
// ========================================

Route::get('/about/', [HomepageController::class, 'about'])->name('about');
Route::get('/contact/', [HomepageController::class, 'contact'])->name('contact');
Route::get('/help/', [HomepageController::class, 'help'])->name('help');

// ========================================
// AUTHENTICATION SECTION
// ========================================

Route::prefix('auth')->group(function () {
    
    Route::middleware('guest')->group(function () {
        // Login Routes
        Route::get('/login/', function () {
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
        Route::post('/login/', [LoginController::class, 'login'])->name('login.post');

        // Registration Routes
        Route::get('/register/', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register/', [RegisterController::class, 'register'])->name('register.store');

        // Social Login Routes
        Route::get('/login/{provider}/', [LoginController::class, 'socialLogin'])->whereIn('provider', ['facebook', 'google', 'apple'])->name('social.login');
        Route::get('/login/{provider}/callback/', [LoginController::class, 'handleProviderCallback'])->whereIn('provider', ['facebook', 'google', 'apple'])->name('social.callback');
    });

    // Email verification routes (authenticated users)
    Route::middleware('auth')->group(function () {
        Route::get('/verify/', [VerificationController::class, 'show'])->name('verification.notice');
        Route::get('/verify/{id}/{hash}/', [VerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
        Route::post('/verify/resend/', [VerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.resend');
    });
});

// Logout Routes (Authenticated users only)
Route::match(['get', 'post'], '/auth/logout/', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ========================================
// ROLE-BASED DASHBOARD REDIRECT
// ========================================

Route::get('/dashboard/', function () {
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
            return redirect()->route('student.dashboard');
        default:
            return redirect()->route('home');
    }
})->name('dashboard')->middleware('auth');

// ========================================
// ADMIN SECTION
// ========================================

Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/dashboard/', function () {
        return view('e-learning/course/admin/dashboard');
    })->name('admin.dashboard');
});

// Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard'); 

// ========================================
// LIVE CLASSES ROUTES (STUDENT ONLY)
// ========================================

// Live classes functionality has been integrated into the course system
// Students can access live lessons through their enrolled courses

// ========================================
// DEVICE MANAGEMENT ROUTES (STUDENT ONLY)
// ========================================

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/devices', [App\Http\Controllers\DeviceController::class, 'index'])->name('devices.index');
    Route::delete('/devices/{sessionId}', [App\Http\Controllers\DeviceController::class, 'revoke'])->name('devices.revoke');
    Route::delete('/devices-revoke-all', [App\Http\Controllers\DeviceController::class, 'revokeAll'])->name('devices.revoke.all');

});

// ========================================
// SYSTEM UTILITIES (Hidden from guests)
// ========================================

Route::prefix('system')->middleware('auth')->group(function () {
    Route::get('/switch/login-as-instructor/{session}/{user}/{instructor}/', [HomepageController::class, 'loginAsInstructor'])->name('system.login.instructor');
    Route::get('/switch/login-as-student/{session}/{user}/{student}/', [HomepageController::class, 'loginAsStudent'])->name('system.login.student');
    Route::get('/switch/instructor-login-as-student/{session}/{user}/{student}/', [DashboardController::class, 'loginAsStudent'])->name('system.instructor.login.student');
    Route::get('/switch/back-to-pavilion/{user}/', [StudentHomeController::class, 'backToPavilion'])->name('system.back.pavilion');
});

// ========================================
// CMS Manage System
// ========================================

Route::prefix('cms/')->middleware(['auth', 'role:admin,instructor'])->group(function () { 
    Route::get('/list', [CMSManageController::class, 'index'])->name('cms.list');
    Route::get('/page-section/edit/{id}', [CMSManageController::class, 'edit'])->name('cms.page-section.edit');
    Route::put('/page-section/update/{id}', [CMSManageController::class, 'update'])->name('cms.page-section.update');
    
    // Review Management Routes
    Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class, [
        'as' => 'cms'
    ]);

    // Blog Management Routes
    Route::resource('ai-update', \App\Http\Controllers\Admin\BlogManageController::class, [
        'as' => 'cms'
    ]);
});

// ========================================
// DEVELOPER UTILITY ROUTES (Local/Staging Only)
// ========================================

if (app()->environment(['local', 'staging'])) {
    Route::prefix('dev')->group(function () {
        Route::get('/clear-cache/', function () {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            Artisan::call('clear-compiled');
            return redirect()->route('home');
        })->name('dev.clear.cache');

        Route::get('/storage-link/', function () {
            Artisan::call('storage:link');
            return redirect()->route('home');
        })->name('dev.storage.link');
        
        Route::get('/error-design/', function () {
            return view('errors.404');
        })->name('dev.error.design');
    });
}