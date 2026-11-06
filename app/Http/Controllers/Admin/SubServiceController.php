<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\SubService;
use App\Support\ImageUrlHelper;
use Illuminate\Http\Request;

class SubServiceController extends Controller
{
    public function index(Service $service)
    {
        $subServices = $service->subServices()->orderBy('order')->orderBy('id')->get();

        return view('admin.sub-services.index', compact('service', 'subServices'));
    }

    public function create(Service $service)
    {
        return view('admin.sub-services.create', compact('service'));
    }

    public function store(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|url|max:2000',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'heading_1' => 'nullable|string|max:255',
            'content_1' => 'nullable|string',
            'heading_2' => 'nullable|string|max:255',
            'content_2' => 'nullable|string',
            'heading_3' => 'nullable|string|max:255',
            'content_3' => 'nullable|string',
            'heading_4' => 'nullable|string|max:255',
            'content_4' => 'nullable|string',
            'heading_5' => 'nullable|string|max:255',
            'content_5' => 'nullable|string',
        ]);

        $validated['service_id'] = $service->id;
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['image'] = ImageUrlHelper::normalize($validated['image'] ?? null);

        SubService::create($validated);

        return redirect()->route('admin.sub-services.index', $service)->with('success', 'Sub-service created successfully.');
    }

    public function edit(SubService $subService)
    {
        $service = $subService->service;

        return view('admin.sub-services.edit', compact('subService', 'service'));
    }

    public function update(Request $request, SubService $subService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|url|max:2000',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'heading_1' => 'nullable|string|max:255',
            'content_1' => 'nullable|string',
            'heading_2' => 'nullable|string|max:255',
            'content_2' => 'nullable|string',
            'heading_3' => 'nullable|string|max:255',
            'content_3' => 'nullable|string',
            'heading_4' => 'nullable|string|max:255',
            'content_4' => 'nullable|string',
            'heading_5' => 'nullable|string|max:255',
            'content_5' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['image'] = ImageUrlHelper::normalize($request->input('image'));

        $subService->update($validated);

        return redirect()->route('admin.sub-services.index', $subService->service)->with('success', 'Sub-service updated successfully.');
    }

    public function destroy(SubService $subService)
    {
        $service = $subService->service;
        $subService->delete();

        return redirect()->route('admin.sub-services.index', $service)->with('success', 'Sub-service deleted successfully.');
    }

    public function toggle(SubService $subService)
    {
        $subService->is_active = ! $subService->is_active;
        $subService->save();
        $status = $subService->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.sub-services.index', $subService->service)->with('success', "Sub-service {$status} successfully.");
    }
}
