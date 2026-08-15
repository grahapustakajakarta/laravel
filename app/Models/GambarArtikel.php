<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarArtikel extends Model
{
    use HasFactory;

    protected $table = 'gambar_artikel';

    protected $fillable = ['artikel_id', 'file_gambar', 'deskripsi', 'urutan'];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'artikel_id', 'id');
    }
}
