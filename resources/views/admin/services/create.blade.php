@extends('admin.layout')

@section('title', 'Create Service')

@section('content')
    <div class="px-4 py-5 sm:p-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-navy-deep dark:text-white mb-2">
                Create Service
            </h1>
            <p class="text-slate-600 dark:text-slate-400">
                Add a new service. Image will be generated automatically.
            </p>
        </div>

        <div
            class="bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-800 p-6 md:p-8">
            <form action="{{ route('admin.services.store') }}" method="POST">
                @csrf

                <div class="space-y-6">

                    <!-- Service Title -->
                    <div>
                        <label class="block text-sm font-semibold mb-2">
                            Service Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" required value="{{ old('title') }}"
                            class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-primary"
                            placeholder="e.g. Assurance, Tax Advisory">
                        @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-semibold mb-2">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" rows="5" required
                            class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-primary"
                            placeholder="Describe this service...">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Image Link (URL)</label>
                        <input type="url" name="image" required value="{{ old('image') }}"
                            class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-primary"
                            placeholder="https://example.com/service-image.jpg">
                        <p class="text-xs text-slate-500 mt-1">Provide a direct image URL for the service cover image. Leave
                            blank to use automatic image selection.</p>
                        @error('image') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <!-- Auto Image Info -->
                    <div class="bg-slate-50 dark:bg-slate-800 border border-dashed rounded-lg p-4">
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            📸 <strong>Auto Image Enabled:</strong>
                            A professional image will be automatically assigned based on service title & description.
                        </p>
                    </div>

                    <!-- Icon & Order -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold mb-2">Icon Name</label>
                            <input type="text" name="icon" value="{{ old('icon') }}"
                                class="w-full px-4 py-3 rounded-lg border" placeholder="account_balance, business">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Display Order</label>
                            <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                                class="w-full px-4 py-3 rounded-lg border">
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <label class="block text-sm font-semibold mb-2">Service Contact Email</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email') }}"
                            class="w-full px-4 py-3 rounded-lg border" placeholder="service@company.com">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Custom Contact Message</label>
                        <textarea name="contact_message" rows="3" class="w-full px-4 py-3 rounded-lg border"
                            placeholder="Message shown on service page contact form">{{ old('contact_message') }}</textarea>
                    </div>

                    <!-- Active -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" checked class="h-5 w-5 rounded border">
                        <span class="ml-3 text-sm">Active Service</span>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <a href="{{ route('admin.services.index') }}" class="px-6 py-3 border rounded-lg">
                            Cancel
                        </a>

                        <button type="submit" class="px-6 py-3 rounded-lg bg-primary text-white font-bold">
                            ➕ Create Service
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
