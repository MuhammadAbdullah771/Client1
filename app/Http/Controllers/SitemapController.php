<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Insight;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        // Get all public services and insights (adjust if you use is_active flags)
        $services = Service::all();
        $insights = Insight::all();

        return response()
            ->view('sitemap', compact('services', 'insights'))
            ->header('Content-Type', 'application/xml');
    }
}