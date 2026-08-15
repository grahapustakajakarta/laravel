<?php
/**
 * Script untuk menambahkan kategori Prosa ke database.
 * Akses via browser: https://galeribukujakarta.com/seed_prosa.php
 * Setelah berhasil, HAPUS file ini dari server!
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $existing = \App\Models\Kategori::where('nama', 'Prosa')
                    ->orWhere('slug', 'prosa')
                    ->first();

    if ($existing) {
        echo "<p style='color:orange;font-family:sans-serif;font-size:16px;'>"
           . "<b>✓ Kategori Prosa sudah ada (ID: {$existing->id}, slug: {$existing->slug})</b></p>";
    } else {
        $prosa = \App\Models\Kategori::create([
            'nama' => 'Prosa',
            'slug' => 'prosa',
        ]);
        echo "<p style='color:green;font-family:sans-serif;font-size:16px;'>"
           . "<b>✅ Kategori Prosa berhasil ditambahkan! ID: {$prosa->id}</b></p>";
    }

    echo "<hr><p style='font-family:sans-serif;color:red;font-size:14px;'>"
       . "<b>⚠️ Jangan lupa hapus file ini dari server setelah selesai!</b></p>";

} catch (\Exception $e) {
    echo "<p style='color:red;font-family:sans-serif;'><b>Error: " . htmlspecialchars($e->getMessage()) . "</b></p>";
}
