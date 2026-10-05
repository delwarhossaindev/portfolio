@extends('emails.layout')

@section('title', 'Thanks for getting in touch')
@section('preheader', 'Your message reached me — I usually reply within 1–2 business days.')
@section('eyebrow', 'Message received')
@section('heading', 'Thanks for reaching out, ' . $greetingName . '!')

@section('content')
    <tr>
        <td style="padding:30px 40px 8px; color:#374151; font-size:15px; line-height:1.75;">
            <p style="margin:0 0 14px;">Your message has landed safely in my inbox. I read every message personally and usually reply within <strong>1–2 business days</strong>.</p>
            <p style="margin:0 0 14px;">If it's urgent, just reply to this email and it will come straight to me.</p>
            <p style="margin:0;">In the meantime, feel free to look around my recent work.</p>
        </td>
    </tr>

    <tr>
        <td style="padding:20px 40px 30px;">
            <table role="presentation" cellpadding="0" cellspacing="0">
                <tr>
                    <td bgcolor="#6366f1" style="background-color:#6366f1; border-radius:50px;">
                        <a href="{{ url('/') }}#projects" style="display:inline-block; padding:12px 26px; color:#ffffff; text-decoration:none; font-size:14px; font-weight:700;">View my projects</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td style="padding:20px 40px; background-color:#f8f9fc; border-top:1px solid #eef0f5; color:#374151; font-size:14px; line-height:1.6;">
            <strong style="color:#1a1a2e;">{{ $owner->hero_name }}</strong><br>
            <span style="color:#7c7c9a;">{{ \Illuminate\Support\Str::before($owner->hero_roles ?: 'Full Stack Developer', ',') }}</span>
            @if($owner->linkedin_url || $owner->github_url)
                <br>
                @if($owner->linkedin_url)
                    <a href="{{ $owner->linkedin_url }}" style="color:#6366f1; text-decoration:none;">LinkedIn</a>
                @endif
                @if($owner->linkedin_url && $owner->github_url) &nbsp;·&nbsp; @endif
                @if($owner->github_url)
                    <a href="{{ $owner->github_url }}" style="color:#6366f1; text-decoration:none;">GitHub</a>
                @endif
            @endif
        </td>
    </tr>
@endsection

@section('footer', "You're receiving this because you used the contact form on my website. No further emails will be sent unless you reply.")
