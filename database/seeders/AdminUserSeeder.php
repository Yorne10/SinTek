<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Worker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@sintek.test');
        $password = env('ADMIN_PASSWORD', 'SinTek2025!');

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin Principal',
                'password' => Hash::make($password),
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
                'role' => 'admin',
                'active' => 1,
            ]
        );

        $this->command->info("Admin user created/found: {$user->email}");
        $this->command->info("Password: {$password}");
    }
}
