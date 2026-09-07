<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

#[Signature('admin:user {email} {--name=Administrator} {--password=}')]
#[Description('Create or update the administrator who can sign in to the dashboard.')]
class CreateAdminUserCommand extends Command
{
    public function handle(): int
    {
        $email = Str::lower($this->argument('email'));
        $name = (string) $this->option('name');
        $password = (string) $this->option('password');
        $generated = false;

        if ($password === '') {
            $password = Str::password(16);
            $generated = true;
        }

        $user = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => $password,
            ],
        );

        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();

        $this->info('Administrator saved: '.$email);

        if ($generated) {
            $this->warn('Generated password: '.$password);
        }

        return self::SUCCESS;
    }
}
