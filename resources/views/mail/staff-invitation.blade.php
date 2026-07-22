<x-mail::message>
# You’re invited to the Phone Express team

Hello {{ $invitation->name ?: 'there' }},

You’ve been invited as **{{ ucfirst($invitation->role) }}** to our private staff workspace, where the team manages the phone catalogue and customer insights.

@if($invitation->custom_message)
{{ $invitation->custom_message }}
@endif

<x-mail::button :url="$acceptUrl">
Accept invitation
</x-mail::button>

This private link expires **{{ $invitation->expires_at->format('j M Y, g:i A') }}** and can only be used once. You’ll choose your own password when you accept it.

If you were not expecting this invitation, no action is needed.

Thanks,  
Phone Express Kenya
</x-mail::message>
