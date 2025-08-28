<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Student\CheckoutController;
use App\Http\Controllers\Student\StudentHomeController;
use App\Http\Controllers\Student\CheckoutBundleController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Http\Controllers\CourseEnrollmentController;

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
|
| All routes for students including dashboard, course access, profile
| management, notifications, cart functionality, and enrollments.
|
*/

// ========================================
// PAYMENT ROUTES (Guest accessible)
// ========================================

Route::post('/student/stripe-process-payment', [PaymentController::class, 'processPayment'])->name('process-payment');

// ========================================
// NOTIFICATION ROUTES (Guest accessible)
// ========================================

Route::get('student/notification-details', [NotificationController::class, 'notificationDetails'])->name('notification.details');
Route::post('student/notification-details/destroy/{id}', [NotificationController::class, 'destroy'])->name('notification.destroy');

// ========================================
// AUTHENTICATED STUDENT ROUTES
// ========================================

Route::middleware(['auth', 'role:student'])->group(function () {

    // ========================================
    // DASHBOARD & HOME
    // ========================================
    
    Route::get('student/dashboard', [StudentHomeController::class, 'dashboard'])->name('students.dashboard')->middleware('page.access');
    Route::get('student/dashboard/enrolled', [StudentHomeController::class,'enrolled'])->name('students.dashboard.enrolled');
    Route::get('student/home', [StudentHomeController::class, 'catalog'])->name('students.catalog.courses')->middleware('page.access');

    // ========================================
    // COURSE ACCESS & MANAGEMENT
    // ========================================
    
    Route::get('student/catalog/courses', [StudentHomeController::class,'catalog'])->name('students.catalog.courses');
    Route::get('student/courses/{slug}', [StudentHomeController::class,'show'])->name('students.show.courses');
    Route::get('student/courses/overview/{slug}', [StudentHomeController::class, 'overview'])->name('students.overview.courses');
    Route::get('student/courses/my-courses/details/{slug}', [StudentHomeController::class, 'courseDetails'])->name('students.overview.myCourses');
    
    // Course Files & Downloads
    Route::get('student/file-download/{course_id}/{extension}', [StudentHomeController::class, 'fileDownload'])->name('file.download');
    
    // Course Certificates
    Route::get('student/certificate-download/{slug}', [StudentHomeController::class, 'certificateDownload'])->name('students.download.courses-certificate');
    Route::get('student/certificate-view/{slug}', [StudentHomeController::class, 'certificateView'])->name('students.view.courses-certificate');
    Route::get('student/courses-certificate', [StudentHomeController::class, 'certificate'])->name('students.certificate.course')->middleware('page.access');
    
    // Course Progress & Activities
    Route::get('student/courses-log', [StudentHomeController::class, 'storeCourseLog'])->name('students.log.courses');
    Route::get('student/courses-activies/list', [StudentHomeController::class, 'activitiesList'])->name('students.activity.lesson');
    Route::get('student/courses-activies', [StudentHomeController::class, 'storeActivities'])->name('students.complete.lesson');
    
    // Course Interactions
    Route::post('student/courses/{slug}', [StudentHomeController::class, 'review'])->name('students.review.courses');
    Route::get('student/courses/{slug}/message', [StudentHomeController::class, 'message'])->name('students.courses.message');
    Route::post('student/course-like/{course_id}/{ins_id}', [StudentHomeController::class, 'courseLike'])->name('students.course.like');
    Route::post('student/course-unlike/{course_id}/{ins_id}', [StudentHomeController::class, 'courseUnLike'])->name('students.course.unlike');

    // ========================================
    // CHECKOUT ROUTES
    // ========================================
    
    Route::get('checkout/{slug}', [CheckoutController::class, 'index'])->name('students.checkout');
    Route::get('checkout/', [CheckoutController::class, 'indexOfCart'])->name('students.checkout.cart');
    Route::post('checkout/{slug}', [CheckoutController::class, 'store'])->name('students.checkout.store');
    Route::get('checkout/{slug}/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('checkout/{slug}/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

    // ========================================
    // BUNDLE CHECKOUT ROUTES
    // ========================================
    
    Route::get('bundle/checkout/{slug}', [CheckoutBundleController::class, 'index'])->name('students.bundle.checkout');
    Route::post('bundle/checkout/{slug}', [CheckoutBundleController::class, 'store'])->name('students.bundle.checkout.store');
    Route::get('bundle/checkout/{slug}/success', [CheckoutBundleController::class, 'success'])->name('bundle.checkout.success');
    Route::get('bundle/checkout/{slug}/cancel', [CheckoutBundleController::class, 'cancel'])->name('bundle.checkout.cancel');

    // ========================================
    // PROFILE MANAGEMENT
    // ========================================
    
    Route::get('student/profile/myprofile', [StudentProfileController::class, 'show'])->name('students.profile');
    Route::get('student/profile/edit', [StudentProfileController::class, 'edit']);
    Route::post('student/profile/cover/upload', [StudentProfileController::class, 'coverUpload']);
    Route::post('student/profile/edit', [StudentProfileController::class, 'update'])->name('students.profile.update');
    Route::get('student/profile/change-password', [StudentProfileController::class, 'passwordUpdate']);
    Route::post('student/profile/change-password', [StudentProfileController::class, 'postChangePassword'])->name('students.password.update');
    Route::get('student/account-management', [StudentHomeController::class, 'accountManagement'])->name('students.account.management');

    // ========================================
    // CART MANAGEMENT
    // ========================================
    
    Route::get('student/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('student/cart/add/{course}', [CartController::class, 'add'])->name('cart.add');
    Route::post('student/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('student/cart/buycourse/{id}', [CartController::class, 'buyCourse'])->name('buy.course');
    
    // ========================================
    // ENROLLMENT MANAGEMENT
    // ========================================
    
    Route::get('/courses/{course}/enroll', [CourseEnrollmentController::class, 'show'])->name('courses.enroll');
    Route::post('/courses/{course}/enroll', [CourseEnrollmentController::class, 'store'])->name('courses.enroll.store');
    Route::get('/student/my-enrollments', [CourseEnrollmentController::class, 'myEnrollments'])->name('student.enrollments');
});

// ========================================
// CART ROUTES (Guest accessible for adding without login)
// ========================================

Route::post('student/cart/added/{course}', [CartController::class, 'addToCartSkippLogin'])->name('cart.added');
Route::post('student/cart/bundle/{bundlecourse}', [CartController::class, 'addToCartBundlekippLogin'])->name('cart.added.bundle');

