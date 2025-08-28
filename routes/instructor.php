<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseCreateStepController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Instructor\DashboardController;
use App\Http\Controllers\ProfileManagementController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\CourseEnrollmentController;
use App\Http\Controllers\Builder\LandingPageBuilderController;

/*
|--------------------------------------------------------------------------
| Instructor Routes
|--------------------------------------------------------------------------
|
| All routes for instructors including dashboard, profile management,
| course creation, course management, students management, and earnings.
|
*/

Route::middleware(['auth', 'verified', 'role:instructor'])->group(function () {
    
    // ========================================
    // DASHBOARD & PROFILE MANAGEMENT
    // ========================================
    
    Route::get('/instructor/dashboard', [DashboardController::class, 'index'])->name('instructor.dashboard');
    
    // Profile & Settings
    Route::get('/instructor/profile/myprofile', [ProfileManagementController::class, 'show'])->name('instructor.profile');
    Route::post('/instructor/profile/cover/upload', [ProfileManagementController::class, 'coverUpload']);
    Route::post('/instructor/profile/update', [ProfileManagementController::class, 'update'])->name('instructor.profile.update');
    Route::get('/instructor/profile/change-password', [ProfileManagementController::class, 'passwordUpdate']);
    Route::post('/instructor/profile/change-password', [ProfileManagementController::class, 'postChangePassword'])->name('instructor.password.update');
    Route::get('/instructor/profile/account-settings', [ProfileManagementController::class, 'edit'])->name('account.settings');
    
    // Experience Management
    Route::post('/instructor/profile/experience/add', [ExperienceController::class, 'store'])->name('instructor.profile.experience');
    Route::get('/instructor/profile/experience/{experienceId}/edit', [ExperienceController::class, 'edit'])->name('instructor.edit.experience');
    Route::put('/instructor/profile/experience/{experienceId}', [ExperienceController::class, 'update'])->name('instructor.profile.experience.update');
    Route::delete('/instructor/profile/experience/{experienceId}', [ExperienceController::class, 'destroy'])->name('instructor.delete.experience');
    
    // Payment Settings
    Route::post('/instructor/payment/update', [ProfileManagementController::class, 'updatePaymentSettings'])->name('instructor.payment.update');
    
    // ========================================
    // STUDENTS MANAGEMENT
    // ========================================
    
    Route::get('/instructor/students', [DashboardController::class, 'students'])->name('instructor.students');
    Route::get('/instructor/students/{student}', [DashboardController::class, 'showStudentProfile'])->name('instructor.students.profile');
    
    // ========================================
    // EARNINGS MANAGEMENT
    // ========================================
    
    Route::get('/instructor/earnings', [DashboardController::class, 'earnings'])->name('instructor.earnings');
    Route::post('/instructor/earnings/add', [DashboardController::class, 'addEarning'])->name('instructor.earnings.add');
    
    // ========================================
    // NOTIFICATIONS
    // ========================================
    
    Route::get('/instructor/notifications', [DashboardController::class, 'notifications'])->name('instructor.notifications');
    
    // ========================================
    // COURSE MANAGEMENT ROUTES
    // ========================================
    
    // Course Management
    Route::get('/instructor/courses', [CourseController::class, 'index'])->name('instructor.courses.index');
    Route::get('/instructor/courses/{id}', [CourseController::class, 'show'])->whereNumber('id')->name('instructor.courses.show');
    Route::get('/instructor/courses/overview/{slug}', [CourseController::class, 'overview'])->name('instructor.courses.overview');
    Route::get('/instructor/courses/overview/{slug}/preview', [CourseController::class, 'preview'])->name('instructor.courses.overview.preview');
    Route::get('/instructor/courses/file-download/{course_id}/{extension}', [CourseController::class, 'fileDownload'])->name('instructor.courses.file.download');
    Route::delete('/instructor/courses/{id}', [CourseController::class, 'destroy'])->name('instructor.courses.destroy');
    Route::get('/instructor/courses-log', [CourseController::class, 'storeCourseLog'])->name('instructor.log.courses');
    
    // Alternative route names for backward compatibility
    Route::get('/instructor/courses', [CourseController::class, 'index'])->name('instructor.courses');
    Route::delete('/instructor/courses/{id}/destroy', [CourseController::class, 'destroy'])->name('course.destroy');
    Route::get('/instructor/courses/overview/{slug}', [CourseController::class,'overview'])->name('instructor.course.overview');
    Route::get('/instructor/courses/overview/{slug}/preview', [CourseController::class,'preview'])->name('instructor.course.overview.preview');
    Route::get('/instructor/courses/file-download/{course_id}/{extension}', [CourseController::class,'fileDownload'])->name('instructor.file.download');
    Route::get('/instructor/courses/{id}', [CourseController::class,'show'])->name('course.show')->where('id', '[0-9]+');

    // ========================================
    // COURSE CREATION ROUTES
    // ========================================
    
    // Main course creation flow
    Route::get('/instructor/courses/create', [CourseCreateStepController::class, 'facts'])->name('course.create.step-1');
    Route::post('/instructor/courses/create', [CourseCreateStepController::class, 'storeFacts'])->name('course.create.step-1save');
    
    // Course Facts (Step 1)
    Route::get('/instructor/courses/create/{id}/facts', [CourseCreateStepController::class, 'facts'])->name('course.create.facts');
    Route::post('/instructor/courses/create/{id?}/facts', [CourseCreateStepController::class, 'storeFacts'])->name('course.store.facts');
    
    // Course Objects (Step 2)
    Route::get('/instructor/courses/create/{id}/objects', [CourseCreateStepController::class, 'courseObjects'])->name('course.create.object');
    Route::post('/instructor/courses/create/{id}/objects', [CourseCreateStepController::class, 'courseObjectsSet'])->name('course.objects.store');
    Route::post('/instructor/courses/create/{courseId}/delete-objects/{dataIndex}', [CourseCreateStepController::class, 'deleteObjective'])->name('course.objects.delete');
    Route::post('/instructor/courses/create/updateObjectives/{id}', [CourseCreateStepController::class, 'updateObjectives'])->name('course.objectives.update');
    Route::post('/instructor/courses/create/{id}/who-should-join', [CourseCreateStepController::class, 'whoShouldJoin'])->name('course.who-should-join.store');
    Route::post('/instructor/courses/create/{courseId}/delete-who-should-join/{dataIndex}', [CourseCreateStepController::class, 'deleteWhoShouldJoin'])->name('course.who-should-join.delete');
    
    // Course Price (Step 3)
    Route::get('/instructor/courses/create/{id}/price', [CourseCreateStepController::class, 'coursePrice'])->name('course.create.price');
    Route::post('/instructor/courses/create/{id}/price', [CourseCreateStepController::class, 'coursePriceSet'])->name('course.price.store');
    
    // Course Design (Step 4)
    Route::get('/instructor/courses/create/{id}/design', [CourseCreateStepController::class, 'courseDesign'])->name('course.create.design');
    Route::post('/instructor/courses/create/{id}/design', [CourseCreateStepController::class, 'courseDesignSet'])->name('course.design.store');
    
    // Course Content (Step 5)
    Route::get('/instructor/courses/create/{id}/content', [CourseCreateStepController::class, 'step1a'])->name('course.content.step');
    Route::post('/instructor/courses/create/{id}/content', [CourseCreateStepController::class, 'step1a'])->name('course.content.step.post');
    
    // Course Certificate (Step 6)
    Route::get('/instructor/courses/create/{id}/certificate', [CourseCreateStepController::class, 'courseCertificate'])->name('course.create.certificate');
    Route::post('/instructor/courses/create/{id}/certificate', [CourseCreateStepController::class, 'courseCertificateSet'])->name('course.certificate.store');
    Route::delete('/instructor/courses/create/{id}/certificate/remove', [CourseCreateStepController::class, 'courseCertificateRemove'])->name('course.certificate.remove');
    
    // Course Visibility (Step 7)
    Route::get('/instructor/courses/create/{id}/visibility', [CourseCreateStepController::class, 'visibility'])->name('course.create.visibility');
    Route::post('/instructor/courses/create/{id}/visibility', [CourseCreateStepController::class, 'visibilitySet'])->name('course.visibility.store');
    
    // Course Share (Step 8)
    Route::get('/instructor/courses/create/{id}/share', [CourseCreateStepController::class, 'courseShare'])->name('course.create.share');
    Route::get('/instructor/courses/create/{id}/finish', [CourseCreateStepController::class, 'finish'])->name('course.create.finish');
    Route::get('/instructor/finish/edit', [CourseCreateStepController::class, 'finishEdit'])->name('course.finish.edit');

    // ========================================
    // MODULE MANAGEMENT ROUTES
    // ========================================
    
    // Module creation and management
    Route::post('/instructor/courses/create/{id}/module', [CourseCreateStepController::class, 'module'])->name('course.module.step.create');
    Route::post('/instructor/courses/create/{id}/facts-update', [CourseCreateStepController::class, 'step3cu'])->name('course.module.step.update');
    Route::post('/instructor/module/sortable', [CourseCreateStepController::class, 'moduleResorting'])->name('instructor.module.sortable');
    Route::delete('/instructor/module/{id}/delete', [CourseCreateStepController::class, 'destroyModule'])->name('instructor.module.delete');

    // ========================================
    // LESSON MANAGEMENT ROUTES
    // ========================================
    
    // Lesson creation and management
    Route::post('/instructor/courses/create/{course_id}/module/{module_id}', [CourseCreateStepController::class, 'addLesson'])->name('course.lesson.step.create');
    Route::post('/instructor/courses/create/{id}/facts-update', [CourseCreateStepController::class, 'step3d'])->name('course.lesson.step.update');
    Route::post('/instructor/module/lesson/sortable', [CourseCreateStepController::class, 'moduleLessonResorting'])->name('instructor.module.lesson.sortable');
    Route::delete('/instructor/lesson/{id}/delete', [CourseCreateStepController::class, 'destroyLesson'])->name('instructor.lesson.delete');
    
    // Lesson content management - Text
    Route::get('/instructor/courses/create/{id}/text/{module_id}/content/{lesson_id}', [CourseCreateStepController::class, 'stepLessonText'])->name('course.lesson.text');
    Route::post('/instructor/courses/create/{lesson_id}/step-lesson-content', [CourseCreateStepController::class, 'stepLessonContent'])->name('course.lesson.text.update');
    
    // Lesson content management - Audio
    Route::get('/instructor/courses/create/{id}/audio/{module_id}/content/{lesson_id}', [CourseCreateStepController::class, 'stepLessonAudio'])->name('course.lesson.audio');
    Route::post('/instructor/courses/create/{id}/audio/{module_id}/content/{lesson_id}', [CourseCreateStepController::class, 'stepLessonAudioSet'])->name('course.lesson.audio.create');
    Route::get('/instructor/courses/create/{id}/audio/{module_id}/content/{lesson_id}/remove', [CourseCreateStepController::class, 'stepLessonAudioRemove'])->name('course.lesson.audio.remove');
    
    // Lesson content management - Video
    Route::get('/instructor/courses/create/{id}/video/{module_id}/content/{lesson_id}', [CourseCreateStepController::class, 'stepLessonVideo'])->name('course.lesson.video');
    Route::post('/instructor/courses/create/{id}/video/{module_id}/content/{lesson_id}', [CourseCreateStepController::class, 'stepLessonVideoSet'])->name('course.lesson.video.create');
    Route::get('/instructor/courses/create/{id}/video/{module_id}/content/{lesson_id}/remove', [CourseCreateStepController::class, 'stepLessonVideoRemove'])->name('course.lesson.video.remove');
    
    // Lesson file management
    Route::get('/instructor/courses/create/{id}/file/{module_id}/content/{lesson_id}/remove', [CourseCreateStepController::class, 'stepLessonFileRemove'])->name('course.lesson.file.remove');
    
    // Lesson institute
    Route::get('/instructor/courses/create/{id}/lesson/{module_id}/institute/{lesson_id}', [CourseCreateStepController::class, 'stepLessonInstitue'])->name('course.lesson.institute');

    // ========================================
    // CERTIFICATE MANAGEMENT ROUTES
    // ========================================
    
    // Certificate management
    Route::post('/instructor/profile/certificate-settings', [CertificateController::class, 'certificateUpdate'])->name('certificate.update');
    Route::get('/instructor/profile/certificate-edit/{id}', [CertificateController::class, 'certificateEdit'])->name('certificate.edit');
    Route::post('/instructor/profile/certificate-generate', [CertificateController::class,'customCertificate'])->name('certificate.generate');
    Route::post('/instructor/profile/certificate-delete/{id}', [CertificateController::class,'certificateDelete'])->name('certificate.delete');
    
    // ========================================
    // SETTINGS
    // ========================================
    
    Route::post('/instructor/settings/vimeo/request', [SettingsController::class,'vimeoUpdate'])->name('instructor.vimeo.update');
    
    // ========================================
    // ENROLLMENT MANAGEMENT
    // ========================================
    
    Route::get('/instructor/enrollments/pending', [CourseEnrollmentController::class, 'pendingEnrollments'])->name('instructor.enrollments.pending');
    Route::get('/instructor/enrollments/payment-pending', [CourseEnrollmentController::class, 'paymentPendingEnrollments'])->name('instructor.enrollments.payment-pending');
    Route::get('/instructor/enrollments/all', [CourseEnrollmentController::class, 'allEnrollments'])->name('instructor.enrollments.all');
    Route::patch('/instructor/enrollments/{enrollment}/approve', [CourseEnrollmentController::class, 'approve'])->name('instructor.enrollments.approve');
    Route::patch('/instructor/enrollments/{enrollment}/approve-without-payment', [CourseEnrollmentController::class, 'approveWithoutPayment'])->name('instructor.enrollments.approve-without-payment');
    Route::patch('/instructor/enrollments/{enrollment}/reject', [CourseEnrollmentController::class, 'reject'])->name('instructor.enrollments.reject');
    Route::patch('/instructor/enrollments/{enrollment}/reapprove', [CourseEnrollmentController::class, 'reapprove'])->name('instructor.enrollments.reapprove');
    Route::post('/instructor/grant-free-access', [CourseEnrollmentController::class, 'grantFreeAccess'])->name('instructor.grant-free-access');
    
    // ========================================
    // COUPON MANAGEMENT
    // ========================================
    
    Route::get('/instructor/coupons', [CouponController::class, 'index'])->name('instructor.coupons.index');
    Route::get('/instructor/coupons/create', [CouponController::class, 'create'])->name('instructor.coupons.create');
    Route::post('/instructor/coupons', [CouponController::class, 'store'])->name('instructor.coupons.store');
    Route::get('/instructor/coupons/{coupon}', [CouponController::class, 'show'])->name('instructor.coupons.show');
    Route::get('/instructor/coupons/{coupon}/edit', [CouponController::class, 'edit'])->name('instructor.coupons.edit');
    Route::put('/instructor/coupons/{coupon}', [CouponController::class, 'update'])->name('instructor.coupons.update');
    Route::delete('/instructor/coupons/{coupon}', [CouponController::class, 'destroy'])->name('instructor.coupons.destroy');
    Route::patch('/instructor/coupons/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->name('instructor.coupons.toggle-status');
    
    // ========================================
    // LANDING PAGE BUILDER
    // ========================================
    
    Route::prefix('builder')->group(function () {
        Route::get('/editor/{course_id}', [LandingPageBuilderController::class, 'editor'])->name('builder.editor');
        Route::post('/save', [LandingPageBuilderController::class, 'save'])->name('builder.save');
        Route::get('/preview/{id}', [LandingPageBuilderController::class, 'preview'])->name('builder.preview');
        Route::post('/publish/{id}', [LandingPageBuilderController::class, 'publish'])->name('builder.publish');
    });
});