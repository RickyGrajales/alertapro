<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        $this->registerPolicies(); // 👈 Mantenerlo

        Gate::define('is-admin', function ($user) {
            return $user->hasRole('Admin');
        });
    }
}
