<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Digital District Kenya staff invitation</title>
    <style>
        @media only screen and (max-width: 620px) {
            .email-shell { width: 100% !important; }
            .email-pad { padding: 28px 22px !important; }
            .hero-title { font-size: 30px !important; line-height: 1.12 !important; }
        }
    </style>
</head>
<body style="margin:0;padding:0;background:#f2f2f2;color:#141414;font-family:Arial,Helvetica,sans-serif;">
<div style="display:none;max-height:0;overflow:hidden;opacity:0;">Your secure invitation to join the Digital District Kenya staff workspace.</div>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f2f2f2;">
    <tr>
        <td align="center" style="padding:36px 14px;">
            <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" class="email-shell" style="width:600px;max-width:600px;background:#ffffff;border-radius:24px;overflow:hidden;box-shadow:0 18px 50px rgba(0,0,0,.1);">
                <tr>
                    <td class="email-pad" style="padding:30px 42px;background:#0a0a0a;border-bottom:4px solid #0a0a0a;">
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td>
                                    <img src="{{ asset('Images/digital-district-kenya-logo.png') }}" width="120" alt="Digital District Kenya" style="display:block;width:120px;max-width:100%;height:auto;border:0;background:#fff;padding:4px;border-radius:8px;">
                                </td>
                                <td align="right" style="color:#bdbdbd;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;">Staff workspace</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="email-pad" style="padding:46px 42px 24px;">
                        <span style="display:inline-block;padding:7px 11px;border-radius:99px;background:#f0f0f0;color:#0a0a0a;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;">Private invitation</span>
                        <h1 class="hero-title" style="margin:20px 0 14px;color:#0a0a0a;font-size:38px;line-height:1.12;letter-spacing:-1.2px;">Welcome to the<br>Digital District Kenya team.</h1>
                        <p style="margin:0;color:#666666;font-size:16px;line-height:1.7;">Hello {{ $invitation->name ?: 'there' }}, you’ve been invited to join the private Digital District Kenya staff workspace as <strong style="color:#0a0a0a;">{{ ucfirst($invitation->role) }}</strong>.</p>
                    </td>
                </tr>
                <tr>
                    <td class="email-pad" style="padding:8px 42px 30px;">
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f7f7f7;border:1px solid #e5e5e5;border-radius:16px;">
                            <tr>
                                <td style="padding:20px 22px;color:#555555;font-size:14px;line-height:1.6;">
                                    <strong style="display:block;margin-bottom:4px;color:#0a0a0a;font-size:15px;">Your secure staff access</strong>
                                    Review catalogue insights, manage phone information and collaborate with the team from one protected workspace.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="email-pad" style="padding:0 42px 42px;">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td align="center" bgcolor="#0a0a0a" style="border-radius:12px;">
                                    <a href="{{ $acceptUrl }}" style="display:inline-block;padding:16px 25px;color:#ffffff;font-size:15px;font-weight:700;text-decoration:none;">Accept invitation &nbsp;→</a>
                                </td>
                            </tr>
                        </table>
                        <p style="margin:22px 0 0;color:#777777;font-size:13px;line-height:1.6;">This link can only be used once and expires on <strong style="color:#333333;">{{ $invitation->expires_at->format('j M Y, g:i A') }}</strong>.</p>
                    </td>
                </tr>
                <tr>
                    <td class="email-pad" style="padding:24px 42px;background:#fafafa;border-top:1px solid #ebebeb;color:#888888;font-size:12px;line-height:1.6;">
                        This invitation was sent by Digital District Kenya. If you were not expecting it, you can safely ignore this email.<br>
                        <span style="color:#0a0a0a;font-weight:700;">Elevate your digital lifestyle.</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
