<?php

namespace App\Traits;

use App\Models\LogAktivitas;

trait LogsActivity
{
    protected function logActivity(string $aksi, string $modul): void
    {
        if (auth()->check()) {
            LogAktivitas::create([
                'pengguna_id' => auth()->id(),
                'aksi'        => $aksi,
                'modul'       => $modul,
                'ip_address'  => request()->ip(),
            ]);
        }
    }
}
