<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ProcessSeeder.php
 * Created on: 11/12/2025
 * Created by: Claude Code
 * Approved by: Alfonso Angel García Hernández
 *
 * Description: Seed processes and steps
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Process;
use App\Models\Step;
use App\Models\StepRequiredDocument;
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
            'department' => 'Recursos Humanos',
            'active' => true,
            'created_by' => $admin->users_id ?? 1,
        ]);

        $step1_1 = Step::create([
            'process_id' => $process1->process_id,
            'title' => 'Llenar solicitud',
            'instruction' => 'Ingrese sus datos personales y especifique el tipo de constancia requerida',
            'step_type' => 'initial',
            'requires_documents' => false,
            'is_initial_step' => true,
            'active' => true,
        ]);

        $step1_2 = Step::create([
            'process_id' => $process1->process_id,
            'title' => 'Revisión de documentos',
            'instruction' => 'Verificar que los datos sean correctos y que el trabajador esté activo',
            'step_type' => 'initial',
            'requires_documents' => false,
            'active' => true,
        ]);

        $step1_3 = Step::create([
            'process_id' => $process1->process_id,
            'title' => 'Emisión de constancia',
            'instruction' => 'Generar el documento oficial con sello y firma autorizada',
            'step_type' => 'final',
            'requires_documents' => false,
            'finalization_message' => 'Su constancia laboral ha sido generada exitosamente. Puede descargarla desde la sección de documentos.',
            'active' => true,
        ]);

        // Configurar flujo lineal
        $step1_1->update(['next_step_id' => $step1_2->step_id]);
        $step1_2->update(['next_step_id' => $step1_3->step_id]);

        // ============================================
        // PROCESO 2: Solicitud de Vacaciones
        // ============================================
        $process2 = Process::create([
            'name' => 'Solicitud de Vacaciones',
            'process_code' => 'VAC-001',
            'description' => 'Proceso para solicitar período vacacional',
            'category' => 'Recursos Humanos',
            'department' => 'Recursos Humanos',
            'active' => true,
            'created_by' => $admin->users_id ?? 1,
        ]);

        $step2_1 = Step::create([
            'process_id' => $process2->process_id,
            'title' => 'Solicitar vacaciones',
            'instruction' => 'Seleccione las fechas deseadas para su período vacacional (mínimo 15 días de anticipación)',
            'step_type' => 'initial',
            'requires_documents' => false,
            'is_initial_step' => true,
            'active' => true,
        ]);

        $step2_2 = Step::create([
            'process_id' => $process2->process_id,
            'title' => 'Aprobación del coordinador',
            'instruction' => 'Verificar que no haya conflictos de calendario y que el trabajador tenga días disponibles',
            'step_type' => 'initial',
            'requires_documents' => false,
            'active' => true,
        ]);

        $step2_3 = Step::create([
            'process_id' => $process2->process_id,
            'title' => 'Autorización final',
            'instruction' => 'Registrar el período vacacional en el sistema y notificar al trabajador',
            'step_type' => 'final',
            'requires_documents' => false,
            'finalization_message' => 'Su solicitud de vacaciones ha sido aprobada. Consulte su correo para más detalles.',
            'active' => true,
        ]);

        // Configurar flujo
        $step2_1->update(['next_step_id' => $step2_2->step_id]);
        $step2_2->update(['next_step_id' => $step2_3->step_id]);

        // ============================================
        // PROCESO 3: Reporte de Mantenimiento
        // ============================================
        $process3 = Process::create([
            'name' => 'Reporte de Mantenimiento',
            'process_code' => 'MANT-REP-001',
            'description' => 'Reportar problemas de infraestructura o equipo que requieran mantenimiento',
            'category' => 'Mantenimiento',
            'department' => 'Mantenimiento',
            'active' => true,
            'created_by' => $admin->users_id ?? 1,
        ]);

        $step3_1 = Step::create([
            'process_id' => $process3->process_id,
            'title' => 'Crear reporte',
            'instruction' => 'Detalle el problema, ubicación y urgencia. Adjunte fotos si es posible',
            'step_type' => 'initial',
            'requires_documents' => true,
            'is_initial_step' => true,
            'active' => true,
        ]);

        // Documentos requeridos
        StepRequiredDocument::create([
            'step_id' => $step3_1->step_id,
            'title' => 'Fotografía del problema'
        ]);

        StepRequiredDocument::create([
            'step_id' => $step3_1->step_id,
            'title' => 'Descripción detallada'
        ]);

        $step3_2 = Step::create([
            'process_id' => $process3->process_id,
            'title' => 'Evaluación técnica',
            'instruction' => 'Evaluar la gravedad y determinar prioridad de atención',
            'step_type' => 'initial',
            'requires_documents' => false,
            'active' => true,
        ]);

        $step3_3 = Step::create([
            'process_id' => $process3->process_id,
            'title' => 'Ejecución de mantenimiento',
            'instruction' => 'Realizar el mantenimiento correctivo o preventivo según sea el caso',
            'step_type' => 'final',
            'requires_documents' => false,
            'finalization_message' => 'El mantenimiento ha sido completado. Gracias por su reporte.',
            'active' => true,
        ]);

        // Configurar flujo
        $step3_1->update(['next_step_id' => $step3_2->step_id]);
        $step3_2->update(['next_step_id' => $step3_3->step_id]);

        // ============================================
        // PROCESO 4: Cambio de Horario (Condicional)
        // ============================================
        $process4 = Process::create([
            'name' => 'Solicitud de Cambio de Horario',
            'process_code' => 'HORARIO-001',
            'description' => 'Proceso para solicitar modificación de horario laboral',
            'category' => 'Recursos Humanos',
            'department' => 'Recursos Humanos',
            'active' => true,
            'created_by' => $admin->users_id ?? 1,
        ]);

        $step4_1 = Step::create([
            'process_id' => $process4->process_id,
            'title' => 'Solicitud de cambio',
            'instruction' => 'Indique su horario actual, horario deseado y justificación',
            'step_type' => 'initial',
            'requires_documents' => true,
            'is_initial_step' => true,
            'active' => true,
        ]);

        StepRequiredDocument::create([
            'step_id' => $step4_1->step_id,
            'title' => 'Justificación escrita'
        ]);

        StepRequiredDocument::create([
            'step_id' => $step4_1->step_id,
            'title' => 'Documentación médica (si aplica)'
        ]);

        $step4_2 = Step::create([
            'process_id' => $process4->process_id,
            'title' => '¿Es por motivos médicos?',
            'instruction' => 'Revisar la documentación médica adjunta',
            'step_type' => 'conditional',
            'condition_question' => '¿La solicitud está justificada por motivos médicos?',
            'requires_documents' => false,
            'active' => true,
        ]);

        $step4_3_yes = Step::create([
            'process_id' => $process4->process_id,
            'title' => 'Aprobación inmediata',
            'instruction' => 'Aprobar el cambio y notificar al coordinador del área',
            'step_type' => 'final',
            'requires_documents' => false,
            'finalization_message' => 'Su cambio de horario ha sido aprobado por motivos médicos.',
            'active' => true,
        ]);

        $step4_3_no = Step::create([
            'process_id' => $process4->process_id,
            'title' => 'Evaluación del coordinador',
            'instruction' => 'Evaluar si el cambio es viable sin afectar operaciones',
            'step_type' => 'final',
            'requires_documents' => false,
            'finalization_message' => 'Su solicitud de cambio de horario ha sido evaluada y procesada.',
            'active' => true,
        ]);

        // Configurar flujo condicional
        $step4_1->update(['next_step_id' => $step4_2->step_id]);
        $step4_2->update([
            'next_yes' => $step4_3_yes->step_id,
            'next_no' => $step4_3_no->step_id,
        ]);

        $this->command->info('✅ Procesos creados: 4');
        $this->command->info('   - Constancia Laboral (3 pasos lineales)');
        $this->command->info('   - Solicitud de Vacaciones (3 pasos lineales)');
        $this->command->info('   - Reporte de Mantenimiento (3 pasos + documentos)');
        $this->command->info('   - Cambio de Horario (4 pasos condicionales)');
    }
}
