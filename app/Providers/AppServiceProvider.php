<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            \Illuminate\Support\Facades\View::share('categories', \App\Models\InsuranceCategory::all());
        } catch (\Exception $e) {
            // Failsafe if database is not ready
        }

        // Inject notification data into the admin layout on every page
        try {
            \Illuminate\Support\Facades\View::composer(
                'layouts.admin',
                \App\View\Composers\NotificationComposer::class
            );
        } catch (\Exception $e) {
            // Failsafe
        }
    }
}
