<?php

namespace Database\Factories;

use App\Models\Servicio;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServicioFactory extends Factory
{
    protected $model = Servicio::class;

    public function definition()
    {
        return [
            'nombre'      => $this->faker->unique()->words(2, true),
            'descripcion' => $this->faker->sentence,
        ];
    }
}
