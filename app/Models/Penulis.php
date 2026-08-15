<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penulis extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penulis';

    protected $fillable = ['nama', 'biografi', 'foto_profil'];

    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'penulis_id', 'id');
    }
}
