<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrNew(['email' => env('STAFF_ADMIN_EMAIL', 'info@phoneexpresskenya.co.ke')]);
        $password = env('STAFF_ADMIN_PASSWORD');

        if (blank($password)) {
            throw new \RuntimeException('STAFF_ADMIN_PASSWORD must be configured before seeding the administrator.');
        }

        if (! $user->exists || ! $user->is_active) {
            $user->fill([
                'name' => env('STAFF_ADMIN_NAME', 'Phone Express Admin'),
                'password' => $password,
                'is_active' => true,
            ]);
        }

        $user->role = 'admin';
        $user->save();
    }
}
