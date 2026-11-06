<?php

namespace App\Http\Controllers;

use App\Models\Leader;

class TeamController extends Controller
{
    public function index()
    {
        $leaders = Leader::where('is_active', true)
            ->where(function ($q) {
                $q->where('department', '!=', 'IT')->orWhereNull('department');
            })
            ->orderBy('order')
            ->get();
        return view('team', compact('leaders'));
    }
}

