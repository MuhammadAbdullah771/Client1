@component('mail::message')
# Recruitment Inquiry

Dear HR Team,

A new recruitment inquiry has been received:

**Name:** {{ $contact_name ?? 'N/A' }}
**Email:** {{ $contact_email ?? 'N/A' }}
**Phone:** {{ $phone ?? 'N/A' }}
**Position:** {{ $position ?? 'N/A' }}
**Subject:** {{ $subject ?? 'Recruitment Services' }}

## Message:
{{ $message ?? 'N/A' }}

---

**Received on:** {{ now()->format('M d, Y H:i A') }}

@endcomponent