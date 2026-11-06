@extends('layouts.app')

{{-- SEO --}}
@section('title', 'Contact 9Associates | Financial, Tax & Consulting Experts')

@section('meta_description', 
    'Contact 9Associates for accounting, tax, audit and consulting services. Speak with our experts across GCC for professional financial support and business solutions.'
)

@section('meta_keywords', 
    '9Associates contact, accounting firm, tax consultant, audit services, consulting GCC, financial advisory contact'
)

@section('content')

{{-- Schema SEO (ContactPage) --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ContactPage",
  "name": "Contact 9Associates",
  "description": "Contact page for 9Associates accounting and consulting services",
  "mainEntity": {
    "@type": "Organization",
    "name": "9Associates"
  }
}
</script>

<!-- HERO -->
<section class="relative w-full overflow-hidden" style="background: linear-gradient(160deg, #f8fafc 0%, #f1f5f9 60%, #e8f0fe 100%);">
    <div class="dark:hidden absolute inset-0" style="background: linear-gradient(160deg, #f8fafc 0%, #f1f5f9 60%, #e8f0fe 100%);"></div>
    <div class="hidden dark:block absolute inset-0 bg-slate-900"></div>
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true" style="background-image: radial-gradient(circle, rgba(19,127,236,0.05) 1px, transparent 1px); background-size: 24px 24px;"></div>
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-primary/30 to-transparent"></div>

    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 sm:pt-18 md:pt-24 pb-12 sm:pb-16">

        <div class="inline-flex items-center gap-3 mb-5">
            <div class="h-px w-8 bg-primary rounded-full"></div>
            <span class="text-primary font-bold tracking-[0.26em] uppercase text-[0.68rem]">Get In Touch</span>
            <div class="h-px w-8 bg-primary rounded-full"></div>
        </div>

        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-navy-deep dark:text-white leading-tight tracking-tight max-w-2xl">
            {{ __('common.get_in_touch_title') }}
        </h1>

        <p class="mt-4 text-base sm:text-lg text-slate-600 dark:text-slate-400 max-w-2xl leading-relaxed">
            {{ __('common.have_project') }}
        </p>

        <div class="flex flex-wrap gap-4 mt-8">
            <div class="inline-flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                <span class="material-symbols-outlined text-primary text-base" style="font-variation-settings:'FILL' 1">schedule</span>
                Responds within 24 hours
            </div>
            <div class="inline-flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                <span class="material-symbols-outlined text-primary text-base" style="font-variation-settings:'FILL' 1">verified</span>
                GCC-certified advisors
            </div>
            <div class="inline-flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                <span class="material-symbols-outlined text-primary text-base" style="font-variation-settings:'FILL' 1">lock</span>
                100% confidential
            </div>
        </div>

    </div>
</section>

<!-- CONTACT SECTION -->
<section class="w-full bg-white dark:bg-slate-950 py-10 sm:py-14 md:py-20">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Title -->
        <div class="mb-10 premium-reveal">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-[2px] bg-primary rounded-full"></div>
                <span class="text-primary font-bold tracking-[0.26em] uppercase text-[0.68rem]">Direct Channels</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-navy-deep dark:text-white tracking-tight">
                {{ __('common.contact_information') }}
            </h2>

            <p class="mt-2 text-slate-500 dark:text-slate-400">
                {{ __('common.reach_out') ?? 'We usually respond within 24 business hours.' }}
            </p>
        </div>

        <!-- GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- ADDRESS -->
            <div class="group bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm hover:shadow-lg transition border border-slate-100 dark:border-slate-800">

                <div class="flex items-start gap-4">
                    <div class="shrink-0 p-3 rounded-xl bg-primary/10 text-primary">
                        <span class="material-symbols-outlined">location_on</span>
                    </div>

                    <div class="min-w-0">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">
                            {{ __('common.office_address') ?? 'Office Address' }}
                        </h3>

                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed break-words">
                            {!! nl2br(e($officeAddress ?? "123 Financial District, Suite 500\nNew York, NY 10005, USA")) !!}
                        </p>
                    </div>
                </div>

            </div>

            <!-- PHONE -->
            <div class="group bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm hover:shadow-lg transition border border-slate-100 dark:border-slate-800">

                <div class="flex items-start gap-4">
                    <div class="shrink-0 p-3 rounded-xl bg-primary/10 text-primary">
                        <span class="material-symbols-outlined">call</span>
                    </div>

                    <div class="min-w-0">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">
                            {{ __('common.phone_number') }}
                        </h3>

                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed break-words">
                            @if(!empty($phoneNumber1))
                                <a href="tel:{{ $phoneNumber1 }}" class="hover:text-primary transition">
                                    {{ $phoneNumber1 }}
                                </a>

                                @if(!empty($phoneNumber2))
                                    <br>
                                    <a href="tel:{{ $phoneNumber2 }}" class="hover:text-primary transition">
                                        {{ $phoneNumber2 }}
                                    </a>
                                @endif
                            @else
                                +1 (555) 000-WALC<br>
                                +1 (555) 123-4567
                            @endif
                        </p>
                    </div>
                </div>

            </div>

            <!-- EMAIL -->
            <div class="md:col-span-2 group bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm hover:shadow-lg transition border border-slate-100 dark:border-slate-800">

                <div class="flex items-start gap-4">
                    <div class="shrink-0 p-3 rounded-xl bg-primary/10 text-primary">
                        <span class="material-symbols-outlined">mail</span>
                    </div>

                    <div class="min-w-0">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">
                            {{ __('common.email_address') }}
                        </h3>

                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed break-words">
                            @if(!empty($emailAddress1))
                                <a href="mailto:{{ $emailAddress1 }}" class="hover:text-primary transition">
                                    {{ $emailAddress1 }}
                                </a>

                                @if(!empty($emailAddress2))
                                    <br>
                                    <a href="mailto:{{ $emailAddress2 }}" class="hover:text-primary transition">
                                        {{ $emailAddress2 }}
                                    </a>
                                @endif
                            @else
                                <a href="mailto:contact@walconsultant.com" class="hover:text-primary transition">
                                    contact@walconsultant.com
                                </a>
                                <br>
                                <a href="mailto:support@walconsultant.com" class="hover:text-primary transition">
                                    support@walconsultant.com
                                </a>
                            @endif
                        </p>
                    </div>
                </div>

            </div>

        </div>

        <!-- EMBEDDED CONTACT FORM -->
        <div class="mt-16 relative w-full group">
            <!-- Decorative Background Glow -->
            <div class="absolute -inset-1 bg-gradient-to-r from-primary/30 to-indigo-500/30 rounded-[2.5rem] blur-xl opacity-50 group-hover:opacity-75 transition duration-1000 group-hover:duration-200"></div>
            
            <div class="relative bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl rounded-[2rem] p-6 sm:p-10 md:p-14 shadow-2xl border border-white/50 dark:border-slate-700/50 overflow-hidden max-w-full">
                <!-- Inner soft highlight -->
                <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/50 to-transparent dark:via-white/10"></div>
                
                <div class="mb-10 text-center sm:text-left">
                    <h3 class="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-navy-deep to-primary dark:from-white dark:to-slate-300">
                        Let's Work Together
                    </h3>
                    <p class="mt-3 text-slate-500 dark:text-slate-400">Fill out the form below and our team will get back to you within 24 hours.</p>
                </div>
                
                <form id="contact-page-form" class="site-form space-y-8 max-w-full overflow-hidden">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 min-w-0">
                        <div class="relative group/input">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 transition-colors group-focus-within/input:text-primary">First Name <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" required placeholder="John" class="w-full box-border px-5 py-4 border-2 border-transparent bg-slate-50 dark:bg-slate-800/50 rounded-xl text-navy-deep dark:text-white transition-all duration-300 focus:bg-white dark:focus:bg-slate-800 focus:border-primary/50 focus:ring-4 focus:ring-primary/10 hover:bg-slate-100 dark:hover:bg-slate-800 outline-none">
                        </div>
                        <div class="relative group/input">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 transition-colors group-focus-within/input:text-primary">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" name="last_name" required placeholder="Doe" class="w-full box-border px-5 py-4 border-2 border-transparent bg-slate-50 dark:bg-slate-800/50 rounded-xl text-navy-deep dark:text-white transition-all duration-300 focus:bg-white dark:focus:bg-slate-800 focus:border-primary/50 focus:ring-4 focus:ring-primary/10 hover:bg-slate-100 dark:hover:bg-slate-800 outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 min-w-0">
                        <div class="relative group/input">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 transition-colors group-focus-within/input:text-primary">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" required placeholder="john@company.com" class="w-full box-border px-5 py-4 border-2 border-transparent bg-slate-50 dark:bg-slate-800/50 rounded-xl text-navy-deep dark:text-white transition-all duration-300 focus:bg-white dark:focus:bg-slate-800 focus:border-primary/50 focus:ring-4 focus:ring-primary/10 hover:bg-slate-100 dark:hover:bg-slate-800 outline-none">
                        </div>
                        <div class="relative group/input">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 transition-colors group-focus-within/input:text-primary">Phone Number <span class="text-red-500">*</span></label>
                            <input type="tel" name="phone" required placeholder="+1 (555) 000-0000" class="w-full box-border px-5 py-4 border-2 border-transparent bg-slate-50 dark:bg-slate-800/50 rounded-xl text-navy-deep dark:text-white transition-all duration-300 focus:bg-white dark:focus:bg-slate-800 focus:border-primary/50 focus:ring-4 focus:ring-primary/10 hover:bg-slate-100 dark:hover:bg-slate-800 outline-none">
                        </div>
                    </div>

                    <div class="relative group/input">
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 transition-colors group-focus-within/input:text-primary">What can we help you with? <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="help_with" required class="w-full appearance-none box-border px-5 py-4 border-2 border-transparent bg-slate-50 dark:bg-slate-800/50 rounded-xl text-navy-deep dark:text-white transition-all duration-300 focus:bg-white dark:focus:bg-slate-800 focus:border-primary/50 focus:ring-4 focus:ring-primary/10 hover:bg-slate-100 dark:hover:bg-slate-800 outline-none cursor-pointer">
                                <option value="" disabled selected>Please select an option...</option>
                                <option value="general">General Inquiry</option>
                                <option value="service_tax">Tax Advisory</option>
                                <option value="service_audit">Audit & Assurance</option>
                                <option value="service_accounting">Accounting</option>
                                <option value="service_business">Business Setup</option>
                                <option value="other">Other</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-slate-500">
                                <span class="material-symbols-outlined">expand_more</span>
                            </div>
                        </div>
                    </div>

                    <div class="relative group/input">
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 transition-colors group-focus-within/input:text-primary">Your Message</label>
                        <textarea name="additional_info" rows="5" placeholder="Tell us more about your project or inquiry..." class="w-full box-border px-5 py-4 border-2 border-transparent bg-slate-50 dark:bg-slate-800/50 rounded-xl text-navy-deep dark:text-white transition-all duration-300 focus:bg-white dark:focus:bg-slate-800 focus:border-primary/50 focus:ring-4 focus:ring-primary/10 hover:bg-slate-100 dark:hover:bg-slate-800 outline-none resize-y"></textarea>
                    </div>

                    <div class="relative group/input">
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 transition-colors group-focus-within/input:text-primary">Attachment (optional)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-800/30 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-colors cursor-pointer" onclick="document.getElementById('contact_page_file').click()">
                            <div class="space-y-1 text-center">
                                <span class="material-symbols-outlined text-4xl text-slate-400 dark:text-slate-500 mb-2 block">cloud_upload</span>
                                <div class="flex flex-col sm:flex-row text-sm text-slate-600 dark:text-slate-400 items-center justify-center gap-1">
                                    <label for="contact_page_file" class="relative cursor-pointer rounded-md bg-transparent font-medium text-primary hover:text-indigo-500 focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input type="file" name="file" id="contact_page_file" accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png" class="sr-only" onchange="document.getElementById('file_name_display').textContent = this.files[0] ? this.files[0].name : 'No file selected'">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-500">PDF, Word, TXT, or Image up to 5MB</p>
                                <p id="file_name_display" class="text-sm font-semibold text-primary mt-2"></p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 min-w-0 pt-2">
                        <div class="flex items-center h-5 mt-0.5">
                            <input type="checkbox" name="privacy_consent" id="privacy_consent" required class="h-5 w-5 rounded border-gray-300 text-primary focus:ring-primary focus:ring-2 bg-slate-50 dark:bg-slate-800 dark:border-slate-600 transition-colors cursor-pointer">
                        </div>
                        <label for="privacy_consent" class="text-sm text-slate-600 dark:text-slate-400 cursor-pointer">
                            I agree to the <a href="{{ route('privacy-policy') }}" class="text-primary hover:underline font-medium">privacy policy</a> and consent to having this website store my submitted information.
                        </label>
                    </div>

                    <div id="form-status" class="hidden p-4 rounded-xl border"></div>

                    <div class="pt-6">
                        <button type="submit" id="submit-btn" class="relative overflow-hidden w-full sm:w-auto inline-flex items-center justify-center gap-3 rounded-xl bg-gradient-to-r from-primary to-indigo-600 px-10 py-4 text-white font-bold tracking-wide hover:from-primary/90 hover:to-indigo-600/90 hover:scale-[1.02] active:scale-95 transition-all duration-300 shadow-xl shadow-primary/30 group/btn">
                            <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span>
                            <span class="relative">Send Message</span>
                            <span class="material-symbols-outlined text-xl relative group-hover/btn:translate-x-1 transition-transform">send</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</section>

@push('scripts')
<script>
document.getElementById('contact-page-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = e.target;
    const btn = document.getElementById('submit-btn');
    const statusDiv = document.getElementById('form-status');
    const formData = new FormData(form);
    
    // Add default values for validation
    formData.append('service_type', formData.get('help_with'));
    
    btn.disabled = true;
    btn.innerHTML = '<span>Sending...</span><span class="material-symbols-outlined text-sm animate-spin">refresh</span>';
    statusDiv.className = 'hidden p-4 rounded-lg';
    
    try {
        const response = await fetch("{{ route('contact.form.submit') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            credentials: 'same-origin'
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            statusDiv.className = 'block p-4 rounded-lg bg-green-100 border border-green-400 text-green-700';
            statusDiv.innerHTML = data.message || 'Message sent successfully!';
            form.reset();
        } else {
            statusDiv.className = 'block p-4 rounded-lg bg-red-100 border border-red-400 text-red-700';
            let errorHtml = data.message || 'Error submitting form. Please check fields.';
            if (data.errors) {
                errorHtml += '<ul class="list-disc ml-5 mt-2">';
                for (let field in data.errors) {
                    errorHtml += `<li>${data.errors[field][0]}</li>`;
                }
                errorHtml += '</ul>';
            }
            statusDiv.innerHTML = errorHtml;
        }
    } catch (err) {
        statusDiv.className = 'block p-4 rounded-lg bg-red-100 border border-red-400 text-red-700';
        statusDiv.innerHTML = 'An unexpected error occurred. Please try again later.';
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<span>Send Message</span><span class="material-symbols-outlined text-sm">send</span>';
    }
});
</script>
@endpush

@endsection