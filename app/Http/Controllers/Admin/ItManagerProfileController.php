<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItManagerProfile;
use App\Support\ImageUrlHelper;
use Illuminate\Http\Request;

class ItManagerProfileController extends Controller
{
    public function edit()
    {
        $profile = ItManagerProfile::firstOrNew([]);

        return view('admin.it-manager.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|url|max:2000',
            'vision' => 'nullable|string',
            'linkedin_url' => 'nullable|string|max:500',
            'email' => 'nullable|email|max:255',
            'whatsapp' => 'nullable|string|max:50',
            'order' => 'nullable|integer|min:0',
        ]);

        $profile = ItManagerProfile::firstOrNew([]);
        $profile->fill([
            'name' => $validated['name'],
            'vision' => $validated['vision'] ?? null,
            'email' => $validated['email'] ?? null,
            'whatsapp' => $validated['whatsapp'] ?? null,
        ]);
        $profile->order = $validated['order'] ?? 0;

        if ($request->filled('image_url')) {
            $profile->image = ImageUrlHelper::normalize($validated['image_url']);
        }

        $link = trim((string) ($validated['linkedin_url'] ?? ''));
        if ($link !== '' && !str_starts_with($link, 'http')) {
            $link = 'https://linkedin.com/in/'.ltrim($link, '/');
        }
        $profile->linkedin_url = $link ?: null;

        $profile->save();

        return redirect()->route('admin.it-manager.edit')->with('success', 'IT Manager profile updated successfully.');
    }
}
