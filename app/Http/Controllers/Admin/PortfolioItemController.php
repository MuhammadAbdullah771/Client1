<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use App\Models\Service;
use Illuminate\Http\Request;

class PortfolioItemController extends Controller
{
    public function index()
    {
        $itService = Service::getItService();
        $items = PortfolioItem::with('service')
            ->when($itService, fn ($q) => $q->where('service_id', $itService->id))
            ->orderBy('order')
            ->orderBy('title')
            ->paginate(15)
            ->appends(request()->query());

        return view('admin.portfolio-items.index', compact('items', 'itService'));
    }

    public function create()
    {
        $itService = Service::getItService();
        $services = Service::orderBy('order')->get();
        return view('admin.portfolio-items.create', compact('itService', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);

        try {
            PortfolioItem::create($validated);
            return redirect()->route('admin.portfolio-items.index')->with('success', 'Portfolio item created successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Portfolio item creation failed: ' . $e->getMessage(), [
                'data' => $validated,
            ]);
            
            return back()->withInput()->withErrors([
                'error' => 'Failed to create portfolio item: ' . $e->getMessage()
            ]);
        }
    }

    public function edit(PortfolioItem $portfolioItem)
    {
        $services = Service::orderBy('order')->get();
        return view('admin.portfolio-items.edit', compact('portfolioItem', 'services'));
    }

    public function update(Request $request, PortfolioItem $portfolioItem)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        try {
            $portfolioItem->update($validated);
            return redirect()->route('admin.portfolio-items.index')->with('success', 'Portfolio item updated successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Portfolio item update failed: ' . $e->getMessage(), [
                'portfolio_item_id' => $portfolioItem->id,
                'data' => $validated,
            ]);
            
            return back()->withInput()->withErrors([
                'error' => 'Failed to update portfolio item: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy(PortfolioItem $portfolioItem)
    {
        $portfolioItem->delete();
        return redirect()->route('admin.portfolio-items.index')->with('success', 'Portfolio item deleted successfully.');
    }
}
