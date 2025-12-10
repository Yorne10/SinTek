<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class Settings extends Component
{
    public $maintenanceMode = false;

    // Información general
    public $institution_name = '';
    public $system_name = '';
    public $contact_email = '';
    public $contact_phone = '';

    // Seguridad
    public $session_timeout = 120;

    protected $rules = [
        'institution_name' => 'required|string|max:255',
        'system_name' => 'required|string|max:255',
        'contact_email' => 'required|email|max:255',
        'contact_phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9\\-\\(\\)\\s]+$/'],
        'session_timeout' => 'required|integer|min:1|max:1440',
    ];

    protected $messages = [
        'institution_name.required' => 'El campo nombre de la institución es obligatorio',
        'institution_name.max' => 'El nombre de la institución no debe exceder los 255 caracteres',
        'system_name.required' => 'El campo nombre del sistema es obligatorio',
        'system_name.max' => 'El nombre del sistema no debe exceder los 255 caracteres',
        'contact_email.required' => 'El campo correo de contacto es obligatorio',
        'contact_email.email' => 'El correo de contacto debe ser válido',
        'contact_email.max' => 'El correo de contacto no debe exceder los 255 caracteres',
        'contact_phone.max' => 'El telefono de contacto no debe exceder los 20 caracteres',
        'contact_phone.regex' => 'El telefono de contacto solo puede incluir numeros, guiones y parentesis',
        'session_timeout.required' => 'El campo tiempo de sesión es obligatorio',
        'session_timeout.min' => 'El tiempo de sesión debe ser mayor que 0',
        'session_timeout.max' => 'El tiempo de sesión debe ser menor o igual que 1440',
    ];

    public function mount()
    {
        // Verificar si el modo mantenimiento está activo
        $this->maintenanceMode = app()->isDownForMaintenance();

        // Cargar valores de configuración desde la base de datos
        $this->institution_name = \App\Models\SystemSetting::getValue('institution_name', config('app.institution_name', 'CETAM'));
        $this->system_name = \App\Models\SystemSetting::getValue('system_name', config('app.name', 'SinTek'));
        $this->contact_email = \App\Models\SystemSetting::getValue('contact_email', config('mail.from.address', 'contacto@cetam.gob.mx'));
        $this->contact_phone = \App\Models\SystemSetting::getValue('contact_phone', config('app.contact_phone', '(999) 999-9999'));
        $this->session_timeout = (int) \App\Models\SystemSetting::getValue('session_timeout', config('session.lifetime', 120));
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
            \App\Models\SystemSetting::setValue('institution_name', $this->institution_name);
            \App\Models\SystemSetting::setValue('system_name', $this->system_name);
            \App\Models\SystemSetting::setValue('contact_email', $this->contact_email);
            \App\Models\SystemSetting::setValue('contact_phone', $this->contact_phone);

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
        ]);

        try {
            \App\Models\SystemSetting::setValue('session_timeout', $this->session_timeout);

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

    public function render()
    {
        return view('modules.admin.settings')->layout('layouts.app');
    }
}

