<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Milestone;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    public function index()
    {
        $milestones = Milestone::orderBy('year', 'desc')->orderBy('order')->get();
        return view('admin.milestones.index', compact('milestones'));
    }

    public function create()
    {
        return view('admin.milestones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'position' => 'required|in:left,right',
            'order' => 'nullable|integer|min:0',
        ]);

        try {
            Milestone::create([
                'year' => $request->year,
                'title' => $request->title,
                'description' => $request->description,
                'position' => $request->position,
                'order' => $request->order ?? 0,
            ]);

            return redirect()->route('admin.milestones.index')
                ->with('success', 'Milestone created successfully!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Milestone creation failed: ' . $e->getMessage(), [
                'data' => $request->all(),
            ]);
            
            return back()->withInput()->withErrors([
                'error' => 'Failed to create milestone: ' . $e->getMessage()
            ]);
        }
    }

    public function edit(Milestone $milestone)
    {
        return view('admin.milestones.edit', compact('milestone'));
    }

    public function update(Request $request, Milestone $milestone)
    {
        $request->validate([
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'position' => 'required|in:left,right',
            'order' => 'nullable|integer|min:0',
        ]);

        try {
            $milestone->update([
                'year' => $request->year,
                'title' => $request->title,
                'description' => $request->description,
                'position' => $request->position,
                'order' => $request->order ?? 0,
            ]);

            return redirect()->route('admin.milestones.index')
                ->with('success', 'Milestone updated successfully!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Milestone update failed: ' . $e->getMessage(), [
                'milestone_id' => $milestone->id,
                'data' => $request->all(),
            ]);
            
            return back()->withInput()->withErrors([
                'error' => 'Failed to update milestone: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy(Milestone $milestone)
    {
        $milestone->delete();

        return redirect()->route('admin.milestones.index')
            ->with('success', 'Milestone deleted successfully!');
    }
}

