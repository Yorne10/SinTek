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

        // Opcional: Prefijo genérico para componentes Blade
        // Descomenta y ajusta el prefijo 'proj' por el código real del proyecto.
        // Blade::component('proj-layouts-base', \App\View\Components\Layouts\Base::class);
        // Ahora invocable como: <x-proj-layouts-base>
    }
}
