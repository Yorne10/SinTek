<?php
/**
 * Empresa: CETAM
 * Proyecto: ST
 * Archivo: WorkerUserSeeder.php
 * Fecha de creación: 03/11/25
 * Realizado por: Alfonso Angel García Hernández
 * Validado por: Alfonso Angel García Hernández
 */

namespace Database\Seeders;

use App\Models\User;
use App\Models\Worker;
use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WorkerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('WORKER_EMAIL', 'trabajador@sintek.test');
        $password = env('WORKER_PASSWORD', 'Worker2025!');

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Juan Pérez García',
                'password' => Hash::make($password),
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
                'role' => 'worker',
                'active' => 1,
            ]
        );

        // Ensure worker has a Worker profile
        $worker = Worker::firstOrCreate(
            ['user_id' => $user->users_id],
            [
                'curp' => 'PEGJ850315HDFRNN01',
                'sex' => 'M',
                'phone' => '5551234567',
                'adress' => 'Calle Principal #123, Colonia Centro',
                'rfc' => 'PEGJ850315XXX',
            ]
        );

        // Create sample positions
        $position1 = Position::firstOrCreate(
            ['budget_key' => 'CLAVE-001'],
            ['position_name' => 'Analista de Sistemas']
        );

        $position2 = Position::firstOrCreate(
            ['budget_key' => 'CLAVE-002'],
            ['position_name' => 'Técnico Administrativo']
        );

        // Attach positions to worker (many to many relationship)
        $worker->positions()->syncWithoutDetaching([$position1->positions_id, $position2->positions_id]);

        $this->command->info("Worker user created/found: {$user->email}");
        $this->command->info("Password: {$password}");
        $this->command->info("Worker profile created with 2 positions");
    }
}
