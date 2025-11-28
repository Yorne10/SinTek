<?php
/**
 * Company: CETAM
 * Project: ST
 * File: DatabaseSeeder.php
 * Created on: 24/11/2025
 * Created by: Claude Code
 * Approved by: Alfonso Angel García Hernández
 *
 * Description: Main database seeder
 * Password for all users: 123456Ab
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('====================================');
        $this->command->info('🌱 Iniciando seeders de CETAM SinTek');
        $this->command->info('====================================');
        $this->command->info('');

        $this->call([
            UserSeeder::class,
            PositionSeeder::class,
            ProcessSeeder::class,
            ConvocationSeeder::class,
            FaqSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('====================================');
        $this->command->info('✅ Seeders completados exitosamente');
        $this->command->info('====================================');
        $this->command->info('');
        $this->command->info('📧 Credenciales de acceso:');
        $this->command->info('');
        $this->command->info('👤 ADMIN:');
        $this->command->info('   Email: admin@cetam.gob.mx');
        $this->command->info('   Password: 123456Ab');
        $this->command->info('');
        $this->command->info('👤 SECRETARIA:');
        $this->command->info('   Email: secretaria@cetam.gob.mx');
        $this->command->info('   Password: 123456Ab');
        $this->command->info('');
        $this->command->info('👤 WORKERS (6 usuarios):');
        $this->command->info('   Email: juan.perez@cetam.gob.mx');
        $this->command->info('   Email: maria.gonzalez@cetam.gob.mx');
        $this->command->info('   Email: carlos.ramirez@cetam.gob.mx');
        $this->command->info('   Email: ana.martinez@cetam.gob.mx');
        $this->command->info('   Email: roberto.lopez@cetam.gob.mx');
        $this->command->info('   Email: pedro.test@cetam.gob.mx (inactivo)');
        $this->command->info('   Password: 123456Ab (todos)');
        $this->command->info('');
        $this->command->info('====================================');
    }
}
