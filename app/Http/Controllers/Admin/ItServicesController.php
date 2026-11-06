<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leader;
use App\Models\PortfolioItem;
use App\Models\Service;

class ItServicesController extends Controller
{
    public function index()
    {
        $itService = Service::getItService();
        $portfolioCount = $itService
            ? PortfolioItem::where('service_id', $itService->id)->count()
            : 0;
        $teamCount = Leader::where('department', 'IT')->count();

        return view('admin.it-services.index', [
            'itService' => $itService,
            'portfolioCount' => $portfolioCount,
            'teamCount' => $teamCount,
        ]);
    }
}
