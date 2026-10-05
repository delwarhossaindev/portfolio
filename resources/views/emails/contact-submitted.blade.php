@extends('emails.layout')

@php
    $receivedAt = $contact->created_at?->copy()->timezone(config('mail.contact.timezone'));
    $firstName = \Illuminate\Support\Str::before(trim($contact->name), ' ') ?: $contact->name;
    $replyUrl = 'mailto:' . $contact->email . '?subject=' . rawurlencode('Re: ' . $contact->subject);
@endphp

@section('title', 'New message: ' . $contact->subject)
@section('preheader', $contact->name . ' — ' . \Illuminate\Support\Str::limit($contact->message, 90))
@section('eyebrow', 'New inquiry')
@section('heading', 'Someone reached out via your portfolio')

@section('content')
    {{-- Subject --}}
    <tr>
        <td style="padding:30px 40px 6px;">
            <p style="margin:0 0 6px; color:#7c7c9a; font-size:12px; text-transform:uppercase; letter-spacing:1px; font-weight:700;">Subject</p>
            <h2 style="margin:0; color:#1a1a2e; font-size:19px; font-weight:700; line-height:1.4;">{{ $contact->subject }}</h2>
        </td>
    </tr>

    {{-- Sender --}}
    <tr>
        <td style="padding:20px 40px 0;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8f9fc; border:1px solid #eef0f5; border-radius:10px;">
                <tr>
                    <td style="padding:16px 20px;">
                        <p style="margin:0 0 4px; color:#7c7c9a; font-size:12px; text-transform:uppercase; letter-spacing:1px; font-weight:700;">From</p>
                        <p style="margin:0; color:#1a1a2e; font-size:15px; font-weight:600;">{{ $contact->name }}</p>
                        <p style="margin:4px 0 0;">
                            <a href="mailto:{{ $contact->email }}" style="color:#6366f1; text-decoration:none; font-size:14px;">{{ $contact->email }}</a>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Message --}}
    <tr>
        <td style="padding:24px 40px 8px;">
            <p style="margin:0 0 8px; color:#7c7c9a; font-size:12px; text-transform:uppercase; letter-spacing:1px; font-weight:700;">Message</p>
            <div style="color:#374151; font-size:15px; line-height:1.7; white-space:pre-wrap; word-wrap:break-word;">{{ $contact->message }}</div>
        </td>
    </tr>

    {{-- Actions --}}
    <tr>
        <td style="padding:20px 40px 30px;">
            <table role="presentation" cellpadding="0" cellspacing="0">
                <tr>
                    <td bgcolor="#6366f1" style="background-color:#6366f1; border-radius:50px;">
                        <a href="{{ $replyUrl }}" style="display:inline-block; padding:12px 26px; color:#ffffff; text-decoration:none; font-size:14px; font-weight:700;">Reply to {{ $firstName }}</a>
                    </td>
                    @if($contact->exists)
                        <td style="width:10px;"></td>
                        <td style="border:1px solid #d6d9e3; border-radius:50px;">
                            <a href="{{ route('admin.contacts.show', $contact) }}" style="display:inline-block; padding:11px 22px; color:#374151; text-decoration:none; font-size:14px; font-weight:600;">Open in dashboard</a>
                        </td>
                    @endif
                </tr>
            </table>
        </td>
    </tr>

    {{-- Meta --}}
    <tr>
        <td style="padding:16px 40px; background-color:#f8f9fc; border-top:1px solid #eef0f5; color:#7c7c9a; font-size:12px;">
            Received {{ $receivedAt?->format('M j, Y \a\t g:i A T') }}
            @if($contact->ip_address)
                &nbsp;·&nbsp; IP {{ $contact->ip_address }}
            @endif
        </td>
    </tr>
@endsection

@section('footer', 'Sent from the contact form on your portfolio. Replying goes straight to the sender.')
