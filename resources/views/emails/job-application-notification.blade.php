<x-mail::message>
# New Job Application Received

A new job application has been submitted for the following position:

## Position Details

**Job Title:** {{ $job->title }}  
**Department:** {{ $job->department }}  
**Location:** {{ $job->location }}  
**Employment Type:** {{ $job->employment_type }}

## Applicant Information

**Name:** {{ $application->name }}  
**Email:** {{ $application->email }}  
**Phone:** {{ $application->phone ?? 'Not provided' }}  
**Application Date:** {{ $application->created_at->format('F d, Y \a\t g:i A') }}

@if($application->cover_letter)
## Cover Letter

{{ $application->cover_letter }}
@endif

@if($application->resume)
**Resume:** Attached to this email
@endif

<x-mail::button :url="route('admin.dashboard')">
View in Admin Panel
</x-mail::button>

Please review this application at your earliest convenience.

Best regards,  
**{{ config('app.name') }} System**
</x-mail::message>
