<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use Illuminate\Http\Request;

class InsightController extends Controller
{
    public function index(Request $request)
    {
        $query = Insight::query();

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
        }

        $featured = Insight::where('is_featured', true)->where('published_at', '<=', now())->orderBy('published_at', 'desc')->first();
        $insights = $query->where('published_at', '<=', now())->orderBy('published_at', 'desc')->paginate(12);

        return view('insights', compact('insights', 'featured'));
    }

    public function show($id)
    {
        $insight = Insight::where('published_at', '<=', now())->findOrFail($id);
        
        // Get related insights (same category, excluding current)
        $relatedInsights = Insight::where('category', $insight->category)
            ->where('id', '!=', $insight->id)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();
        
        return view('insight-detail', compact('insight', 'relatedInsights'));
    }
}

