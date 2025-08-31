<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\CartController;
use App\Http\Controllers\NotificationController;
// use App\Http\Controllers\Payment\PaymentController;
// use App\Http\Controllers\Student\CheckoutController;
use App\Http\Controllers\Student\StudentHomeController;
// use App\Http\Controllers\Student\CheckoutBundleController;
use App\Http\Controllers\Student\StudentProfileController;
// use App\Http\Controllers\CourseEnrollmentController;

/*
|--------------------------------------------------------------------------
| Student Routes - Clean Folder Structure
|--------------------------------------------------------------------------
|
| Clean URL structure following folder hierarchy:
| /student/ -> Dashboard
| /student/courses/ -> Course catalog
| /student/courses/{slug}/ -> Course overview
| /student/courses/{slug}/learn/ -> Learning interface
| /student/profile/ -> Profile management
| /student/certificates/ -> Certificates
| /student/activities/ -> Course activities
|
*/

// ========================================
// GUEST ACCESSIBLE ROUTES
// ========================================

// Route::post('/student/stripe-process-payment', [PaymentController::class, 'processPayment'])->name('process-payment');
Route::get('/student/notifications/', [NotificationController::class, 'notificationDetails'])->name('student.notifications');
Route::post('/student/notifications/{id}/destroy', [NotificationController::class, 'destroy'])->name('student.notifications.destroy');

// ========================================
// AUTHENTICATED STUDENT ROUTES
// ========================================
Route::middleware(['auth', 'role:student'])->group(function () {

    // ========================================
    // MAIN DASHBOARD
    // ========================================
    
    Route::get('student/', [StudentHomeController::class, 'dashboard'])->name('student.dashboard');
    
    // ========================================
    // COURSES SECTION
    // ========================================
    
    Route::get('/student/courses/', [StudentHomeController::class, 'enrolledCourses'])->name('student.courses');
    Route::get('/student/courses/{slug}/', [StudentHomeController::class, 'courseOverview'])->name('student.courses.overview');
    Route::get('/student/courses/{slug}/learn/', [StudentHomeController::class, 'show'])->name('student.courses.learn');
    
    // Course interactions
    Route::post('/student/courses/{slug}/', [StudentHomeController::class, 'review'])->name('student.courses.review');
    Route::post('/student/courses/{slug}/like/', [StudentHomeController::class, 'courseLike'])->name('student.courses.like');
    Route::post('/student/courses/{slug}/unlike/', [StudentHomeController::class, 'courseUnLike'])->name('student.courses.unlike');
    
    // Course logging and progress
    Route::match(['GET', 'POST'], '/student/courses/log/', [StudentHomeController::class, 'storeCourseLog'])->name('student.log.courses');
    Route::get('/student/courses/complete-lesson', [StudentHomeController::class, 'storeActivity'])->name('student.complete.lesson');
    
    // ========================================
    // PROFILE SECTION
    // ========================================
    
    Route::get('/student/profile/', [StudentProfileController::class, 'show'])->name('student.profile');
    Route::get('/student/profile/edit/', [StudentProfileController::class, 'edit'])->name('student.profile.edit');
    Route::post('/student/profile/edit/', [StudentProfileController::class, 'update'])->name('student.profile.update');
    Route::post('/student/profile/cover/', [StudentProfileController::class, 'coverUpload'])->name('student.profile.cover');
    Route::get('/student/profile/password/', [StudentProfileController::class, 'passwordUpdate'])->name('student.profile.password');
    Route::post('/student/profile/password/', [StudentProfileController::class, 'postChangePassword'])->name('student.profile.password.update');
    
    // ========================================
    // CERTIFICATES SECTION
    // ========================================
    
    Route::get('/student/certificates/', [StudentHomeController::class, 'certificates'])->name('student.certificates');
    Route::get('/student/certificates/{slug}/', [StudentHomeController::class, 'certificateView'])->name('student.certificates.view');
    Route::get('/student/certificates/{slug}/download/', [StudentHomeController::class, 'certificateDownload'])->name('student.certificates.download');
    
    // ========================================
    // ACTIVITIES SECTION
    // ========================================
    
    Route::get('/student/activities/', [StudentHomeController::class, 'activities'])->name('student.activities');
    Route::post('/student/activities/complete/', [StudentHomeController::class, 'completeActivity'])->name('student.activities.complete');
    
    // ========================================
    // CART SECTION (Disabled for now)
    // ========================================
    
    // Route::get('/student/cart/', [CartController::class, 'index'])->name('student.cart');
    // Route::post('/student/cart/add/{course}/', [CartController::class, 'add'])->name('cart.add');
    // Route::post('/student/cart/remove/{id}/', [CartController::class, 'remove'])->name('cart.remove');
    
    // ========================================
    // CHECKOUT SECTION (Disabled for now)
    // ========================================
    
    // Route::get('/student/checkout/', [CheckoutController::class, 'indexOfCart'])->name('student.checkout');
    // Route::get('/student/checkout/{slug}/', [CheckoutController::class, 'index'])->name('student.checkout.course');
    // Route::post('/student/checkout/{slug}/', [CheckoutController::class, 'store'])->name('student.checkout.store');
    // Route::get('/student/checkout/{slug}/success/', [CheckoutController::class, 'success'])->name('student.checkout.success');
    // Route::get('/student/checkout/{slug}/cancel/', [CheckoutController::class, 'cancel'])->name('student.checkout.cancel');
    
    // ========================================
    // FILES & DOWNLOADS
    // ========================================
    
    Route::get('/student/files/{course_id}/{extension}/', [StudentHomeController::class, 'fileDownload'])->name('student.files.download');

});

// ========================================
// GUEST CART ROUTES (Disabled for now)
// ========================================

// Route::post('/student/cart/guest/{course}/', [CartController::class, 'addToCartSkippLogin'])->name('student.cart.guest');

