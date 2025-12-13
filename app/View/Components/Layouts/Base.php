<?php
/**
 * Company: CETAM
 * Project: ST
 * File: Base.php
 * Created on: 02/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Base extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // Opcional: Puedes registrar este componente con un prefijo genérico
    // para su uso como <x-proj-layouts.base>. Sustituir 'proj' por el código real del proyecto.
    // Ver: AppServiceProvider::boot() -> Blade::component('proj-layouts-base', Base::class)

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('layouts.base');
    }
}
