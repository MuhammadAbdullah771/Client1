<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Support\ImageUrlHelper;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $q = trim((string) request('q', ''));

        $servicesQuery = Service::query()
            ->orderBy('order')
            ->orderBy('title');

        if ($q !== '') {
            $servicesQuery->where(function ($query) use ($q) {
                $query
                    ->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $services = $servicesQuery->paginate(15)->appends(request()->query());

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|url|max:2000',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'contact_email' => 'nullable|email|max:255',
            'contact_message' => 'nullable|string',
            'intro_text' => 'nullable|string|max:500',
            'main_heading' => 'nullable|string|max:255',
            'content_paragraph_1' => 'nullable|string',
            'content_paragraph_2' => 'nullable|string',
            'services_list' => 'nullable|string',
            'additional_info_title' => 'nullable|string|max:255',
            'additional_info_content' => 'nullable|string',
            'additional_info_link' => 'nullable|url|max:500',
            'section_title' => 'nullable|string|max:255',
            'section_content_1' => 'nullable|string',
            'section_content_2' => 'nullable|string',
            'section_content_3' => 'nullable|string',
            'contact_cta_text' => 'nullable|string|max:500',
            'contact_cta_link' => 'nullable|string|max:500',
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['image'] = ImageUrlHelper::normalize($validated['image'] ?? null);

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|url|max:2000',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'contact_email' => 'nullable|email|max:255',
            'contact_message' => 'nullable|string',
            'intro_text' => 'nullable|string|max:500',
            'main_heading' => 'nullable|string|max:255',
            'content_paragraph_1' => 'nullable|string',
            'content_paragraph_2' => 'nullable|string',
            'services_list' => 'nullable|string',
            'additional_info_title' => 'nullable|string|max:255',
            'additional_info_content' => 'nullable|string',
            'additional_info_link' => 'nullable|url|max:500',
            'section_title' => 'nullable|string|max:255',
            'section_content_1' => 'nullable|string',
            'section_content_2' => 'nullable|string',
            'section_content_3' => 'nullable|string',
            'contact_cta_text' => 'nullable|string|max:500',
            'contact_cta_link' => 'nullable|string|max:500',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);
        $validated['order'] = $validated['order'] ?? $service->order ?? 0;
        $validated['image'] = ImageUrlHelper::normalize($request->input('image'));

        $nullableFields = [
            'contact_email', 'contact_message', 'intro_text', 'main_heading',
            'content_paragraph_1', 'content_paragraph_2', 'services_list',
            'additional_info_title', 'additional_info_content', 'additional_info_link',
            'section_title', 'section_content_1', 'section_content_2',
            'section_content_3', 'contact_cta_text', 'contact_cta_link', 'icon', 'image',
        ];

        foreach ($nullableFields as $field) {
            if (array_key_exists($field, $validated) && $validated[$field] === '') {
                $validated[$field] = null;
            }
        }

        $service->update(collect($validated)->only($service->getFillable())->all());

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function toggle(Service $service)
    {
        $service->is_active = ! $service->is_active;
        $service->save();
        $status = $service->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.services.index')->with('success', "Service {$status} successfully.");
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}
