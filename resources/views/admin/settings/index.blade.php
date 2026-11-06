@extends('admin.layout')

@section('title', 'Settings')

@section('content')
<div class="mb-8">
    <h2 class="text-slate-900 dark:text-white text-4xl font-black tracking-tight mb-2">Settings</h2>
    <p class="text-slate-500 dark:text-slate-400">Manage system settings.</p>
</div>

<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <form action="{{ route('admin.settings.update') }}" method="POST" class="p-6 md:p-8 space-y-8">
        @csrf
        @method('PUT')

        <!-- Job Notification Email Section -->
        <div class="space-y-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">email</span>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Job Application Email</h3>
            </div>

            <div>
                <label for="job_notification_email" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                    Email Address for Job Applications <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                    When users apply for jobs, their email client will open with this email address pre-filled. This is where you will receive job application emails.
                </p>
                <input 
                    type="email" 
                    name="job_notification_email" 
                    id="job_notification_email" 
                    required 
                    value="{{ old('job_notification_email', $jobNotificationEmail) }}" 
                    class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                    placeholder="admin@example.com"
                >
                @error('job_notification_email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Contact Form Email Settings Section -->
        <div class="space-y-6 pt-8 border-t border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">contact_mail</span>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Contact Form Email Settings</h3>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">
                Configure email addresses for the contact form. These emails will be used when users submit the contact form.
            </p>

            <!-- General Contact Form Email -->
            <div>
                <label for="contact_form_email" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                    General Contact Form Email <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                    Email address for general contact form submissions (all services except IT Support).
                </p>
                <input 
                    type="email" 
                    name="contact_form_email" 
                    id="contact_form_email" 
                    required 
                    value="{{ old('contact_form_email', $contactFormEmail) }}" 
                    class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                    placeholder="contact@9associates.com"
                >
                @error('contact_form_email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- IT Support Email -->
            <div>
                <label for="it_support_email" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                    IT Support Email <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                    Email address for IT Support service inquiries. This will be used when users select IT Support services.
                </p>
                <input 
                    type="email" 
                    name="it_support_email" 
                    id="it_support_email" 
                    required 
                    value="{{ old('it_support_email', $itSupportEmail) }}" 
                    class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                    placeholder="itsupport@9associates.com"
                >
                @error('it_support_email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- SMTP Settings Section -->
        <div class="space-y-6 pt-8 border-t border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">outgoing_mail</span>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Email Delivery (SMTP)</h3>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400">
                For Gmail use <strong>smtp.gmail.com</strong>, port <strong>587</strong>, TLS, your Gmail address,
                and a Google App Password. The password field may be left blank to keep the saved password.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="mail_host" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">SMTP Host</label>
                    <input type="text" name="mail_host" id="mail_host" required value="{{ old('mail_host', $mailHost) }}"
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/40"
                        placeholder="smtp.gmail.com">
                    @error('mail_host') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="mail_port" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">SMTP Port</label>
                    <input type="number" name="mail_port" id="mail_port" required min="1" max="65535" value="{{ old('mail_port', $mailPort) }}"
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/40">
                    @error('mail_port') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="mail_username" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">SMTP Username</label>
                    <input type="text" name="mail_username" id="mail_username" required value="{{ old('mail_username', $mailUsername) }}"
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/40"
                        autocomplete="username">
                    @error('mail_username') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="mail_password" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">SMTP / Gmail App Password</label>
                    <input type="password" name="mail_password" id="mail_password"
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/40"
                        placeholder="Leave blank to keep saved password" autocomplete="new-password">
                    @error('mail_password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="mail_encryption" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Encryption</label>
                    <select name="mail_encryption" id="mail_encryption" required
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/40">
                        <option value="tls" @selected(old('mail_encryption', $mailEncryption) === 'tls')>TLS (port 587)</option>
                        <option value="ssl" @selected(old('mail_encryption', $mailEncryption) === 'ssl')>SSL (port 465)</option>
                    </select>
                    @error('mail_encryption') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="mail_from_address" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">From Email</label>
                    <input type="email" name="mail_from_address" id="mail_from_address" required value="{{ old('mail_from_address', $mailFromAddress) }}"
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/40">
                    @error('mail_from_address') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <label for="mail_from_name" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">From Name</label>
                <input type="text" name="mail_from_name" id="mail_from_name" required value="{{ old('mail_from_name', $mailFromName) }}"
                    class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/40">
                @error('mail_from_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Admin Account Settings Section -->
        <div class="space-y-6 pt-8 border-t border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">admin_panel_settings</span>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Admin Account Settings</h3>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">
                Update your admin account email and password. Leave password fields blank to keep current password.
            </p>

            <!-- Admin Email Change -->
            <div>
                <label for="admin_email" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                    Admin Email Address <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                    This is the email address you use to log in to the admin panel.
                </p>
                <input 
                    type="email" 
                    name="admin_email" 
                    id="admin_email" 
                    required 
                    value="{{ old('admin_email', auth('admin')->user()->email) }}" 
                    class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                    placeholder="admin@example.com"
                >
                @error('admin_email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="current_password" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                    Current Password
                </label>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                    Enter your current password to verify it's you.
                </p>
                <input 
                    type="password" 
                    name="current_password" 
                    id="current_password" 
                    class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                    placeholder="Enter current password"
                    autocomplete="current-password"
                >
                @error('current_password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="new_password" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        New Password
                    </label>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                        Minimum 8 characters, include letters and numbers.
                    </p>
                    <input 
                        type="password" 
                        name="new_password" 
                        id="new_password" 
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                        placeholder="Enter new password"
                        autocomplete="new-password"
                    >
                    @error('new_password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="new_password_confirmation" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Confirm New Password
                    </label>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                        Re-enter the new password to confirm.
                    </p>
                    <input 
                        type="password" 
                        name="new_password_confirmation" 
                        id="new_password_confirmation" 
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                        placeholder="Confirm new password"
                        autocomplete="new-password"
                    >
                    @error('new_password_confirmation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4">
                <div class="flex gap-3">
                    <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 shrink-0">info</span>
                    <div class="text-sm text-amber-800 dark:text-amber-200">
                        <p class="font-semibold mb-1">Password Security Tips:</p>
                        <ul class="list-disc list-inside space-y-1 text-xs">
                            <li>Use at least 8 characters</li>
                            <li>Mix uppercase and lowercase letters</li>
                            <li>Include numbers and special characters</li>
                            <li>Don't use common words or personal info</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Media Links Section -->
        <div class="space-y-6 pt-8 border-t border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">share</span>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Social Media Links</h3>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">
                Add your social media profile URLs. These will be displayed in the website footer. Leave empty to hide the icon.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="social_linkedin" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        LinkedIn URL
                    </label>
                    <input 
                        type="url" 
                        name="social_linkedin" 
                        id="social_linkedin" 
                        value="{{ old('social_linkedin', $linkedinUrl) }}" 
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                        placeholder="https://linkedin.com/company/walconsultant"
                    >
                    @error('social_linkedin')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="social_twitter" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Twitter/X URL
                    </label>
                    <input 
                        type="url" 
                        name="social_twitter" 
                        id="social_twitter" 
                        value="{{ old('social_twitter', $twitterUrl) }}" 
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                        placeholder="https://twitter.com/walconsultant"
                    >
                    @error('social_twitter')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="social_facebook" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Facebook URL
                    </label>
                    <input 
                        type="url" 
                        name="social_facebook" 
                        id="social_facebook" 
                        value="{{ old('social_facebook', $facebookUrl) }}" 
                        class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/40 transition-all text-sm" 
                        placeholder="https://facebook.com/walconsultant"
                    >
                    @error('social_facebook')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Database Backup Section -->
        <div class="space-y-6 pt-8 border-t border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">storage</span>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Database Backup</h3>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">
                Export your database for backup purposes. Download a complete backup of your database as a SQL file.
            </p>

            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-6 border border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-primary text-2xl">download</span>
                    <h4 class="text-base font-bold text-slate-900 dark:text-white">Export Database</h4>
                </div>
                <p class="text-xs text-slate-600 dark:text-slate-400 mb-4">
                    Download a complete backup of your database as a SQL file. This backup includes all tables and data.
                </p>
                <a href="{{ route('admin.settings.database.export') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg font-semibold text-sm transition-all">
                    <span class="material-symbols-outlined text-lg">file_download</span>
                    Export Database
                </a>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 dark:border-slate-800">
            <button type="submit" class="px-6 h-11 inline-flex items-center justify-center bg-primary hover:bg-primary/90 text-white rounded-lg font-bold transition-all shadow-md shadow-primary/20">
                <span class="material-symbols-outlined text-[20px]">save</span>
                <span class="ml-2">Save Settings</span>
            </button>
        </div>
    </form>
</div>

<form action="{{ route('admin.settings.test-email') }}" method="POST" class="mt-4 flex justify-end">
    @csrf
    <button type="submit" class="px-6 h-11 inline-flex items-center justify-center border border-primary text-primary hover:bg-primary hover:text-white rounded-lg font-bold transition-all">
        <span class="material-symbols-outlined text-[20px]">mark_email_read</span>
        <span class="ml-2">Send SMTP Test Email</span>
    </button>
</form>

@endsection
