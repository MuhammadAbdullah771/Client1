<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Setting;
use App\Services\MailService;
use App\Support\ContactMailConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CareerController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::where('is_active', true);

        if ($request->has('department') && $request->department !== 'all') {
            $query->where('department', $request->department);
        }

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('department', $request->category);
        }

        $jobs = $query->orderBy('created_at', 'desc')->get();

        // Get admin email for potential display (not used for SMTP anymore)
        $adminEmail = Setting::get('job_notification_email', '');

        return view('careers', compact('jobs', 'adminEmail'));
    }

    public function apply(Request $request, $id)
    {
        // Legacy flow (mailto / redirects). Left untouched.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'cover_letter' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ], [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'resume.mimes' => 'Resume must be a PDF, DOC, or DOCX file.',
            'resume.max' => 'Resume file size must not exceed 2MB.',
        ]);

        $job = Job::findOrFail($id);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'job_id' => $id,
            'status' => 'pending',
        ];

        if ($request->hasFile('resume')) {
            try {
                $storagePath = storage_path('app/public/resumes');
                if (! file_exists($storagePath)) {
                    File::makeDirectory($storagePath, 0755, true);
                }

                if (! is_writable($storagePath)) {
                    throw new \Exception('Storage directory is not writable. Please check permissions.');
                }

                $file = $request->file('resume');
                if (! $file->isValid()) {
                    throw new \Exception('Invalid file upload: '.$file->getError());
                }

                $path = $file->store('resumes', 'public');
                if (! $path) {
                    throw new \Exception('Failed to store file');
                }

                $fullPath = storage_path('app/public/'.$path);
                if (! file_exists($fullPath)) {
                    throw new \Exception('File was not saved to storage');
                }

                $data['resume'] = '/storage/'.$path;
            } catch (\Exception $e) {
                Log::error('Resume upload failed: '.$e->getMessage(), [
                    'file' => $request->file('resume')->getClientOriginalName(),
                    'size' => $request->file('resume')->getSize(),
                    'storage_path' => storage_path('app/public/resumes'),
                    'writable' => is_writable(storage_path('app/public')),
                ]);

                return back()->withInput()->withErrors([
                    'resume' => 'Failed to upload resume: '.$e->getMessage().'. Please check file permissions and storage directory.',
                ]);
            }
        }

        try {
            $application = JobApplication::create($data);
        } catch (\Exception $e) {
            Log::error('Job application creation failed: '.$e->getMessage(), [
                'job_id' => $id,
                'data' => $data,
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Failed to submit application: '.$e->getMessage(),
            ]);
        }

        $adminEmail = Setting::get('job_notification_email');

        if (empty($adminEmail) || ! filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
            Log::warning('Admin email not configured in Settings.');

            return back()->with('error', 'Email notification is not configured. Please contact administrator.');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully!',
                'admin_email' => $adminEmail,
                'application_data' => [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'] ?? 'Not provided',
                    'cover_letter' => $validated['cover_letter'] ?? '',
                    'job_title' => $job->title,
                    'job_department' => $job->department,
                    'job_location' => $job->location,
                ],
            ]);
        }

        return back()->with('success', 'Application submitted successfully!')
            ->with('open_email', true)
            ->with('admin_email', $adminEmail)
            ->with('application_data', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? 'Not provided',
                'cover_letter' => $validated['cover_letter'] ?? '',
                'job_title' => $job->title,
                'job_department' => $job->department,
                'job_location' => $job->location,
            ]);
    }

    public function submitApplication(Request $request)
    {
        $validated = $request->validate([
            'job_id' => 'required|integer|exists:job_listings,id',
            'job_position' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'cover_letter' => 'nullable|string|max:2000',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'privacy_consent' => 'required|accepted',
        ], [
            'job_position.required' => 'Please select a job position.',
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter your phone number.',
            'resume.mimes' => 'Resume must be a PDF, DOC, or DOCX file.',
            'resume.max' => 'Resume file size must not exceed 2MB.',
            'privacy_consent.required' => 'You must agree to the privacy policy.',
        ]);

        $jobId = (int) $validated['job_id'];
        $job = Job::where('is_active', true)->findOrFail($jobId);

        /*
        |--------------------------------------------------------------------------
        | HANDLE RESUME UPLOAD (for DB + email attachment)
        |--------------------------------------------------------------------------
        */

        $filePath = null; // public URL (/storage/...)
        $resumeFullPath = null; // server path for attachment
        $resumeFileName = null;
        $resumeMimeType = null;

        if ($request->hasFile('resume')) {
            try {
                $storagePath = storage_path('app/public/resumes');
                if (! file_exists($storagePath)) {
                    File::makeDirectory($storagePath, 0755, true);
                }

                if (! is_writable($storagePath)) {
                    throw new \Exception('Storage directory is not writable.');
                }

                $file = $request->file('resume');
                if (! $file->isValid()) {
                    throw new \Exception('Invalid file upload.');
                }

                $path = $file->store('resumes', 'public');
                if (! $path) {
                    throw new \Exception('Failed to store file');
                }

                $resumeFullPath = storage_path('app/public/'.$path);
                if (! file_exists($resumeFullPath)) {
                    throw new \Exception('File was not saved to storage');
                }

                $filePath = '/storage/'.$path;
                $resumeFileName = $file->getClientOriginalName();
                $resumeMimeType = $file->getClientMimeType();
            } catch (\Exception $e) {
                Log::error('Resume upload failed: '.$e->getMessage());

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload resume: '.$e->getMessage(),
                    'errors' => ['resume' => ['Failed to upload resume. Please try again.']],
                ], 422);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE APPLICATION (if job exists)
        |--------------------------------------------------------------------------
        */

        try {
            $applicationData = [
                'name' => $validated['first_name'].' '.$validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'cover_letter' => $validated['cover_letter'] ?? null,
                'job_id' => $jobId,
                'status' => 'pending',
            ];

            if ($filePath) {
                $applicationData['resume'] = $filePath;
            }

            JobApplication::create($applicationData);
        } catch (\Exception $e) {
            Log::error('Job application creation failed: '.$e->getMessage(), [
                'job_id' => $jobId,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'The application could not be saved. Please try again later.',
            ], 500);
        }

        /*
        |--------------------------------------------------------------------------
        | DETERMINE RECIPIENT
        |  - Primary: secure-admin job notification email
        |--------------------------------------------------------------------------
        */

        $primaryRecipient = ContactMailConfig::firstValidEmail([
            Setting::get('job_notification_email'),
            config('mail.from.address'),
        ]);
        if (! filter_var($primaryRecipient, FILTER_VALIDATE_EMAIL)) {
            Log::error('Primary job notification email invalid.', [
                'primary' => $primaryRecipient,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Email notification is not configured correctly. Please contact administrator.',
            ], 500);
        }

        /*
        |--------------------------------------------------------------------------
        | BUILD EMAIL BODY & SEND VIA SMTP
        |--------------------------------------------------------------------------
        */

        $jobTitle = $job->title ?? 'N/A';
        $jobDepartment = $job->department ?? 'N/A';
        $jobLocation = $job->location ?? 'N/A';

        $emailBody =
            "New Job Application\n\n".
            "Applicant Name: {$validated['first_name']} {$validated['last_name']}\n".
            "Email: {$validated['email']}\n".
            "Phone: {$validated['phone']}\n\n".
            "Position: {$jobTitle}\n".
            "Department: {$jobDepartment}\n".
            "Location: {$jobLocation}\n\n".
            "Cover Letter:\n".
            ($validated['cover_letter'] ?? 'N/A')."\n\n".
            'IP Address: '.$request->ip()."\n".
            'Submitted At: '.now()->toDateTimeString();

        try {
            MailService::configureMailFromSettings();

            Mail::mailer('smtp')->raw($emailBody, function ($message) use (
                $primaryRecipient,
                $validated,
                $resumeFullPath,
                $resumeFileName,
                $resumeMimeType,
                $jobTitle
            ) {
                $fromAddress = config('mail.from.address');
                $fromName = config('mail.from.name');

                $subject = 'New Job Application - '.$jobTitle;

                $message
                    ->from($fromAddress, $fromName)
                    ->to($primaryRecipient)
                    ->replyTo($validated['email'])
                    ->subject($subject);

                if ($resumeFullPath && file_exists($resumeFullPath)) {
                    $message->attach(
                        $resumeFullPath,
                        [
                            'as' => $resumeFileName ?: basename($resumeFullPath),
                            'mime' => $resumeMimeType ?: 'application/octet-stream',
                        ]
                    );
                }
            });

            Log::info('Job application email sent successfully', [
                'to' => $primaryRecipient,
                'job_id' => $jobId,
                'department' => $jobDepartment,
            ]);

        } catch (\Exception $e) {
            Log::error('Job application email failed: '.$e->getMessage(), [
                'to' => $primaryRecipient,
                'job_id' => $jobId,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Your application was saved, but the email notification could not be delivered. Please try again later.',
            ], 502);
        }

        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully!',
            'email' => $primaryRecipient,
        ]);
    }
}
