<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leader;
use App\Support\ImageUrlHelper;
use Illuminate\Http\Request;

class ItServicesTeamController extends Controller
{
    private function normalizeLinkedin(?string $value): ?string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }
        $value = preg_replace('~^https?://~i', '', $value);
        $value = preg_replace('~^www\.~i', '', $value);
        if (stripos($value, 'linkedin.com/in/') !== false) {
            $value = substr($value, stripos($value, 'linkedin.com/in/') + strlen('linkedin.com/in/'));
        } elseif (stripos($value, '/in/') !== false) {
            $value = substr($value, stripos($value, '/in/') + strlen('/in/'));
        }
        $value = preg_replace('~[?#].*$~', '', $value);
        $value = trim($value, "/ \t\n\r\0\x0B");
        if ($value === '') {
            return null;
        }

        return 'https://linkedin.com/in/'.$value;
    }

    public function index()
    {
        $q = trim((string) request('q', ''));

        $membersQuery = Leader::query()
            ->where('department', 'IT')
            ->orderBy('order')
            ->orderBy('name');

        if ($q !== '') {
            $membersQuery->where(function ($query) use ($q) {
                $query
                    ->where('name', 'like', "%{$q}%")
                    ->orWhere('role', 'like', "%{$q}%");
            });
        }

        $members = $membersQuery->paginate(12)->appends(request()->query());

        return view('admin.it-services.team.index', compact('members'));
    }

    public function create()
    {
        return view('admin.it-services.team.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'required|string|max:1000',
            'image_url' => 'required|url|max:2000',
            'email' => 'nullable|email|max:255',
            'linkedin' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['department'] = 'IT';
        $validated['linkedin'] = $this->normalizeLinkedin($validated['linkedin']);
        $validated['image'] = ImageUrlHelper::normalize($validated['image_url']);
        unset($validated['image_url']);

        Leader::create($validated);

        return redirect()->route('admin.it-services.team.index')->with('success', 'IT Services team member added.');
    }

    public function edit(Leader $leader)
    {
        if ($leader->department !== 'IT') {
            abort(404, 'IT Services Team only. Edit Finance leaders from IT Services → Leadership.');
        }

        return view('admin.it-services.team.edit', compact('leader'));
    }

    public function update(Request $request, Leader $leader)
    {
        if ($leader->department !== 'IT') {
            abort(404, 'IT Services Team only.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'required|string|max:1000',
            'image_url' => 'required|url|max:2000',
            'email' => 'nullable|email|max:255',
            'linkedin' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['department'] = 'IT';
        $validated['linkedin'] = $this->normalizeLinkedin($validated['linkedin']);
        $validated['image'] = ImageUrlHelper::normalize($validated['image_url']);
        unset($validated['image_url']);

        $leader->update($validated);

        return redirect()->route('admin.it-services.team.index')->with('success', 'IT Services team member updated.');
    }

    public function toggle(Leader $leader)
    {
        if ($leader->department !== 'IT') {
            abort(404, 'IT Services Team only.');
        }
        $leader->is_active = !$leader->is_active;
        $leader->save();
        $status = $leader->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.it-services.team.index')->with('success', "Team member {$status}.");
    }

    public function destroy(Leader $leader)
    {
        if ($leader->department !== 'IT') {
            abort(404, 'IT Services Team only.');
        }
        $leader->delete();

        return redirect()->route('admin.it-services.team.index')->with('success', 'IT Services team member deleted.');
    }
}
