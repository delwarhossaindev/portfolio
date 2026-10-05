{{-- Plain-text part: output is unescaped on purpose (text/plain is never rendered as HTML). --}}
New message from your portfolio
===============================

Subject: {!! $contact->subject !!}
From:    {!! $contact->name !!} <{!! $contact->email !!}>
Date:    {{ $contact->created_at?->copy()->timezone(config('mail.contact.timezone'))->format('M j, Y g:i A T') }}

{!! $contact->message !!}

---
Reply to this email to answer {!! $contact->name !!} directly.
@if($contact->exists)
Dashboard: {{ route('admin.contacts.show', $contact) }}
@endif
