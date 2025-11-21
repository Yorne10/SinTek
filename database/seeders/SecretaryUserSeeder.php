<?php
/**
 * Company: CETAM
 * Project: ST
 * File: SecretaryUserSeeder.php
 * Created on: 06/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 */

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SecretaryUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('SECRETARY_EMAIL', 'secretaria@sintek.test');
        $password = env('SECRETARY_PASSWORD', 'Secretary2025!');

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'María González López',
                'password' => Hash::make($password),
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
                'role' => 'secretary',
                'active' => 1,
            ]
        );

        $this->command->info("Secretary user created/found: {$user->email}");
        $this->command->info("Password: {$password}");
    }
}
