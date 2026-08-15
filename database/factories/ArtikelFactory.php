<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Penulis;

class ArtikelFactory extends Factory
{
    protected $model = Artikel::class;

    public function definition(): array
    {
        $judul = fake('id_ID')->sentence(6);
        return [
            'kategori_id' => Kategori::factory(),
            'penulis_id' => Penulis::factory(),
            'judul' => rtrim($judul, '.'),
            'slug' => Str::slug($judul),
            'sinopsis' => fake('id_ID')->paragraph(),
            'konten' => '<p>' . implode('</p><p>', fake('id_ID')->paragraphs(5)) . '</p>',
            'tanggal_publikasi' => fake()->dateTimeBetween('-1 year', 'now'),
            'sponsor' => fake()->optional(0.2)->company(),
            'jumlah_tayang' => fake()->numberBetween(0, 1000),
        ];
    }
}
