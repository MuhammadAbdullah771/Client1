<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insight;
use App\Models\Job;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        try {
                $stats = [
                    'services_count' => Schema::hasTable('services') ? Service::count() : 0,
                    'active_services' => Schema::hasTable('services') ? Service::where('is_active', true)->count() : 0,
                    'insights_count' => Schema::hasTable('insights') ? Insight::count() : 0,
                    'jobs_count' => Schema::hasTable('job_listings') ? Job::count() : 0,
                    'active_jobs' => Schema::hasTable('job_listings') ? Job::where('is_active', true)->count() : 0,
                ];
        } catch (\Exception $e) {
                $stats = [
                    'services_count' => 0,
                    'active_services' => 0,
                    'insights_count' => 0,
                    'jobs_count' => 0,
                    'active_jobs' => 0,
                ];
        }

        return view('admin.dashboard', compact('stats'));
    }
}

