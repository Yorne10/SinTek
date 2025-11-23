<?php
/**
 * Company: CETAM
 * Project: ST
 * File: SecretaryUserSeeder.php
 * Created on: 06/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 *
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace Database\Seeders;

use App\Models\User;
use App\Models\Worker;
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
                'first_name' => 'María',
                'last_name' => 'González López',
                'gender' => 'F',
                'password' => Hash::make($password),
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
                'approved_at' => now(),
                'role' => 'secretary',
                'curp' => 'GOLM900215MDFRPR08',
                'budget_keys' => null,
            ]
        );

        // Las secretarias no necesitan perfil de Worker
    }
}
