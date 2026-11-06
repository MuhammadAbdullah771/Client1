@extends('admin.layout')

@section('title', 'Edit Job Posting')

@section('content')
<div class="px-4 py-5 sm:p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-navy-deep dark:text-white mb-2">Edit Job Posting</h1>
        <p class="text-slate-600 dark:text-slate-400">Update job posting details and requirements.</p>
    </div>

    <div class="bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-800 p-6 md:p-8">
        <form action="{{ route('admin.jobs.update', $job) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Job Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $job->title) }}" class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors" placeholder="e.g., Senior Audit Associate">
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">The position title as it will appear on the careers page.</p>
                    @error('title')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="department" class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Department <span class="text-red-500">*</span></label>
                        <input type="text" name="department" id="department" required value="{{ old('department', $job->department) }}" class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors" placeholder="e.g., AUDIT, ADVISORY, TAX">
                        @error('department')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Location <span class="text-red-500">*</span></label>
                        <input type="text" name="location" id="location" required value="{{ old('location', $job->location) }}" class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors" placeholder="e.g., London, UK">
                        @error('location')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="employment_type" class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Employment Type <span class="text-red-500">*</span></label>
                        <select name="employment_type" id="employment_type" required class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors">
                            <option value="">Select Employment Type</option>
                            <option value="Full-time" {{ old('employment_type', $job->employment_type) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                            <option value="Part-time" {{ old('employment_type', $job->employment_type) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                            <option value="Contract" {{ old('employment_type', $job->employment_type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                            <option value="Remote" {{ old('employment_type', $job->employment_type) == 'Remote' ? 'selected' : '' }}>Remote</option>
                        </select>
                        @error('employment_type')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center pt-8">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $job->is_active) ? 'checked' : '' }} class="h-5 w-5 text-primary focus:ring-primary border-slate-300 dark:border-slate-600 rounded bg-white dark:bg-slate-800">
                        <label for="is_active" class="ml-3 block text-sm font-medium text-navy-deep dark:text-slate-200">
                            Active / Open Position
                            <span class="block text-xs text-slate-500 dark:text-slate-400 mt-1">Only active positions are shown to applicants.</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Job Description</label>
                    <textarea name="description" id="description" rows="6" class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors" placeholder="Describe the role, responsibilities, and what makes this position exciting...">{{ old('description', $job->description) }}</textarea>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Provide a detailed description of the position, including responsibilities and day-to-day activities.</p>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="requirements" class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Requirements & Qualifications</label>
                    <textarea name="requirements" id="requirements" rows="6" class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors" placeholder="List the required qualifications, skills, experience, and education needed for this position...">{{ old('requirements', $job->requirements) }}</textarea>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Specify the skills, experience, education, and qualifications required for this role.</p>
                    @error('requirements')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end items-center gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                    <a href="{{ route('admin.jobs.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm text-sm font-semibold text-navy-deep dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all">
                        Update Job Posting
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
