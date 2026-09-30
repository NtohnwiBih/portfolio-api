<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Creates (or updates) the single admin account from .env:
     *   ADMIN_NAME, ADMIN_EMAIL, ADMIN_PASSWORD
     * Run: php artisan db:seed --class=AdminUserSeeder
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command?->error('Set ADMIN_EMAIL and ADMIN_PASSWORD in .env first.');
            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'Admin'),
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ],
        );

        $this->command?->info("Admin user ready: {$email}");
    }
}