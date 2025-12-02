<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Load helpers
        require_once app_path('helpers.php');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register @icon Blade directive
        Blade::directive('icon', function ($expression) {
            return "<?php echo '<i class=\"' . icon({$expression}) . '\"></i>'; ?>";
        });

        // Load system settings from database
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('system_settings')) {
                $settings = \App\Models\SystemSetting::all();

                foreach ($settings as $setting) {
                    switch ($setting->key) {
                        case 'institution_name':
                            config(['app.institution_name' => $setting->value]);
                            break;
                        case 'system_name':
                            config(['app.name' => $setting->value]);
                            break;
                        case 'contact_email':
                            config(['mail.from.address' => $setting->value]);
                            config(['app.contact_email' => $setting->value]);
                            break;
                        case 'contact_phone':
                            config(['app.contact_phone' => $setting->value]);
                            break;
                        case 'session_timeout':
                            config(['session.lifetime' => (int) $setting->value]);
                            break;
                    }
                }
            }
        } catch (\Exception $e) {
            // Log error or ignore if DB connection fails (e.g. during migration)
        }

        // Opcional: Prefijo genérico para componentes Blade
        // Descomenta y ajusta el prefijo 'proj' por el código real del proyecto.
        // Blade::component('proj-layouts-base', \App\View\Components\Layouts\Base::class);
        // Ahora invocable como: <x-proj-layouts-base>
    }
}
