<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Penulis;

class PenulisFactory extends Factory
{
    protected $model = Penulis::class;

    public function definition(): array
    {
        return [
            'nama' => fake('id_ID')->name(),
            'biografi' => fake('id_ID')->paragraph(),
        ];
    }
}
