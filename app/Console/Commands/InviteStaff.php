<?php

namespace App\Console\Commands;

use App\Services\Staff\StaffInvitationService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InviteStaff extends Command
{
    protected $signature = 'staff:invite {email} {--name=} {--role=staff} {--hours=48}';

    protected $description = 'Send an expiring invite to a Phone Express staff member';

    public function handle(StaffInvitationService $invitations): int
    {
        $email = Str::lower(trim((string) $this->argument('email')));
        $role = (string) $this->option('role');
        $hours = max(1, min(168, (int) $this->option('hours')));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || ! in_array($role, ['admin', 'staff'], true)) {
            $this->error('Provide a valid email and a role of admin or staff.');

            return self::FAILURE;
        }

        try {
            $invitations->send($email, $this->option('name'), $role, $hours);
        } catch (\Throwable $exception) {
            $this->error('The invitation was not sent: '.$exception->getMessage());

            return self::FAILURE;
        }

        $this->info("Invitation sent to {$email}. Link expires in {$hours} hours.");

        return self::SUCCESS;
    }
}
