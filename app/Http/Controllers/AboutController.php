<?php

namespace App\Http\Controllers;

use App\Models\Leader;
use App\Models\Milestone;

class AboutController extends Controller
{
    public function index()
    {
        $leaders = Leader::where('is_active', true)
            ->where(function ($q) {
                $q->where('department', '!=', 'IT')->orWhereNull('department');
            })
            ->orderBy('order')
            ->get();
        $milestones = Milestone::orderBy('year')->orderBy('order')->get();
        return view('about', compact('leaders', 'milestones'));
    }

}

