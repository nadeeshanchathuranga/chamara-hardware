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
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate::define('hasRole', function ($user, $roles) {
        //     return in_array($user->role_type, (array) $roles);
        // });

        Gate::define('hasRole', function ($user, $roles) {
            if (!is_array($roles)) {
                $roles = func_get_args();
                array_shift($roles); // Remove $user from arguments
            }
            return in_array($user->role_type, $roles);
        });
    }
}
