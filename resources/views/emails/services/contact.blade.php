@component('mail::message')
# Contact Form Submission

Dear Support Team,

A new contact form submission has been received:

**Name:** {{ $contact_name ?? 'N/A' }}
**Email:** {{ $contact_email ?? 'N/A' }}
**Phone:** {{ $phone ?? 'N/A' }}
**Subject:** {{ $subject ?? 'General Inquiry' }}

## Message:
{{ $message ?? 'N/A' }}

---

**Received on:** {{ now()->format('M d, Y H:i A') }}

@endcomponent