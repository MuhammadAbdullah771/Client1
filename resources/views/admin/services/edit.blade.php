@extends('admin.layout')

@section('title', 'Edit Service')

@section('content')
    <div class="px-4 py-5 sm:p-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-navy-deep dark:text-white mb-2">Edit Service</h1>
            <p class="text-slate-600 dark:text-slate-400">Update service information and settings.</p>
        </div>

        <div
            class="bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-800 p-6 md:p-8">
            <form action="{{ route('admin.services.update', $service) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Display general errors -->
                @if($errors->has('error'))
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-red-600 dark:text-red-400">error</span>
                            <p class="text-sm font-semibold text-red-800 dark:text-red-200">{{ $errors->first('error') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Display success message if redirected back with old input -->
                @if(session('success'))
                    <div
                        class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-green-600 dark:text-green-400">check_circle</span>
                            <p class="text-sm font-semibold text-green-800 dark:text-green-200">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <div class="space-y-6">
                    <div>
                        <label for="title"
                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Service Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $service->title) }}"
                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                            placeholder="e.g., Financial Advisory">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description"
                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Description <span
                                class="text-red-500">*</span></label>
                        <textarea name="description" id="description" rows="6" required
                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                            placeholder="Describe the service...">{{ old('description', $service->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div
                        class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl mb-6">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 mt-0.5">info</span>
                            <div>
                                <p class="text-sm font-semibold text-blue-900 dark:text-blue-100 mb-1">Service Images</p>
                                <p class="text-xs text-blue-800 dark:text-blue-200">Provide an image URL (https://…), or leave blank to use an automatically generated professional image based on the service title and description.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-6">
                        <div>
                            <label for="image"
                                class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Custom Image
                                Link (URL)</label>
                            <input type="url" name="image" id="image" required value="{{ old('image', $service->image) }}"
                                class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                placeholder="https://example.com/image.jpg">
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Enter an external image URL for the
                                service. Leave blank to continue using automatic image generation.</p>
                            @error('image')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Current Image Preview -->
                    <div class="mb-6 {{ $service->image ? '' : 'hidden' }}" id="service-image-preview">
                        <p class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Current/Preview Image
                        </p>
                        <div
                            class="w-full sm:w-1/2 md:w-1/3 aspect-video rounded-lg overflow-hidden border border-slate-200 dark:border-slate-700 relative bg-slate-100 dark:bg-slate-800">
                            <img src="{{ $service->image_url }}" id="preview-service-img" class="w-full h-full object-cover"
                                alt="Service Image Preview">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="icon"
                                class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Icon
                                Name</label>
                            <input type="text" name="icon" id="icon" value="{{ old('icon', $service->icon) }}"
                                class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                placeholder="e.g., account_balance, business">
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Material Symbols icon name</p>
                            @error('icon')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="order"
                                class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Display
                                Order</label>
                            <input type="number" name="order" id="order" value="{{ old('order', $service->order) }}" min="0"
                                class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors">
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Lower numbers appear first</p>
                            @error('order')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
                        <h3 class="text-lg font-bold text-navy-deep dark:text-white mb-4">Structured Content (Service Detail
                            Page)</h3>
                        <div class="space-y-6">
                            <div>
                                <label for="intro_text"
                                    class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Introductory
                                    Text</label>
                                <input type="text" name="intro_text" id="intro_text"
                                    value="{{ old('intro_text', $service->intro_text) }}"
                                    class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                    placeholder="Small introductory text above main heading">
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Small text displayed before the
                                    main heading</p>
                                @error('intro_text')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="main_heading"
                                    class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Main
                                    Heading</label>
                                <input type="text" name="main_heading" id="main_heading"
                                    value="{{ old('main_heading', $service->main_heading) }}"
                                    class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                    placeholder="e.g., Rantalainen's accounting services">
                                @error('main_heading')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="content_paragraph_1"
                                    class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Content
                                    Paragraph 1</label>
                                <textarea name="content_paragraph_1" id="content_paragraph_1" rows="4"
                                    class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                    placeholder="First main content paragraph...">{{ old('content_paragraph_1', $service->content_paragraph_1) }}</textarea>
                                @error('content_paragraph_1')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="content_paragraph_2"
                                    class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Content
                                    Paragraph 2</label>
                                <textarea name="content_paragraph_2" id="content_paragraph_2" rows="4"
                                    class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                    placeholder="Second main content paragraph...">{{ old('content_paragraph_2', $service->content_paragraph_2) }}</textarea>
                                @error('content_paragraph_2')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="services_list"
                                    class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Services
                                    List (One per line)</label>
                                <textarea name="services_list" id="services_list" rows="6"
                                    class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                    placeholder="Personal accounting specialist&#10;Double-entry bookkeeping and single-entry bookkeeping&#10;Self-assessed tax reports&#10;...">{{ old('services_list', $service->services_list) }}</textarea>
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Enter one service per line. Will
                                    be displayed as bullet points.</p>
                                @error('services_list')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
                                <h4 class="text-md font-semibold text-navy-deep dark:text-white mb-4">Additional Information
                                    Section</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label for="additional_info_title"
                                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Additional
                                            Info Title</label>
                                        <input type="text" name="additional_info_title" id="additional_info_title"
                                            value="{{ old('additional_info_title', $service->additional_info_title) }}"
                                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                            placeholder="e.g., Software Mention">
                                        @error('additional_info_title')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="additional_info_content"
                                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Additional
                                            Info Content</label>
                                        <textarea name="additional_info_content" id="additional_info_content" rows="3"
                                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                            placeholder="e.g., We offer Netvisor software solutions...">{{ old('additional_info_content', $service->additional_info_content) }}</textarea>
                                        @error('additional_info_content')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="additional_info_link"
                                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Additional
                                            Info Link</label>
                                        <input type="url" name="additional_info_link" id="additional_info_link"
                                            value="{{ old('additional_info_link', $service->additional_info_link) }}"
                                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                            placeholder="https://example.com">
                                        @error('additional_info_link')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
                                <h4 class="text-md font-semibold text-navy-deep dark:text-white mb-4">Additional Section
                                    (e.g., Personal Service)</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label for="section_title"
                                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Section
                                            Title</label>
                                        <input type="text" name="section_title" id="section_title"
                                            value="{{ old('section_title', $service->section_title) }}"
                                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                            placeholder="e.g., Personal service">
                                        @error('section_title')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="section_content_1"
                                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Section
                                            Content Paragraph 1</label>
                                        <textarea name="section_content_1" id="section_content_1" rows="3"
                                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                            placeholder="First paragraph of this section...">{{ old('section_content_1', $service->section_content_1) }}</textarea>
                                        @error('section_content_1')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="section_content_2"
                                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Section
                                            Content Paragraph 2</label>
                                        <textarea name="section_content_2" id="section_content_2" rows="3"
                                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                            placeholder="Second paragraph of this section...">{{ old('section_content_2', $service->section_content_2) }}</textarea>
                                        @error('section_content_2')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="section_content_3"
                                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Section
                                            Content Paragraph 3</label>
                                        <textarea name="section_content_3" id="section_content_3" rows="3"
                                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                            placeholder="Third paragraph of this section...">{{ old('section_content_3', $service->section_content_3) }}</textarea>
                                        @error('section_content_3')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
                                <h4 class="text-md font-semibold text-navy-deep dark:text-white mb-4">Contact CTA Section
                                </h4>
                                <div class="space-y-4">
                                    <div>
                                        <label for="contact_cta_text"
                                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Contact
                                            CTA Text</label>
                                        <input type="text" name="contact_cta_text" id="contact_cta_text"
                                            value="{{ old('contact_cta_text', $service->contact_cta_text) }}"
                                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                            placeholder="e.g., Contact us and ask for details!">
                                        @error('contact_cta_text')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="contact_cta_link"
                                            class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Contact
                                            CTA Link</label>
                                        <input type="url" name="contact_cta_link" id="contact_cta_link"
                                            value="{{ old('contact_cta_link', $service->contact_cta_link) }}"
                                            class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                            placeholder="https://example.com or #contact">
                                        @error('contact_cta_link')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-200 dark:border-slate-700 space-y-6">
                        <div>
                            <label for="contact_email"
                                class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Contact Email
                                (Service-Specific)</label>
                            <input type="email" name="contact_email" id="contact_email"
                                value="{{ old('contact_email', $service->contact_email) }}"
                                class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                placeholder="service@example.com">
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Email address specific to this
                                service. If empty, default contact email will be used.</p>
                            @error('contact_email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_message"
                                class="block text-sm font-semibold text-navy-deep dark:text-slate-200 mb-2">Contact Form
                                Message (Service-Specific)</label>
                            <textarea name="contact_message" id="contact_message" rows="4"
                                class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-slate-800 text-navy-deep dark:text-slate-100 transition-colors"
                                placeholder="Custom message to display on the contact form for this service...">{{ old('contact_message', $service->contact_message) }}</textarea>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Custom message to display on the
                                service detail page contact form. If empty, default message will be used.</p>
                            @error('contact_message')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                                class="h-5 w-5 text-primary focus:ring-primary border-slate-300 dark:border-slate-600 rounded bg-white dark:bg-slate-800">
                            <label for="is_active"
                                class="ml-3 block text-sm font-medium text-navy-deep dark:text-slate-200">
                                Active Service
                                <span class="block text-xs text-slate-500 dark:text-slate-400 mt-1">Only active services are
                                    shown on the website.</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                        <a href="{{ route('admin.services.index') }}"
                            class="inline-flex items-center justify-center px-6 py-3 border border-slate-300 dark:border-slate-700 rounded-lg shadow-sm text-sm font-semibold text-navy-deep dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all">
                            Update Service
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function previewServiceImage(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const preview = document.getElementById('service-image-preview');
                        const img = document.getElementById('preview-service-img');
                        if (preview && img) {
                            img.src = e.target.result;
                            preview.classList.remove('hidden');
                        }
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endpush
@endsection
