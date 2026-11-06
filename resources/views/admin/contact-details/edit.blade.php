@extends('admin.layout')

@section('title', 'Contact Details')

@section('content')
<div class="mb-8">
    <h2 class="text-slate-900 dark:text-white text-4xl font-black tracking-tight mb-2">Contact Details</h2>
    <p class="text-slate-500 dark:text-slate-400">Manage contact information displayed on the contact page.</p>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
    <p class="text-green-800 dark:text-green-200 text-sm font-medium">{{ session('success') }}</p>
</div>
@endif

@if($errors->any())
<div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
    <ul class="list-disc list-inside text-red-800 dark:text-red-200 text-sm">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <form action="{{ route('admin.contact-details.update') }}" method="POST" class="p-6 md:p-8 space-y-8">
        @csrf
        @method('PUT')

        <!-- Email Section -->
        <div class="space-y-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">email</span>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Email</h3>
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                    Email Address
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email', $contactDetail->email) }}" 
                    class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                    placeholder="info@example.com"
                >
            </div>
        </div>

        <!-- Phone Numbers Section -->
        <div class="space-y-6 pt-8 border-t border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">phone</span>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Phone Numbers</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="phone" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Phone
                    </label>
                    <input 
                        type="text" 
                        name="phone" 
                        id="phone" 
                        value="{{ old('phone', $contactDetail->phone) }}" 
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                        placeholder="+1 234 567 8900"
                    >
                </div>

                <div>
                    <label for="phone_2" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Phone 2
                    </label>
                    <input 
                        type="text" 
                        name="phone_2" 
                        id="phone_2" 
                        value="{{ old('phone_2', $contactDetail->phone_2) }}" 
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                        placeholder="+1 234 567 8901"
                    >
                </div>

                <div>
                    <label for="mobile" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Mobile
                    </label>
                    <input 
                        type="text" 
                        name="mobile" 
                        id="mobile" 
                        value="{{ old('mobile', $contactDetail->mobile) }}" 
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                        placeholder="+1 234 567 8902"
                    >
                </div>
            </div>

            <div>
                <label for="fax" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                    Fax
                </label>
                <input 
                    type="text" 
                    name="fax" 
                    id="fax" 
                    value="{{ old('fax', $contactDetail->fax) }}" 
                    class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                    placeholder="+1 234 567 8903"
                >
            </div>
        </div>

        <!-- Address Section -->
        <div class="space-y-6 pt-8 border-t border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">location_on</span>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Address</h3>
            </div>

            <div>
                <label for="address" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                    Full Address
                </label>
                <textarea 
                    name="address" 
                    id="address" 
                    rows="4"
                    class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm resize-none" 
                    placeholder="123 Main Street, City, State, ZIP Code, Country"
                >{{ old('address', $contactDetail->address) }}</textarea>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="space-y-6 pt-8 border-t border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">info</span>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Additional Information</h3>
            </div>

            <div>
                <label for="website" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                    Website
                </label>
                <input 
                    type="url" 
                    name="website" 
                    id="website" 
                    value="{{ old('website', $contactDetail->website) }}" 
                    class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                    placeholder="https://www.example.com"
                >
            </div>

            <div>
                <label for="office_hours" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                    Office Hours
                </label>
                <textarea 
                    name="office_hours" 
                    id="office_hours" 
                    rows="3"
                    class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm resize-none" 
                    placeholder="Monday - Friday: 9:00 AM - 5:00 PM&#10;Saturday: 10:00 AM - 2:00 PM&#10;Sunday: Closed"
                >{{ old('office_hours', $contactDetail->office_hours) }}</textarea>
            </div>

            <div>
                <label for="additional_info" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                    Additional Information
                </label>
                <textarea 
                    name="additional_info" 
                    id="additional_info" 
                    rows="4"
                    class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm resize-none" 
                    placeholder="Any additional contact information or notes..."
                >{{ old('additional_info', $contactDetail->additional_info) }}</textarea>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-100 dark:border-slate-800">
            <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-lg font-bold text-sm hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 bg-primary text-white rounded-lg font-bold text-sm hover:bg-primary/90 transition-colors shadow-lg">
                Update Contact Details
            </button>
        </div>
    </form>
</div>
@endsection

