<?php
/**
 * Company: CETAM
 * Project: ST
 * File: UserSeeder.php
 * Created on: 24/11/2025
 * Created by: Claude Code
 * Approved by: Alfonso Angel García Hernández
 *
 * Description: Seed users, workers and their positions
 * Password for all users: 123456Ab
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Worker;
use App\Models\Position;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Password común para todos los usuarios
        $password = Hash::make('123456Ab');

        // ============================================
        // ADMIN
        // ============================================
        $admin = User::create([
            'name' => 'Administrador Sistema',
            'email' => 'admin@cetam.gob.mx',
            'password' => $password,
            'role' => 'admin',
            'is_active' => true,
        ]);

        // ============================================
        // SECRETARY
        // ============================================
        $secretary = User::create([
            'name' => 'Secretaria General',
            'email' => 'secretaria@cetam.gob.mx',
            'password' => $password,
            'role' => 'secretary',
            'is_active' => true,
        ]);

        // ============================================
        // WORKERS
        // ============================================

        // Worker 1 - Docente
        $user1 = User::create([
            'name' => 'Juan Pérez García',
            'email' => 'juan.perez@cetam.gob.mx',
            'password' => $password,
            'role' => 'worker',
            'is_active' => true,
        ]);

        $worker1 = Worker::create([
            'user_id' => $user1->users_id,
            'curp' => 'PEGJ850615HDFRNN01',
            'rfc' => 'PEGJ850615AB1',
            'sex' => 'M',
            'phone' => '6141234567',
            'address' => 'Calle Revolución 123, Chihuahua, Chih.',
        ]);

        // Worker 2 - Administrativo
        $user2 = User::create([
            'name' => 'María González López',
            'email' => 'maria.gonzalez@cetam.gob.mx',
            'password' => $password,
            'role' => 'worker',
            'is_active' => true,
        ]);

        $worker2 = Worker::create([
            'user_id' => $user2->users_id,
            'curp' => 'GOLM900320MDFLPR02',
            'rfc' => 'GOLM900320CD2',
            'sex' => 'F',
            'phone' => '6149876543',
            'address' => 'Av. Universidad 456, Chihuahua, Chih.',
        ]);

        // Worker 3 - Mantenimiento
        $user3 = User::create([
            'name' => 'Carlos Ramírez Sánchez',
            'email' => 'carlos.ramirez@cetam.gob.mx',
            'password' => $password,
            'role' => 'worker',
            'is_active' => true,
        ]);

        $worker3 = Worker::create([
            'user_id' => $user3->users_id,
            'curp' => 'RASC880710HDFMRR03',
            'rfc' => 'RASC880710EF3',
            'sex' => 'M',
            'phone' => '6145551234',
            'address' => 'Blvd. Tecnológico 789, Chihuahua, Chih.',
        ]);

        // Worker 4 - Docente
        $user4 = User::create([
            'name' => 'Ana Martínez Hernández',
            'email' => 'ana.martinez@cetam.gob.mx',
            'password' => $password,
            'role' => 'worker',
            'is_active' => true,
        ]);

        $worker4 = Worker::create([
            'user_id' => $user4->users_id,
            'curp' => 'MAHA920815MDFRNN04',
            'rfc' => 'MAHA920815GH4',
            'sex' => 'F',
            'phone' => '6143334455',
            'address' => 'Calle Libertad 321, Chihuahua, Chih.',
        ]);

        // Worker 5 - Coordinador
        $user5 = User::create([
            'name' => 'Roberto López Mendoza',
            'email' => 'roberto.lopez@cetam.gob.mx',
            'password' => $password,
            'role' => 'worker',
            'is_active' => true,
        ]);

        $worker5 = Worker::create([
            'user_id' => $user5->users_id,
            'curp' => 'LOMR870925HDFPNB05',
            'rfc' => 'LOMR870925IJ5',
            'sex' => 'M',
            'phone' => '6147778899',
            'address' => 'Av. Industrial 654, Chihuahua, Chih.',
        ]);

        // Worker 6 - Test inactivo
        $user6 = User::create([
            'name' => 'Pedro Inactive Test',
            'email' => 'pedro.test@cetam.gob.mx',
            'password' => $password,
            'role' => 'worker',
            'is_active' => false, // Usuario inactivo para testing
        ]);

        $worker6 = Worker::create([
            'user_id' => $user6->users_id,
            'curp' => 'TESP950101HDFSTS06',
            'rfc' => 'TESP950101KL6',
            'sex' => 'M',
            'phone' => '6140000000',
            'address' => 'Calle Test 999, Chihuahua, Chih.',
        ]);

        $this->command->info('✅ Usuarios creados: 2 administrativos + 6 workers');
        $this->command->info('📧 Email admin: admin@cetam.gob.mx');
        $this->command->info('📧 Email secretaria: secretaria@cetam.gob.mx');
        $this->command->info('🔑 Contraseña para todos: 123456Ab');
    }
}
