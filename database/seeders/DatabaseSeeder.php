<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use App\Models\Kategori;
use App\Models\Penulis;
use App\Models\Artikel;
use App\Models\GambarArtikel;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Super Admin Utama
        Pengguna::create([
            'nama'     => 'Administrator',
            'email'    => 'admin@galeribukujakarta.com',
            'password' => bcrypt('password123'),
            'role'     => 'superadmin',
        ]);

        // 2. Buat Kategori Asli sesuai versi lama
        $kategoriLama = [
            'Buku',
            'Puisi',
            'Fiksi',
            'Gairah',
            'Pemikiran',
            'Coffeeshophia',
            'Writing Tips',
            'Inspirasi',
            'Jakarta+',
            'Editor Choice',
            'The Brief'
        ];

        $kategoriMap = [];
        foreach ($kategoriLama as $kat) {
            $kategoriMap[$kat] = Kategori::create([
                'nama' => $kat,
                'slug' => Str::slug($kat)
            ]);
        }

        // 3. Buat 10 Penulis Dummy
        $penulis = Penulis::factory()->count(10)->create();

        // 4. Generate Artikel untuk masing-masing Kategori
        $templates = ['g7.jpg', 'g8.jpg', 'jakarta.jpg', 'paris.jpg', 'shabiq.png', 'tulisan.png'];
        
        foreach ($kategoriMap as $kategori) {
            // Buat 10 artikel per kategori
            for ($i = 0; $i < 10; $i++) {
                $artikel = Artikel::factory()->create([
                    'kategori_id' => $kategori->id,
                    'penulis_id' => $penulis->random()->id,
                ]);

                // Beri 1-3 gambar per artikel
                $jumlahGambar = rand(1, 3);
                for ($j = 0; $j < $jumlahGambar; $j++) {
                    $templateName = $templates[array_rand($templates)];
                    $templatePath = public_path('img/' . $templateName);
                    
                    $newFileName = null;
                    if (file_exists($templatePath)) {
                        $extension = pathinfo($templatePath, PATHINFO_EXTENSION);
                        // Buat nama unik agar saat di-unlink di admin, template asli tidak hilang
                        $newFileName = 'seed_' . time() . '_' . Str::random(8) . '.' . $extension;
                        copy($templatePath, public_path('img/' . $newFileName));
                    }

                    if ($newFileName) {
                        GambarArtikel::create([
                            'artikel_id' => $artikel->id,
                            'file_gambar' => $newFileName,
                            'deskripsi' => fake('id_ID')->sentence(),
                            'urutan' => $j
                        ]);
                    }
                }
            }
        }
    }
}
