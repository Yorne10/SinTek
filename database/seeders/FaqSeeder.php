<?php
/**
 * Company: CETAM
 * Project: ST
 * File: FaqSeeder.php
 * Created on: 24/11/2025
 * Created by: Claude Code
 * Approved by: Alfonso Angel García Hernández
 *
 * Description: Seed FAQ categories and FAQs
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FaqCategory;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ============================================
        // CATEGORÍAS
        // ============================================
        $cat1 = FaqCategory::create([
            'name' => 'Trámites generales',
            'description' => 'Preguntas sobre trámites y procesos administrativos',
            'order' => 1,
        ]);

        $cat2 = FaqCategory::create([
            'name' => 'Mi cuenta',
            'description' => 'Gestión de cuenta y perfil de usuario',
            'order' => 2,
        ]);

        $cat3 = FaqCategory::create([
            'name' => 'Convocatorias',
            'description' => 'Información sobre convocatorias y plazas',
            'order' => 3,
        ]);

        $cat4 = FaqCategory::create([
            'name' => 'Documentación',
            'description' => 'Preguntas sobre documentos y constancias',
            'order' => 4,
        ]);

        // ============================================
        // FAQs - Trámites generales
        // ============================================
        Faq::create([
            'faq_category_id' => $cat1->faq_category_id,
            'question' => '¿Cómo inicio un nuevo trámite?',
            'answer' => 'Para iniciar un nuevo trámite, ve a la sección "Trámites disponibles" en el menú principal, selecciona el trámite que necesitas y sigue los pasos indicados. El sistema te guiará en cada etapa del proceso.',
            'order' => 1,
        ]);

        Faq::create([
            'faq_category_id' => $cat1->faq_category_id,
            'question' => '¿Cuánto tiempo tarda mi trámite?',
            'answer' => 'El tiempo de procesamiento varía según el tipo de trámite. Cada trámite muestra su tiempo estimado de resolución. Puedes consultar el estado de tus trámites en la sección "Mis trámites".',
            'order' => 2,
        ]);

        Faq::create([
            'faq_category_id' => $cat1->faq_category_id,
            'question' => '¿Puedo cancelar un trámite en proceso?',
            'answer' => 'Sí, puedes cancelar un trámite que esté en proceso. Ve a "Mis trámites", selecciona el trámite que deseas cancelar y presiona el botón "Cancelar". Ten en cuenta que algunos trámites no pueden cancelarse una vez que han sido revisados por el administrador.',
            'order' => 3,
        ]);

        Faq::create([
            'faq_category_id' => $cat1->faq_category_id,
            'question' => '¿Cómo sé en qué paso está mi trámite?',
            'answer' => 'En la sección "Mis trámites" encontrarás una barra de progreso que muestra el estado actual de cada uno de tus trámites. También recibirás notificaciones cuando tu trámite avance al siguiente paso.',
            'order' => 4,
        ]);

        // ============================================
        // FAQs - Mi cuenta
        // ============================================
        Faq::create([
            'faq_category_id' => $cat2->faq_category_id,
            'question' => '¿Cómo actualizo mi información de perfil?',
            'answer' => 'Ve a "Mi perfil" en el menú, ahí podrás editar tu información personal como teléfono, dirección, etc. Recuerda guardar los cambios antes de salir.',
            'order' => 1,
        ]);

        Faq::create([
            'faq_category_id' => $cat2->faq_category_id,
            'question' => '¿Cómo cambio mi contraseña?',
            'answer' => 'En la sección "Mi perfil", encontrarás la opción "Cambiar contraseña". Necesitarás ingresar tu contraseña actual y la nueva contraseña dos veces para confirmar.',
            'order' => 2,
        ]);

        Faq::create([
            'faq_category_id' => $cat2->faq_category_id,
            'question' => '¿Puedo cambiar mi foto de perfil?',
            'answer' => 'Sí, en tu perfil encontrarás la opción para actualizar tu foto. La imagen debe ser en formato JPG, PNG o GIF. La foto se mostrará en tu perfil y en tus trámites.',
            'order' => 3,
        ]);

        // ============================================
        // FAQs - Convocatorias
        // ============================================
        Faq::create([
            'faq_category_id' => $cat3->faq_category_id,
            'question' => '¿Dónde veo las convocatorias disponibles?',
            'answer' => 'En la sección "Convocatorias" del menú principal encontrarás todas las convocatorias activas, próximas y permanentes. Puedes ver los detalles y documentos de cada convocatoria.',
            'order' => 1,
        ]);

        Faq::create([
            'faq_category_id' => $cat3->faq_category_id,
            'question' => '¿Qué significa el estado "Próxima" en una convocatoria?',
            'answer' => 'Una convocatoria con estado "Próxima" indica que será publicada oficialmente en las fechas indicadas. Puedes guardarla para recibir notificaciones cuando esté activa.',
            'order' => 2,
        ]);

        Faq::create([
            'faq_category_id' => $cat3->faq_category_id,
            'question' => '¿Cómo descargo los documentos de una convocatoria?',
            'answer' => 'Dentro de cada convocatoria encontrarás una lista de documentos disponibles. Haz clic en el nombre del documento para descargarlo. Los documentos suelen estar en formato PDF.',
            'order' => 3,
        ]);

        // ============================================
        // FAQs - Documentación
        // ============================================
        Faq::create([
            'faq_category_id' => $cat4->faq_category_id,
            'question' => '¿Cómo solicito una constancia laboral?',
            'answer' => 'Ve a "Trámites disponibles" y selecciona "Solicitud de Constancia Laboral". Llena el formulario con tus datos y especifica el tipo de constancia que necesitas. El proceso tarda aproximadamente 5 días hábiles.',
            'order' => 1,
        ]);

        Faq::create([
            'faq_category_id' => $cat4->faq_category_id,
            'question' => '¿Qué documentos necesito subir para mi trámite?',
            'answer' => 'Los documentos requeridos varían según el trámite. Al iniciar un trámite, el sistema te indicará específicamente qué documentos debes adjuntar. Asegúrate de que sean legibles y en formato PDF o imagen.',
            'order' => 2,
        ]);

        Faq::create([
            'faq_category_id' => $cat4->faq_category_id,
            'question' => '¿Puedo descargar mis documentos después de subirlos?',
            'answer' => 'Sí, todos los documentos que subas quedan guardados en tu historial de trámites. Puedes acceder a ellos en cualquier momento desde la sección "Mis trámites".',
            'order' => 3,
        ]);

        $this->command->info('✅ Categorías de FAQs creadas: 4');
        $this->command->info('✅ FAQs creadas: 13');
        $this->command->info('   - Trámites generales: 4');
        $this->command->info('   - Mi cuenta: 3');
        $this->command->info('   - Convocatorias: 3');
        $this->command->info('   - Documentación: 3');
    }
}
