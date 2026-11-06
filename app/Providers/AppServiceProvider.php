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
        foreach ([
            storage_path('framework/sessions'),
            storage_path('framework/cache/data'),
            storage_path('framework/views'),
            storage_path('logs'),
        ] as $directory) {
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
        }

        // Set locale from session if available
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }

        view()->composer('layouts.app', function ($view) {
            $navServices = \App\Models\Service::forDisplay();
            // Get all services with their active sub-services for the contact form
            $allServices = \App\Models\Service::where('is_active', true)
                ->with(['activeSubServices' => function ($query) {
                    $query->orderBy('order')->orderBy('id');
                }])
                ->orderBy('order')
                ->orderBy('id')
                ->get();
            // Get all active jobs for the job application form
            $allJobs = \App\Models\Job::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->get();
            $view->with('navServices', $navServices);
            $view->with('allServices', $allServices);
            $view->with('allJobs', $allJobs);
            $view->with('currentLocale', app()->getLocale());
        });

        // Share the same services with services page to ensure consistency
        view()->composer('services', function ($view) {
            // Include all active services including IT Services
            $services = \App\Models\Service::where('is_active', true)
                ->orderBy('order')
                ->orderBy('id')
                ->get();
            $view->with('services', $services);
        });
    }
}
