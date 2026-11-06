@component('mail::message')
# IT Services Inquiry

Dear Support Team,

A new IT services inquiry has been received:

**Name:** {{ $contact_name ?? 'N/A' }}
**Email:** {{ $contact_email ?? 'N/A' }}
**Phone:** {{ $phone ?? 'N/A' }}
**Subject:** {{ $subject ?? 'IT Services Support' }}

## Message:
{{ $message ?? 'N/A' }}

---

**Received on:** {{ now()->format('M d, Y H:i A') }}

@endcomponent