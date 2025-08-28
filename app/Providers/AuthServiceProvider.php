<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Illuminate\Support\Facades\Gate;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Gate::define('subscription.check', function ($user) {
            return $user->subscription != null;
        });

        // User role management
        Gate::define('admin', function ($user) {
            return $user->user_role === 'admin';
        });
    
        Gate::define('instructor', function ($user) {
            return $user->user_role === 'instructor';
        });
    
        Gate::define('student', function ($user) {
            return $user->user_role === 'student' ;
        });
    
    }
}
