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
use App\Http\Controllers\Instructor;

/*
|--------------------------------------------------------------------------
| Instructor Routes - Clean Folder Structure
|--------------------------------------------------------------------------
|
| Professional URL structure for instructors:
| /instructor/ -> Dashboard
| /instructor/profile/ -> Profile management
| /instructor/courses/ -> Course management
| /instructor/courses/create/ -> Course creation wizard
| /instructor/students/ -> Student management
| /instructor/earnings/ -> Earnings & analytics
| /instructor/enrollments/ -> Enrollment management
| /instructor/certificates/ -> Certificate management
| /instructor/coupons/ -> Coupon management
| /instructor/builder/ -> Landing page builder
|
*/

Route::middleware(['auth', 'verified', 'role:instructor'])->group(function () {
    
    // ========================================
    // MAIN DASHBOARD
    // ========================================
    
    Route::get('/instructor/', [DashboardController::class, 'index'])->name('instructor.dashboard');
    Route::get('/instructor/notifications/', [DashboardController::class, 'notifications'])->name('instructor.notifications');
    Route::post('/instructor/notifications/{id}/destroy', [DashboardController::class, 'notifyRemove'])->name('instructor.notify.destroy');
    
    // ========================================
    // PROFILE SECTION
    // ========================================
    
    Route::prefix('instructor/profile')->group(function () {
        // Main profile routes
        Route::get('/', [ProfileManagementController::class, 'show'])->name('instructor.profile');
        Route::get('/edit', [ProfileManagementController::class, 'edit'])->name('instructor.profile.edit');
        Route::post('/update', [ProfileManagementController::class, 'update'])->name('instructor.profile.update');
        Route::post('/cover', [ProfileManagementController::class, 'coverUpload'])->name('instructor.profile.cover');
        
        // Settings and password management
        Route::get('/settings', [ProfileManagementController::class, 'edit'])->name('instructor.profile.settings');
        Route::get('/password', [ProfileManagementController::class, 'passwordUpdate'])->name('instructor.profile.password');
        Route::post('/password', [ProfileManagementController::class, 'postChangePassword'])->name('instructor.profile.password.update');
        Route::post('/payment', [ProfileManagementController::class, 'updatePaymentSettings'])->name('instructor.profile.payment');
        Route::post('/marketing', [ProfileManagementController::class, 'updateMarketingSettings'])->name('instructor.profile.marketing.update');
        
        // Experience Management
        Route::prefix('experiences')->group(function () {
            Route::post('/', [ExperienceController::class, 'store'])->name('instructor.profile.experience.store');
            Route::get('/{experienceId}/edit', [ExperienceController::class, 'edit'])->name('instructor.profile.experience.edit');
            Route::put('/{experienceId}', [ExperienceController::class, 'update'])->name('instructor.profile.experience.update');
            Route::delete('/{experienceId}', [ExperienceController::class, 'destroy'])->name('instructor.profile.experience.delete');
        });
    });
    
    // ========================================
    // STUDENTS SECTION
    // ========================================
    
    Route::prefix('instructor/students')->group(function () {
        Route::get('/', [DashboardController::class, 'students'])->name('instructor.students');
        Route::get('/{student}/', [DashboardController::class, 'showStudentProfile'])->name('instructor.students.profile');
    });
    
    // ========================================
    // EARNINGS SECTION
    // ========================================
    
    Route::prefix('instructor/earnings')->group(function () {
        Route::get('/', [DashboardController::class, 'earnings'])->name('instructor.earnings');
        Route::post('/add/', [DashboardController::class, 'addEarning'])->name('instructor.earnings.add');
    });
    
    // ========================================
    // COURSES SECTION
    // ========================================
    
    Route::prefix('instructor/courses')->group(function () {
        // Course listing and management
        Route::get('/', [CourseController::class, 'index'])->name('instructor.courses');
        
        // Specific routes MUST come before {slug} route
        Route::get('/create/', [CourseCreateStepController::class, 'facts'])->name('instructor.courses.create');
        Route::get('/logs/', [CourseController::class, 'showCourseLogs'])->name('instructor.courses.logs');
        Route::get('/files/{course_id}/{extension}/', [CourseController::class, 'fileDownload'])->name('instructor.courses.files');
        
        // Dynamic slug routes come LAST
        Route::get('/{slug}/', [CourseController::class, 'courseOverview'])->name('instructor.courses.show');
        Route::delete('/{id}/', [CourseController::class, 'destroy'])->name('instructor.courses.destroy');
    });

    // ========================================
    // COURSE CREATION WIZARD
    // ========================================
    
    Route::prefix('instructor/courses/create')->group(function () {
        // Course creation form submission
        Route::post('/', [CourseCreateStepController::class, 'storeFacts'])->name('instructor.courses.create.start');
        
        // Wizard steps for specific course
        Route::prefix('{id}')->group(function () {
            // Step 1: Course Facts
            Route::get('/facts/', [CourseCreateStepController::class, 'facts'])->name('instructor.courses.create.facts');
            Route::post('/facts/', [CourseCreateStepController::class, 'storeFacts'])->name('instructor.courses.create.facts.store');
            
            // Step 2: Course Objectives
            Route::get('/objectives/', [CourseCreateStepController::class, 'courseObjects'])->name('instructor.courses.create.objectives');
            Route::post('/objectives/', [CourseCreateStepController::class, 'courseObjectsSet'])->name('instructor.courses.create.objectives.store');
            Route::post('/objectives/update/', [CourseCreateStepController::class, 'updateObjectives'])->name('instructor.courses.create.objectives.update');
            Route::delete('/objectives/{dataIndex}/', [CourseCreateStepController::class, 'deleteObjective'])->name('instructor.courses.create.objectives.delete');
            Route::post('/audience/', [CourseCreateStepController::class, 'whoShouldJoin'])->name('instructor.courses.create.audience.store');
            Route::delete('/audience/{dataIndex}/', [CourseCreateStepController::class, 'deleteWhoShouldJoin'])->name('instructor.courses.create.audience.delete');
            
            // Step 3: Pricing
            Route::get('/pricing/', [CourseCreateStepController::class, 'coursePrice'])->name('instructor.courses.create.pricing');
            Route::post('/pricing/', [CourseCreateStepController::class, 'coursePriceSet'])->name('instructor.courses.create.pricing.store');
            
            // Step 4: Design & Media
            Route::get('/design/', [CourseCreateStepController::class, 'courseDesign'])->name('instructor.courses.create.design');
            Route::post('/design/', [CourseCreateStepController::class, 'courseDesignSet'])->name('instructor.courses.create.design.store');
            
            // Step 5: Content Structure
            Route::get('/content/', [CourseCreateStepController::class, 'step1a'])->name('instructor.courses.create.content');
            Route::post('/content/', [CourseCreateStepController::class, 'step1a'])->name('instructor.courses.create.content.store');
            
            // Step 6: Certificate Setup
            Route::get('/certificate/', [CourseCreateStepController::class, 'courseCertificate'])->name('instructor.courses.create.certificate');
            Route::post('/certificate/', [CourseCreateStepController::class, 'courseCertificateSet'])->name('instructor.courses.create.certificate.store');
            Route::delete('/certificate/', [CourseCreateStepController::class, 'courseCertificateRemove'])->name('instructor.courses.create.certificate.delete');
            
            // Step 7: Visibility Settings
            Route::get('/visibility/', [CourseCreateStepController::class, 'visibility'])->name('instructor.courses.create.visibility');
            Route::post('/visibility/', [CourseCreateStepController::class, 'visibilitySet'])->name('instructor.courses.create.visibility.store');
            
            // Step 8: Publish & Share
            Route::get('/publish/', [CourseCreateStepController::class, 'courseShare'])->name('instructor.courses.create.publish');
            Route::get('/share/', [CourseCreateStepController::class, 'courseShare'])->name('instructor.courses.create.share');
            Route::get('/finish/', [CourseCreateStepController::class, 'finish'])->name('instructor.courses.create.finish');
            
            // Lesson content routes (for redirects after lesson creation)
            Route::get('/video/{module_id}/content/{lesson_id}/', [CourseCreateStepController::class, 'stepLessonVideo'])->name('instructor.courses.create.lesson.video.content');
            Route::post('/video/{module_id}/content/{lesson_id}/', [CourseCreateStepController::class, 'stepLessonVideoSet'])->name('instructor.courses.create.lesson.video.store');
            Route::get('/audio/{module_id}/content/{lesson_id}/', [CourseCreateStepController::class, 'stepLessonAudio'])->name('instructor.courses.create.lesson.audio.content');
            Route::post('/audio/{module_id}/content/{lesson_id}/', [CourseCreateStepController::class, 'stepLessonAudioSet'])->name('instructor.courses.create.lesson.audio.store');
            
            // Live lesson routes
            Route::get('/live/{module_id}/content/{lesson_id}/', [CourseCreateStepController::class, 'stepLessonLive'])->name('instructor.courses.create.lesson.live.content');
            Route::post('/live/{module_id}/content/{lesson_id}/', [CourseCreateStepController::class, 'stepLessonLiveSet'])->name('instructor.courses.create.lesson.live.store');
            Route::get('/text/{module_id}/content/{lesson_id}/', [CourseCreateStepController::class, 'stepLessonText'])->name('instructor.courses.create.lesson.text.content');
            Route::post('/text/{module_id}/content/{lesson_id}/', [CourseCreateStepController::class, 'stepLessonContent'])->name('instructor.courses.create.lesson.text.store');
            Route::get('/lesson/{module_id}/institute/{lesson_id}/', [CourseCreateStepController::class, 'stepLessonInstitue'])->name('instructor.courses.create.lesson.institute');
        });
    });

    // ========================================
    // COURSE CONTENT MANAGEMENT (Modules & Lessons)
    // ========================================
    
    // Module management
    Route::prefix('instructor/modules')->group(function () {
        Route::post('/create/{course_id}/', [CourseCreateStepController::class, 'module'])->name('instructor.modules.create');
        Route::put('/{id}/', [CourseCreateStepController::class, 'step3cu'])->name('instructor.modules.update');
        Route::post('/sort/', [CourseCreateStepController::class, 'moduleResorting'])->name('instructor.modules.sort');
        Route::delete('/{id}/', [CourseCreateStepController::class, 'destroyModule'])->name('instructor.modules.delete');
    });

    // Lesson management
    Route::prefix('instructor/lessons')->group(function () {
        Route::post('/create/{course_id}/{module_id}/', [CourseCreateStepController::class, 'addLesson'])->name('instructor.lessons.create');
        Route::put('/{id}/', [CourseCreateStepController::class, 'step3d'])->name('instructor.lessons.update');
        Route::post('/sort/', [CourseCreateStepController::class, 'moduleLessonResorting'])->name('instructor.lessons.sort');
        Route::delete('/{id}/', [CourseCreateStepController::class, 'destroyLesson'])->name('instructor.lessons.delete');
        
        // Lesson content editing
        Route::prefix('{lesson_id}/content')->group(function () {
            Route::get('/text/', [CourseCreateStepController::class, 'stepLessonText'])->name('instructor.lessons.content.text');
            Route::post('/text/', [CourseCreateStepController::class, 'stepLessonContent'])->name('instructor.lessons.content.text.store');
            
            Route::get('/audio/', [CourseCreateStepController::class, 'stepLessonAudio'])->name('instructor.lessons.content.audio');
            Route::post('/audio/', [CourseCreateStepController::class, 'stepLessonAudioSet'])->name('instructor.lessons.content.audio.store');
            Route::delete('/audio/', [CourseCreateStepController::class, 'stepLessonAudioRemove'])->name('instructor.lessons.content.audio.delete');
            
            Route::get('/video/', [CourseCreateStepController::class, 'stepLessonVideo'])->name('instructor.lessons.content.video');
            Route::post('/video/', [CourseCreateStepController::class, 'stepLessonVideoSet'])->name('instructor.lessons.content.video.store');
            Route::delete('/video/', [CourseCreateStepController::class, 'stepLessonVideoRemove'])->name('instructor.lessons.content.video.delete');
            
            Route::delete('/files/', [CourseCreateStepController::class, 'stepLessonFileRemove'])->name('instructor.lessons.content.files.delete');
        });
        
        Route::get('/{lesson_id}/institute/', [CourseCreateStepController::class, 'stepLessonInstitue'])->name('instructor.lessons.institute');
    });

    // ========================================
    // CERTIFICATES SECTION
    // ========================================
    
    Route::prefix('instructor/certificates')->group(function () {
        Route::get('/', [CertificateController::class, 'index'])->name('instructor.certificates');
        Route::post('/settings/', [CertificateController::class, 'certificateUpdate'])->name('instructor.certificates.settings');
        Route::get('/{id}/edit/', [CertificateController::class, 'certificateEdit'])->name('instructor.certificates.edit');
        Route::post('/generate/', [CertificateController::class, 'customCertificate'])->name('instructor.certificates.generate');
        Route::delete('/{id}/', [CertificateController::class, 'certificateDelete'])->name('instructor.certificates.delete');
    });
    
    // ========================================
    // ENROLLMENTS SECTION
    // ========================================
    
    Route::prefix('instructor/enrollments')->group(function () {
        Route::get('/', [CourseEnrollmentController::class, 'allEnrollments'])->name('instructor.enrollments');
        Route::get('/pending/', [CourseEnrollmentController::class, 'pendingEnrollments'])->name('instructor.enrollments.pending');
        Route::get('/payment-pending/', [CourseEnrollmentController::class, 'paymentPendingEnrollments'])->name('instructor.enrollments.payment-pending');
        Route::patch('/{enrollment}/approve/', [CourseEnrollmentController::class, 'approve'])->name('instructor.enrollments.approve');
        Route::patch('/{enrollment}/approve-without-payment/', [CourseEnrollmentController::class, 'approveWithoutPayment'])->name('instructor.enrollments.approve-free');
        Route::patch('/{enrollment}/reject/', [CourseEnrollmentController::class, 'reject'])->name('instructor.enrollments.reject');
        Route::patch('/{enrollment}/reapprove/', [CourseEnrollmentController::class, 'reapprove'])->name('instructor.enrollments.reapprove');
        Route::post('/grant-free-access/', [CourseEnrollmentController::class, 'grantFreeAccess'])->name('instructor.enrollments.grant-free');
    });
    
    // ========================================
    // COUPONS SECTION
    // ========================================
    
    Route::prefix('instructor/coupons')->group(function () {
        Route::get('/', [CouponController::class, 'index'])->name('instructor.coupons');
        Route::get('/create/', [CouponController::class, 'create'])->name('instructor.coupons.create');
        Route::post('/', [CouponController::class, 'store'])->name('instructor.coupons.store');
        Route::get('/{coupon}/', [CouponController::class, 'show'])->name('instructor.coupons.show');
        Route::get('/{coupon}/edit/', [CouponController::class, 'edit'])->name('instructor.coupons.edit');
        Route::put('/{coupon}/', [CouponController::class, 'update'])->name('instructor.coupons.update');
        Route::delete('/{coupon}/', [CouponController::class, 'destroy'])->name('instructor.coupons.delete');
        Route::patch('/{coupon}/toggle/', [CouponController::class, 'toggleStatus'])->name('instructor.coupons.toggle');
    });
    
    // ========================================
    // BUILDER SECTION (Landing Page Builder)
    // ========================================
    
    Route::prefix('instructor/builder')->group(function () {
        Route::get('/', [LandingPageBuilderController::class, 'index'])->name('instructor.builder');
        Route::get('/{course_id}/', [LandingPageBuilderController::class, 'editor'])->name('instructor.builder.editor');
        Route::post('/save/', [LandingPageBuilderController::class, 'save'])->name('instructor.builder.save');
        Route::get('/preview/{id}/', [LandingPageBuilderController::class, 'preview'])->name('instructor.builder.preview');
        Route::post('/publish/{id}/', [LandingPageBuilderController::class, 'publish'])->name('instructor.builder.publish');
    });
    
    // ========================================
    // SETTINGS SECTION
    // ========================================
    
    Route::prefix('instructor/settings')->group(function () {
        Route::post('/vimeo/', [SettingsController::class, 'vimeoUpdate'])->name('instructor.settings.vimeo');
    });
});