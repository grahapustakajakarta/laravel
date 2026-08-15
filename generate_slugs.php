<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$artikels = App\Models\Artikel::all();
foreach ($artikels as $artikel) {
    if (empty($artikel->slug)) {
        $artikel->slug = Illuminate\Support\Str::slug($artikel->judul);
        $artikel->save();
        echo "Generated slug for: " . $artikel->judul . "\n";
    }
}
echo "Done.\n";
