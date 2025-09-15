<?php

namespace App\Policies;

use App\Models\LiveClass;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LiveClassPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->user_role === 'instructor' || $user->user_role === 'student';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LiveClass $liveClass): bool
    {
        // Instructors can view their own live classes
        if ($user->user_role === 'instructor' && $user->id === $liveClass->instructor_id) {
            return true;
        }

        // Students can view live classes for courses they're enrolled in
        if ($user->user_role === 'student') {
            return $liveClass->canJoin($user->id);
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->user_role === 'instructor';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LiveClass $liveClass): bool
    {
        return $user->user_role === 'instructor' && 
               $user->id === $liveClass->instructor_id &&
               $liveClass->status === 'scheduled';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LiveClass $liveClass): bool
    {
        return $user->user_role === 'instructor' && 
               $user->id === $liveClass->instructor_id &&
               $liveClass->status === 'scheduled';
    }

    /**
     * Determine whether the user can start the live class.
     */
    public function start(User $user, LiveClass $liveClass): bool
    {
        return $user->user_role === 'instructor' && 
               $user->id === $liveClass->instructor_id &&
               ($liveClass->is_live || $liveClass->is_upcoming);
    }

    /**
     * Determine whether the user can join the live class.
     */
    public function join(User $user, LiveClass $liveClass): bool
    {
        return $user->user_role === 'student' && $liveClass->canJoin($user->id);
    }
}