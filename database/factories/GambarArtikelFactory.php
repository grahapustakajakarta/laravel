<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\GambarArtikel;
use App\Models\Artikel;

class GambarArtikelFactory extends Factory
{
    protected $model = GambarArtikel::class;

    public function definition(): array
    {
        return [
            'artikel_id' => Artikel::factory(),
            // Using a dummy placeholder since the actual assets are in public/img
            'file_gambar' => 'default.jpg', 
            'deskripsi' => fake('id_ID')->sentence(),
            'urutan' => 0,
        ];
    }
}
