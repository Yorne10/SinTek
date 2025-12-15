<?php
/**
 * Company: CETAM
 * Project: ST
 * File: UserFactory.php
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

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Generate a CURP-like string (not exact spec, but unique and consistent length)
        $curp = strtoupper($this->faker->bothify('????######?###??'));

        // Generate 1-3 presupuesto keys as a comma separated list
        $keys = collect(range(1, $this->faker->numberBetween(1, 3)))
            ->map(fn($i) => 'CLAVE-' . strtoupper($this->faker->bothify('####-??')))
            ->implode(', ');

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'gender' => Arr::random(['M', 'F']),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'approved_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // "password"
            'role' => Arr::random(['worker', 'worker', 'worker', 'secretary']),
            'curp' => $curp,
            'budget_keys' => $keys,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'ZIP' => (string) $this->faker->numberBetween(10000, 99999),
            'number' => $this->faker->buildingNumber,
            'remember_token' => Str::random(32),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
