<?php
/**
 * Company: CETAM
 * Project: ST
 * File: PositionFactory.php
 * Created on: 14/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace Database\Factories;

use App\Models\Position;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

class PositionFactory extends Factory
{
    protected $model = Position::class;

    public function definition(): array
    {
        return [
            'worker_id' => Worker::factory(),
            'clave_presupuestal' => 'CLAVE-' . strtoupper($this->faker->bothify('####-??')),
            'plaza' => 'Plaza ' . $this->faker->citySuffix(),
            'puesto' => $this->faker->jobTitle(),
        ];
    }
}
