You’re invited to the Digital District Kenya team

Hello {{ $invitation->name ?: 'there' }},

You’ve been invited to join the private Digital District Kenya staff workspace as {{ ucfirst($invitation->role) }}.

Accept your invitation: {{ $acceptUrl }}

This secure link can only be used once and expires on {{ $invitation->expires_at->format('j M Y, g:i A') }}.

If you were not expecting this invitation, you can safely ignore this email.

Digital District Kenya
Elevate your digital lifestyle.
