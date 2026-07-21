<x-mail::message>
# New Contact Message Received

You have received a new contact message from **{{ $contactData['name'] }}**.

**Sender Details:**
- **Name:** {{ $contactData['name'] }}
- **Email:** {{ $contactData['email'] }}
- **Phone:** {{ $contactData['phone'] }}
- **Subject:** {{ $contactData['subject'] }}

**Message:**
{{ $contactData['message'] }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
