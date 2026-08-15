<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengguna_id',
        'type',
        'artikel_id',
        'status',
        'alasan',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'artikel_id');
    }
}
