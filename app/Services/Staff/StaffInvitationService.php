<?php

namespace App\Services\Staff;

use App\Mail\StaffInvitationMail;
use App\Models\StaffInvitation;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class StaffInvitationService
{
    public function send(
        string $email,
        ?string $name,
        string $role = 'staff',
        int $hours = 48
    ): StaffInvitation {
        $email = Str::lower(trim($email));

        if (User::where('email', $email)->where('is_active', true)->exists()) {
            throw new \InvalidArgumentException('An active staff account already uses this email address.');
        }

        $token = Str::random(64);
        $invitation = StaffInvitation::create([
            'email' => $email,
            'name' => $name,
            'role' => $role,
            'token_hash' => hash('sha256', $token),
            'expires_at' => now()->addHours(max(1, min(168, $hours))),
        ]);

        try {
            Mail::to($email)->send(new StaffInvitationMail(
                $invitation,
                route('staff.invitation.accept', ['token' => $token])
            ));
            $invitation->update(['sent_at' => now()]);
        } catch (\Throwable $exception) {
            $invitation->delete();
            throw $exception;
        }

        return $invitation;
    }
}
