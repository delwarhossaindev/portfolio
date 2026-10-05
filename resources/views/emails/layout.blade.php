<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="color-scheme" content="light">
    <title>@yield('title')</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f5f9; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif; color:#1a1a2e; -webkit-text-size-adjust:100%;">
    {{-- Inbox preview text (hidden in the body) --}}
    <div style="display:none; max-height:0; overflow:hidden; mso-hide:all; font-size:1px; line-height:1px; color:#f4f5f9;">
        @yield('preheader')
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f5f9; padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="width:100%; max-width:600px;">
                    {{-- Brand --}}
                    <tr>
                        <td style="padding:0 4px 16px; font-size:15px; font-weight:800; letter-spacing:3px; color:#6366f1;">
                            {{ mb_strtoupper(config('app.name')) }}
                        </td>
                    </tr>
                </table>

                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="width:100%; max-width:600px; background-color:#ffffff; border-radius:14px; overflow:hidden; border:1px solid #eceef5;">
                    {{-- Header --}}
                    <tr>
                        <td bgcolor="#6366f1" style="background-color:#6366f1; background-image:linear-gradient(135deg,#6366f1,#a855f7); padding:30px 40px;">
                            <p style="margin:0 0 6px; color:#e0e7ff; font-size:12px; letter-spacing:2px; text-transform:uppercase; font-weight:700;">
                                @yield('eyebrow')
                            </p>
                            <h1 style="margin:0; color:#ffffff; font-size:23px; font-weight:700; line-height:1.35;">
                                @yield('heading')
                            </h1>
                        </td>
                    </tr>

                    @yield('content')
                </table>

                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="width:100%; max-width:600px;">
                    <tr>
                        <td style="padding:18px 4px 0; color:#9ca3af; font-size:12px; line-height:1.6; text-align:center;">
                            @yield('footer')
                            <br>
                            <a href="{{ url('/') }}" style="color:#9ca3af; text-decoration:underline;">{{ parse_url(url('/'), PHP_URL_HOST) }}</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
