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

    // Optional: You can register this component with a generic prefix
    // For use as <x-proj-layouts.base>. Replace 'proj' with the actual project code.
    // See: AppServiceProvider::boot() -> Blade::component('proj-layouts-base', Base::class)

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
