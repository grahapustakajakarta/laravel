<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenggunaSimpanArtikel extends Model
{
    protected $table = 'pengguna_simpan_artikel';
    protected $guarded = ['id'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'artikel_id');
    }
}
