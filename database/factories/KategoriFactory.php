<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Kategori;

class KategoriFactory extends Factory
{
    protected $model = Kategori::class;

    public function definition(): array
    {
        $nama = fake('id_ID')->unique()->words(2, true);
        return [
            'nama' => ucwords($nama),
            'slug' => Str::slug($nama),
        ];
    }
}
