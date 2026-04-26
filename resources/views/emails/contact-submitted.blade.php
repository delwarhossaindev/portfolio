<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
</head>
<body style="margin:0; padding:0; background:#f4f5f9; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif; color:#1a1a2e;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f5f9; padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.06);">

                    {{-- Header --}}
                    <tr>
                        <td style="background:linear-gradient(135deg,#6366f1,#ec4899); padding:32px 40px; text-align:left;">
                            <p style="margin:0 0 6px; color:rgba(255,255,255,0.85); font-size:13px; letter-spacing:2px; text-transform:uppercase; font-weight:600;">
                                New Inquiry
                            </p>
                            <h1 style="margin:0; color:#ffffff; font-size:24px; font-weight:700; line-height:1.3;">
                                Someone reached out via your portfolio
                            </h1>
                        </td>
                    </tr>

                    {{-- Subject --}}
                    <tr>
                        <td style="padding:32px 40px 8px;">
                            <p style="margin:0 0 6px; color:#7c7c9a; font-size:12px; text-transform:uppercase; letter-spacing:1px; font-weight:600;">Subject</p>
                            <h2 style="margin:0; color:#1a1a2e; font-size:20px; font-weight:700; line-height:1.4;">
                                {{ $contact->subject }}
                            </h2>
                        </td>
                    </tr>

                    {{-- Sender --}}
                    <tr>
                        <td style="padding:24px 40px 0;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8f9fc; border-radius:8px; padding:20px;">
                                <tr>
                                    <td>
                                        <p style="margin:0 0 4px; color:#7c7c9a; font-size:12px; text-transform:uppercase; letter-spacing:1px; font-weight:600;">From</p>
                                        <p style="margin:0; color:#1a1a2e; font-size:15px; font-weight:600;">
                                            {{ $contact->name }}
                                        </p>
                                        <p style="margin:4px 0 0;">
                                            <a href="mailto:{{ $contact->email }}" style="color:#6366f1; text-decoration:none; font-size:14px;">
                                                {{ $contact->email }}
                                            </a>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Message --}}
                    <tr>
                        <td style="padding:24px 40px;">
                            <p style="margin:0 0 8px; color:#7c7c9a; font-size:12px; text-transform:uppercase; letter-spacing:1px; font-weight:600;">Message</p>
                            <div style="color:#4a4a68; font-size:15px; line-height:1.7; white-space:pre-wrap;">{{ $contact->message }}</div>
                        </td>
                    </tr>

                    {{-- CTA --}}
                    <tr>
                        <td style="padding:8px 40px 32px;">
                            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}"
                               style="display:inline-block; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#ffffff; text-decoration:none; padding:12px 28px; border-radius:50px; font-size:14px; font-weight:600;">
                                Reply to {{ \Illuminate\Support\Str::before($contact->name, ' ') }}
                            </a>
                        </td>
                    </tr>

                    {{-- Meta --}}
                    <tr>
                        <td style="padding:20px 40px; background:#f8f9fc; border-top:1px solid #eef0f5;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="color:#7c7c9a; font-size:12px;">
                                        Received {{ $contact->created_at->format('M d, Y \a\t g:i A') }}
                                        @if($contact->ip_address)
                                            &nbsp;·&nbsp; IP: {{ $contact->ip_address }}
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>

                {{-- Footer note --}}
                <p style="margin:16px 0 0; color:#a1a1aa; font-size:12px; text-align:center;">
                    This email was sent from your portfolio contact form.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
