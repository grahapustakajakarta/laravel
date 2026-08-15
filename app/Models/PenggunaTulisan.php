<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenggunaTulisan extends Model
{
    protected $table = 'pengguna_tulisan';
    protected $guarded = ['id'];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'artikel_id');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Accessor terpadu untuk mendapatkan gambar utama.
     * Membaca dari gambar_array[0] dengan fallback ke kolom gambar lama.
     * Ini menyelesaikan redundansi 1NF antara kolom 'gambar' dan 'gambar_array'.
     */
    public function getGambarUtamaAttribute(): ?string
    {
        $arr = is_string($this->gambar_array) ? json_decode($this->gambar_array, true) : $this->gambar_array;
        
        if (!empty($arr) && is_array($arr)) {
            $first = reset($arr);
            return is_array($first) ? ($first['file_gambar'] ?? null) : $first;
        }
        return $this->gambar ?? null;
    }
}
