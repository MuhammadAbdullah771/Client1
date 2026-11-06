<x-mail::message>
# Thank You for Your Application

Dear {{ $application->name }},

Thank you for your interest in joining our team at **{{ config('app.name') }}**. We have successfully received your application for the position of **{{ $job->title }}**.

## Application Details

**Position:** {{ $job->title }}  
**Department:** {{ $job->department }}  
**Location:** {{ $job->location }}  
**Employment Type:** {{ $job->employment_type }}

Our team will review your application and get back to you within the next few business days. We appreciate your patience during this process.

If you have any questions or need to update your application, please don't hesitate to contact us.

<x-mail::button :url="route('careers')">
View Other Openings
</x-mail::button>

Best regards,  
**{{ config('app.name') }} Team**
</x-mail::message>
