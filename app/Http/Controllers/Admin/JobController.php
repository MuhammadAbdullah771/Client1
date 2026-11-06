<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|in:Full-time,Part-time,Contract,Remote',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        Job::create($validated);
        return redirect()->route('admin.jobs.index')->with('success', 'Job posting created successfully.');
    }

    public function edit(Job $job)
    {
        return view('admin.jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|in:Full-time,Part-time,Contract,Remote',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        try {
            $job->update($validated);
            return redirect()->route('admin.jobs.index')->with('success', 'Job posting updated successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Job update failed: ' . $e->getMessage(), [
                'job_id' => $job->id,
                'data' => $validated,
            ]);
            
            return back()->withInput()->withErrors([
                'error' => 'Failed to update job posting: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Job posting deleted successfully.');
    }
}

