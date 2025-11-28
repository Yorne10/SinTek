<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ProcessSeeder.php
 * Created on: 24/11/2025
 * Created by: Claude Code
 * Approved by: Alfonso Angel García Hernández
 *
 * Description: Seed processes and steps
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Process;
use App\Models\Step;
use App\Models\User;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        // ============================================
        // PROCESO 1: Solicitud de Constancia Laboral
        // ============================================
        $process1 = Process::create([
            'name' => 'Solicitud de Constancia Laboral',
            'process_code' => 'CONST-LAB-001',
            'description' => 'Trámite para solicitar una constancia que acredite la relación laboral con CETAM',
            'category' => 'Documentación',
            'priority' => 'media',
            'deadline_days' => 5,
            'department' => 'Recursos Humanos',
            'active' => true,
            'created_by' => $admin->users_id ?? null,
        ]);

        Step::create([
            'process_id' => $process1->process_id,
            'order' => 1,
            'tittle' => 'Llenar solicitud',
            'description' => 'El trabajador debe llenar el formulario de solicitud de constancia',
            'instructions' => 'Ingrese sus datos personales y especifique el tipo de constancia requerida',
            'condition_type' => 'normal',
            'responsible' => 'Trabajador',
            'deadline_days' => 1,
            'priority' => 'media',
            'send_notification' => true,
            'requires_documents' => false,
        ]);

        Step::create([
            'process_id' => $process1->process_id,
            'order' => 2,
            'tittle' => 'Revisión de documentos',
            'description' => 'Recursos Humanos revisa la solicitud',
            'instructions' => 'Verificar que los datos sean correctos y que el trabajador esté activo',
            'condition_type' => 'normal',
            'responsible' => 'Recursos Humanos',
            'deadline_days' => 2,
            'priority' => 'media',
            'send_notification' => true,
            'requires_documents' => false,
        ]);

        Step::create([
            'process_id' => $process1->process_id,
            'order' => 3,
            'tittle' => 'Emisión de constancia',
            'description' => 'Se genera y firma la constancia laboral',
            'instructions' => 'Generar el documento oficial con sello y firma autorizada',
            'condition_type' => 'normal',
            'responsible' => 'Dirección',
            'deadline_days' => 2,
            'priority' => 'media',
            'send_notification' => true,
            'requires_documents' => false,
        ]);

        // ============================================
        // PROCESO 2: Solicitud de Vacaciones
        // ============================================
        $process2 = Process::create([
            'name' => 'Solicitud de Vacaciones',
            'process_code' => 'VAC-001',
            'description' => 'Proceso para solicitar período vacacional',
            'category' => 'Recursos Humanos',
            'priority' => 'alta',
            'deadline_days' => 10,
            'department' => 'Recursos Humanos',
            'active' => true,
            'created_by' => $admin->users_id ?? null,
        ]);

        Step::create([
            'process_id' => $process2->process_id,
            'order' => 1,
            'tittle' => 'Solicitar vacaciones',
            'description' => 'El trabajador solicita sus vacaciones',
            'instructions' => 'Seleccione las fechas deseadas para su período vacacional (mínimo 15 días de anticipación)',
            'condition_type' => 'normal',
            'responsible' => 'Trabajador',
            'deadline_days' => 1,
            'priority' => 'alta',
            'send_notification' => true,
            'requires_documents' => false,
        ]);

        Step::create([
            'process_id' => $process2->process_id,
            'order' => 2,
            'tittle' => 'Aprobación del coordinador',
            'description' => 'El coordinador del área revisa y aprueba',
            'instructions' => 'Verificar que no haya conflictos de calendario y que el trabajador tenga días disponibles',
            'condition_type' => 'normal',
            'responsible' => 'Coordinador',
            'deadline_days' => 3,
            'priority' => 'alta',
            'send_notification' => true,
            'requires_documents' => false,
        ]);

        Step::create([
            'process_id' => $process2->process_id,
            'order' => 3,
            'tittle' => 'Autorización final',
            'description' => 'Recursos Humanos autoriza las vacaciones',
            'instructions' => 'Registrar el período vacacional en el sistema y notificar al trabajador',
            'condition_type' => 'normal',
            'responsible' => 'Recursos Humanos',
            'deadline_days' => 2,
            'priority' => 'alta',
            'send_notification' => true,
            'requires_documents' => false,
        ]);

        // ============================================
        // PROCESO 3: Reporte de Mantenimiento
        // ============================================
        $process3 = Process::create([
            'name' => 'Reporte de Mantenimiento',
            'process_code' => 'MANT-REP-001',
            'description' => 'Reportar problemas de infraestructura o equipo que requieran mantenimiento',
            'category' => 'Mantenimiento',
            'priority' => 'media',
            'deadline_days' => 7,
            'department' => 'Mantenimiento',
            'active' => true,
            'created_by' => $admin->users_id ?? null,
        ]);

        Step::create([
            'process_id' => $process3->process_id,
            'order' => 1,
            'tittle' => 'Crear reporte',
            'description' => 'Describir el problema de mantenimiento',
            'instructions' => 'Detalle el problema, ubicación y urgencia. Adjunte fotos si es posible',
            'condition_type' => 'normal',
            'responsible' => 'Trabajador',
            'deadline_days' => 1,
            'priority' => 'media',
            'send_notification' => true,
            'requires_documents' => true,
        ]);

        Step::create([
            'process_id' => $process3->process_id,
            'order' => 2,
            'tittle' => 'Evaluación técnica',
            'description' => 'Mantenimiento evalúa el reporte',
            'instructions' => 'Evaluar la gravedad y determinar prioridad de atención',
            'condition_type' => 'normal',
            'responsible' => 'Jefe de Mantenimiento',
            'deadline_days' => 2,
            'priority' => 'alta',
            'send_notification' => true,
            'requires_documents' => false,
        ]);

        Step::create([
            'process_id' => $process3->process_id,
            'order' => 3,
            'tittle' => 'Ejecución de mantenimiento',
            'description' => 'Se realiza el trabajo de mantenimiento',
            'instructions' => 'Realizar el mantenimiento correctivo o preventivo según sea el caso',
            'condition_type' => 'normal',
            'responsible' => 'Personal de Mantenimiento',
            'deadline_days' => 4,
            'priority' => 'media',
            'send_notification' => true,
            'requires_documents' => false,
        ]);

        // ============================================
        // PROCESO 4: Cambio de Horario (Condicional)
        // ============================================
        $process4 = Process::create([
            'name' => 'Solicitud de Cambio de Horario',
            'process_code' => 'HORARIO-001',
            'description' => 'Proceso para solicitar modificación de horario laboral',
            'category' => 'Recursos Humanos',
            'priority' => 'baja',
            'deadline_days' => 15,
            'department' => 'Recursos Humanos',
            'active' => true,
            'created_by' => $admin->users_id ?? null,
        ]);

        $step4_1 = Step::create([
            'process_id' => $process4->process_id,
            'order' => 1,
            'tittle' => 'Solicitud de cambio',
            'description' => 'El trabajador solicita el cambio de horario',
            'instructions' => 'Indique su horario actual, horario deseado y justificación',
            'condition_type' => 'normal',
            'responsible' => 'Trabajador',
            'deadline_days' => 1,
            'priority' => 'baja',
            'send_notification' => true,
            'requires_documents' => true,
        ]);

        $step4_2 = Step::create([
            'process_id' => $process4->process_id,
            'order' => 2,
            'tittle' => '¿Es por motivos médicos?',
            'description' => 'Determinar si el cambio es por razones médicas',
            'instructions' => 'Revisar la documentación médica adjunta',
            'condition_type' => 'conditional',
            'responsible' => 'Recursos Humanos',
            'deadline_days' => 3,
            'priority' => 'media',
            'send_notification' => true,
            'requires_documents' => false,
        ]);

        $step4_3_yes = Step::create([
            'process_id' => $process4->process_id,
            'order' => 3,
            'tittle' => 'Aprobación inmediata',
            'description' => 'Se aprueba el cambio por motivos médicos',
            'instructions' => 'Aprobar el cambio y notificar al coordinador del área',
            'condition_type' => 'normal',
            'responsible' => 'Recursos Humanos',
            'deadline_days' => 2,
            'priority' => 'alta',
            'send_notification' => true,
            'requires_documents' => false,
        ]);

        $step4_3_no = Step::create([
            'process_id' => $process4->process_id,
            'order' => 4,
            'tittle' => 'Evaluación del coordinador',
            'description' => 'El coordinador evalúa la solicitud',
            'instructions' => 'Evaluar si el cambio es viable sin afectar operaciones',
            'condition_type' => 'normal',
            'responsible' => 'Coordinador',
            'deadline_days' => 5,
            'priority' => 'media',
            'send_notification' => true,
            'requires_documents' => false,
        ]);

        // Configurar flujo condicional
        $step4_2->update([
            'next_yes' => $step4_3_yes->step_id,
            'next_no' => $step4_3_no->step_id,
        ]);

        $this->command->info('✅ Procesos creados: 4');
        $this->command->info('   - Constancia Laboral (3 pasos)');
        $this->command->info('   - Solicitud de Vacaciones (3 pasos)');
        $this->command->info('   - Reporte de Mantenimiento (3 pasos)');
        $this->command->info('   - Cambio de Horario (4 pasos, con condicional)');
    }
}
