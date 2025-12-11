<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ConvocationSeeder.php
 * Created on: 24/11/2025
 * Created by: Claude Code
 * Approved by: Alfonso Angel García Hernández
 *
 * Description: Seed convocations
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Convocation;
use Carbon\Carbon;

class ConvocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Convocatoria 1 - Activa
        Convocation::create([
            'title' => 'Convocatoria de Plaza Docente 2025-1',
            'description' => 'Se convoca a participar en el proceso de selección para cubrir una plaza de docente en el área de Ingeniería Industrial. Requisitos: Maestría en área afín, experiencia mínima de 2 años en docencia.',
            'start_date' => Carbon::now()->subDays(5),
            'end_date' => Carbon::now()->addDays(25),
            'status' => 'activa',
        ]);

        // Convocatoria 2 - Próxima
        Convocation::create([
            'title' => 'Convocatoria Personal Administrativo',
            'description' => 'Próximamente se publicará convocatoria para personal administrativo en el área de servicios escolares. Mantente atento a futuras actualizaciones.',
            'start_date' => Carbon::now()->addDays(10),
            'end_date' => Carbon::now()->addDays(40),
            'status' => 'proxima',
        ]);

        // Convocatoria 3 - Permanente
        Convocation::create([
            'title' => 'Programa de Becas CETAM',
            'description' => 'Convocatoria permanente para el programa de becas institucionales. Los trabajadores y sus dependientes pueden solicitar apoyo para estudios de nivel superior.',
            'start_date' => Carbon::now()->startOfYear(),
            'end_date' => Carbon::now()->endOfYear(),
            'status' => 'permanente',
        ]);

        // Convocatoria 4 - Cerrada
        Convocation::create([
            'title' => 'Convocatoria Plaza Mantenimiento 2024',
            'description' => 'Convocatoria para plaza de jefe de mantenimiento. Proceso cerrado.',
            'start_date' => Carbon::now()->subMonths(3),
            'end_date' => Carbon::now()->subMonths(2),
            'status' => 'cerrada',
        ]);

        // Convocatoria 5 - Activa
        Convocation::create([
            'title' => 'Curso de Capacitación Docente',
            'description' => 'Se invita a todos los docentes a participar en el curso de actualización pedagógica. Incluye temas de innovación educativa y uso de tecnologías en el aula.',
            'start_date' => Carbon::now()->subDays(2),
            'end_date' => Carbon::now()->addDays(15),
            'status' => 'activa',
        ]);

        $this->command->info('✅ Convocatorias creadas: 5');
        $this->command->info('   - 2 Activas');
        $this->command->info('   - 1 Próxima');
        $this->command->info('   - 1 Permanente');
        $this->command->info('   - 1 Cerrada');
    }
}
