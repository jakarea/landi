<?php

namespace App\Policies;

use App\Models\CourseEnrollment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CourseEnrollmentPolicy
{
    /**
     * Determine whether the user can manage (approve/reject) the enrollment.
     */
    public function manage(User $user, CourseEnrollment $courseEnrollment): bool
    {
        // Only the course instructor or admin can manage enrollments
        return $user->user_role === 'admin' || 
               $user->id === $courseEnrollment->instructor_id;
    }

    /**
     * Determine whether the user can view the enrollment.
     */
    public function view(User $user, CourseEnrollment $courseEnrollment): bool
    {
        // User can view their own enrollment or instructor can view enrollments for their courses
        return $user->id === $courseEnrollment->user_id || 
               $user->id === $courseEnrollment->instructor_id ||
               $user->user_role === 'admin';
    }
}
