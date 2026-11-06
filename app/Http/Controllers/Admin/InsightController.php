<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Insight;
use App\Support\ImageUrlHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class InsightController extends Controller
{
    public function index()
    {
        $insights = Insight::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.insights.index', compact('insights'));
    }

    public function create()
    {
        if (Schema::hasTable('categories')) {
            $categories = Category::where('is_active', true)->orderBy('name')->get();
        } else {
            $categories = collect(); // Empty collection if table doesn't exist
        }

        return view('admin.insights.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'heading' => 'nullable|string|max:255',
            'excerpt' => 'required|string',
            'key_points' => 'nullable|string',
            'content' => 'nullable|string',
            'category' => 'required|string',
            'image' => 'required|url|max:2000',
            'is_featured' => 'boolean',
            'published_at' => 'required|date',
        ]);
        $validated['image'] = ImageUrlHelper::normalize($validated['image'] ?? null);
        $validated['is_featured'] = $request->boolean('is_featured');

        // Convert key_points from line-separated text to JSON array
        if (! empty($validated['key_points'])) {
            $points = array_filter(array_map('trim', explode("\n", $validated['key_points'])));
            $validated['key_points'] = json_encode(array_values($points));
        } else {
            $validated['key_points'] = null;
        }

        try {
            Insight::create($validated);

            return redirect()->route('admin.insights.index')->with('success', 'Insight created successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Insight creation failed: '.$e->getMessage(), [
                'data' => $validated,
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Failed to create insight: '.$e->getMessage(),
            ]);
        }
    }

    public function edit(Insight $insight)
    {
        if (Schema::hasTable('categories')) {
            $categories = Category::where('is_active', true)->orderBy('name')->get();
        } else {
            $categories = collect(); // Empty collection if table doesn't exist
        }

        return view('admin.insights.edit', compact('insight', 'categories'));
    }

    public function update(Request $request, Insight $insight)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'heading' => 'nullable|string|max:255',
            'excerpt' => 'required|string',
            'key_points' => 'nullable|string',
            'content' => 'nullable|string',
            'category' => 'required|string',
            'image' => 'required|url|max:2000',
            'is_featured' => 'boolean',
            'published_at' => 'required|date',
        ]);
        $validated['image'] = ImageUrlHelper::normalize($validated['image'] ?? null);
        $validated['is_featured'] = $request->boolean('is_featured');

        // Convert key_points from line-separated text to JSON array
        if (! empty($validated['key_points'])) {
            $points = array_filter(array_map('trim', explode("\n", $validated['key_points'])));
            $validated['key_points'] = json_encode(array_values($points));
        } else {
            $validated['key_points'] = null;
        }

        try {
            $insight->update($validated);

            return redirect()->route('admin.insights.index')->with('success', 'Insight updated successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Insight update failed: '.$e->getMessage(), [
                'insight_id' => $insight->id,
                'data' => $validated,
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Failed to update insight: '.$e->getMessage(),
            ]);
        }
    }

    public function destroy(Insight $insight)
    {
        $insight->delete();

        return redirect()->route('admin.insights.index')->with('success', 'Insight deleted successfully.');
    }
}
