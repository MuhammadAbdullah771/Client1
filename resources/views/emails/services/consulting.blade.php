@component('mail::message')
# Consulting Inquiry

Dear Support Team,

A new consulting inquiry has been received:

**Name:** {{ $contact_name ?? 'N/A' }}
**Email:** {{ $contact_email ?? 'N/A' }}
**Phone:** {{ $phone ?? 'N/A' }}
**Company:** {{ $company ?? 'N/A' }}
**Subject:** {{ $subject ?? 'Consulting Services' }}

## Message:
{{ $message ?? 'N/A' }}

---

**Received on:** {{ now()->format('M d, Y H:i A') }}

@endcomponent