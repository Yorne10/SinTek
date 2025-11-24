<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class Configuracion extends Component
{
    public $maintenanceMode = false;

    // Información general
    public $institution_name = '';
    public $system_name = '';
    public $contact_email = '';
    public $contact_phone = '';

    // Seguridad
    public $session_timeout = 120;
    public $max_attempts = 5;

    protected $rules = [
        'institution_name' => 'required|string|max:255',
        'system_name' => 'required|string|max:255',
        'contact_email' => 'required|email|max:255',
        'contact_phone' => 'nullable|string|max:20',
        'session_timeout' => 'required|integer|min:5|max:1440',
        'max_attempts' => 'required|integer|min:1|max:10',
    ];

    protected $messages = [
        'institution_name.required' => 'El nombre de la institución es obligatorio.',
        'system_name.required' => 'El nombre del sistema es obligatorio.',
        'contact_email.required' => 'El correo de contacto es obligatorio.',
        'contact_email.email' => 'El correo debe ser válido.',
        'session_timeout.required' => 'El tiempo de sesión es obligatorio.',
        'session_timeout.min' => 'El tiempo de sesión debe ser al menos 5 minutos.',
        'session_timeout.max' => 'El tiempo de sesión no puede exceder 1440 minutos (24 horas).',
        'max_attempts.required' => 'Los intentos máximos son obligatorios.',
        'max_attempts.min' => 'Debe permitir al menos 1 intento.',
        'max_attempts.max' => 'No se pueden configurar más de 10 intentos.',
    ];

    public function mount()
    {
        // Verificar si el modo mantenimiento está activo
        $this->maintenanceMode = app()->isDownForMaintenance();

        // Cargar valores de configuración
        $this->institution_name = config('app.institution_name', 'CETAM');
        $this->system_name = config('app.name', 'SinTek');
        $this->contact_email = config('app.contact_email', 'contacto@cetam.gob.mx');
        $this->contact_phone = config('app.contact_phone', '(999) 999-9999');
        $this->session_timeout = config('session.lifetime', 120);
        $this->max_attempts = config('auth.max_attempts', 5);
    }

    public function saveGeneralInfo()
    {
        $this->validate([
            'institution_name' => $this->rules['institution_name'],
            'system_name' => $this->rules['system_name'],
            'contact_email' => $this->rules['contact_email'],
            'contact_phone' => $this->rules['contact_phone'],
        ]);

        try {
            $this->updateEnvFile([
                'APP_INSTITUTION_NAME' => $this->institution_name,
                'APP_NAME' => $this->system_name,
                'APP_CONTACT_EMAIL' => $this->contact_email,
                'APP_CONTACT_PHONE' => $this->contact_phone,
            ]);

            $this->dispatch(
                'config-notify',
                type: 'success',
                title: '¡Información actualizada!',
                message: 'La información general ha sido guardada correctamente.'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'config-notify',
                type: 'error',
                title: 'Error al guardar',
                message: 'No se pudo guardar la información: ' . $e->getMessage()
            );
        }
    }

    public function saveSecurityConfig()
    {
        $this->validate([
            'session_timeout' => $this->rules['session_timeout'],
            'max_attempts' => $this->rules['max_attempts'],
        ]);

        try {
            $this->updateEnvFile([
                'SESSION_LIFETIME' => $this->session_timeout,
                'AUTH_MAX_ATTEMPTS' => $this->max_attempts,
            ]);

            $this->dispatch(
                'config-notify',
                type: 'success',
                title: '¡Configuración actualizada!',
                message: 'La configuración de seguridad ha sido guardada correctamente.'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'config-notify',
                type: 'error',
                title: 'Error al guardar',
                message: 'No se pudo guardar la configuración: ' . $e->getMessage()
            );
        }
    }

    public function toggleMaintenanceMode()
    {
        try {
            if ($this->maintenanceMode) {
                // Activar modo mantenimiento
                Artisan::call('down', [
                    '--render' => 'errors::503',
                    '--secret' => config('app.key')
                ]);

                $this->dispatch(
                    'config-notify',
                    type: 'warning',
                    title: 'Modo mantenimiento activado',
                    message: 'El sistema está ahora en modo mantenimiento. Los usuarios no podrán acceder.'
                );
            } else {
                // Desactivar modo mantenimiento
                Artisan::call('up');

                $this->dispatch(
                    'config-notify',
                    type: 'success',
                    title: 'Modo mantenimiento desactivado',
                    message: 'El sistema está nuevamente disponible para todos los usuarios.'
                );
            }
        } catch (\Exception $e) {
            $this->maintenanceMode = !$this->maintenanceMode;

            $this->dispatch(
                'config-notify',
                type: 'error',
                title: 'Error',
                message: 'No se pudo cambiar el modo mantenimiento: ' . $e->getMessage()
            );
        }
    }

    private function updateEnvFile(array $data)
    {
        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            throw new \Exception('El archivo .env no existe');
        }

        $envContent = File::get($envPath);

        foreach ($data as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}=\"{$value}\"";

            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                $envContent .= "\n{$replacement}";
            }
        }

        File::put($envPath, $envContent);

        // Limpiar cache de configuración
        Artisan::call('config:clear');
    }

    public function render()
    {
        return view('livewire.admin.configuracion')->layout('layouts.app');
    }
}
