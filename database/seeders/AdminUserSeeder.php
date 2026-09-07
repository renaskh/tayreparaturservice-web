<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the administrator account from configuration.
     */
    public function run(): void
    {
        $email = config('admin.email');
        $password = config('admin.password');

        if (! is_string($email) || $email === '' || ! is_string($password) || $password === '') {
            return;
        }

        $user = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => config('admin.name') ?: 'Administrator',
                'password' => $password,
            ],
        );

        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();
    }
}
