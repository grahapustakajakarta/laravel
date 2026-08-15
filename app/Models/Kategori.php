<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kategori';

    protected $fillable = ['nama', 'slug'];

    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'kategori_id', 'id');
    }
}
