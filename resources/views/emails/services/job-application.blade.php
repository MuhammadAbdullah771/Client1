@component('mail::message')
# Job Application Received

Dear {{ $recipient_name ?? 'Hiring Team' }},

A new job application has been submitted for the position: **{{ $job_title ?? 'N/A' }}**

**Applicant Details:**

- **Name:** {{ $applicant_name ?? 'N/A' }}
- **Email:** {{ $applicant_email ?? 'N/A' }}
- **Phone:** {{ $applicant_phone ?? 'N/A' }}
- **Applied on:** {{ now()->format('M d, Y H:i A') }}

## Application Summary:
{{ $summary ?? 'No additional details provided.' }}

@if(!empty($resume_attached))
    📎 **Resume attached**
@endif

---

Thank you for using our recruitment system.

@endcomponent