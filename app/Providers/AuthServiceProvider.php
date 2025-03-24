<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Gate;
use Opcodes\LogViewer\Facades\LogViewer;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

        Gate::define('viewWebTinker', function ($user = null) {
            return $user?->username == 'admin';
        });

        // Gate::define('access-rsbsa', fn ($user) => $user->isRsbsaOfficer());

        if (app()->environment('production')) {
            LogViewer::auth(function ($request) {
                return $request->user()
                    && in_array($request->user()->username, [
                        'admin',
                    ]);
            });
        }
    }
}
