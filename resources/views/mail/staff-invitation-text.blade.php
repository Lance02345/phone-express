You’re invited to the Phone Express team

Hello {{ $invitation->name ?: 'there' }},

You’ve been invited to join the private Phone Express Kenya staff workspace as {{ ucfirst($invitation->role) }}.

Accept your invitation: {{ $acceptUrl }}

This secure link can only be used once and expires on {{ $invitation->expires_at->format('j M Y, g:i A') }}.

If you were not expecting this invitation, you can safely ignore this email.

Phone Express Kenya
Elevate your digital lifestyle.
