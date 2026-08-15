<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\MagzTransaction;
use App\Models\PustakaTransaction;
use App\Models\PenggunaKoleksi;

$magzTxs = MagzTransaction::where('status', 'success')->get();
$migratedMagz = 0;
foreach ($magzTxs as $tx) {
    PenggunaKoleksi::firstOrCreate([
        'pengguna_id' => $tx->pengguna_id,
        'item_type'   => 'magz',
        'item_id'     => $tx->magz_id,
    ]);
    $migratedMagz++;
}

$pTxs = PustakaTransaction::where('status', 'success')->get();
$migratedPustaka = 0;
foreach ($pTxs as $tx) {
    PenggunaKoleksi::firstOrCreate([
        'pengguna_id' => $tx->pengguna_id,
        'item_type'   => 'pustaka',
        'item_id'     => $tx->pustaka_id,
    ]);
    $migratedPustaka++;
}

echo "Selesai: {$migratedMagz} magz, {$migratedPustaka} pustaka berhasil dipindahkan ke koleksi.\n";
