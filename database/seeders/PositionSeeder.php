<?php
/**
 * Company: CETAM
 * Project: ST
 * File: PositionSeeder.php
 * Created on: 24/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;
use App\Models\Worker;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear puestos
        $positions = [
            [
                'position_name' => 'Docente Titular',
                'budget_key' => 'DOC-TIT-001',
            ],
            [
                'position_name' => 'Docente Asociado',
                'budget_key' => 'DOC-ASO-002',
            ],
            [
                'position_name' => 'Coordinador Académico',
                'budget_key' => 'COORD-ACA-003',
            ],
            [
                'position_name' => 'Administrativo',
                'budget_key' => 'ADM-GEN-004',
            ],
            [
                'position_name' => 'Jefe de Mantenimiento',
                'budget_key' => 'MANT-JEF-005',
            ],
            [
                'position_name' => 'Técnico Auxiliar',
                'budget_key' => 'TEC-AUX-006',
            ],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }

        // Asignar puestos a workers
        $workers = Worker::all();

        if ($workers->count() >= 6) {
            // Worker 1 (Juan) - Docente Titular
            DB::table('positions_workers')->insert([
                'positions_id' => 1,
                'workers_id' => $workers[0]->workers_id,
                'assigned_at' => now(),
            ]);

            // Worker 2 (María) - Administrativo
            DB::table('positions_workers')->insert([
                'positions_id' => 4,
                'workers_id' => $workers[1]->workers_id,
                'assigned_at' => now(),
            ]);

            // Worker 3 (Carlos) - Jefe de Mantenimiento
            DB::table('positions_workers')->insert([
                'positions_id' => 5,
                'workers_id' => $workers[2]->workers_id,
                'assigned_at' => now(),
            ]);

            // Worker 4 (Ana) - Docente Asociado
            DB::table('positions_workers')->insert([
                'positions_id' => 2,
                'workers_id' => $workers[3]->workers_id,
                'assigned_at' => now(),
            ]);

            // Worker 5 (Roberto) - Coordinador Académico
            DB::table('positions_workers')->insert([
                'positions_id' => 3,
                'workers_id' => $workers[4]->workers_id,
                'assigned_at' => now(),
            ]);

            // Worker 6 (Pedro Test) - Técnico Auxiliar
            DB::table('positions_workers')->insert([
                'positions_id' => 6,
                'workers_id' => $workers[5]->workers_id,
                'assigned_at' => now(),
            ]);
        }

        $this->command->info('✅ Puestos creados: 6');
        $this->command->info('✅ Asignaciones realizadas: ' . $workers->count());
    }
}
