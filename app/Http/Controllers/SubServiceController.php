<?php

namespace App\Http\Controllers;

use App\Models\SubService;
use Illuminate\Http\Request;

class SubServiceController extends Controller
{
    public function show($id)
    {
        $subService = SubService::with('service')->findOrFail($id);
        
        if (!$subService->is_active) {
            abort(404);
        }
        
        return view('sub-service-detail', compact('subService'));
    }
}
