{{-- Plain-text part: output is unescaped on purpose (text/plain is never rendered as HTML). --}}
Hi {!! $greetingName !!},

Thanks for reaching out! Your message has landed safely in my inbox.
I read every message personally and usually reply within 1-2 business days.

If it's urgent, just reply to this email and it will come straight to me.

My recent work: {{ url('/') }}#projects

--
{!! $owner->hero_name !!}
{!! \Illuminate\Support\Str::before($owner->hero_roles ?: 'Full Stack Developer', ',') !!}
@if($owner->linkedin_url)
LinkedIn: {!! $owner->linkedin_url !!}
@endif
@if($owner->github_url)
GitHub: {!! $owner->github_url !!}
@endif

You're receiving this because you used the contact form on my website.
