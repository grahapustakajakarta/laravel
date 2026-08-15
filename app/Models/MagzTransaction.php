<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MagzTransaction extends Model
{
    protected $table = 'magz_transactions';
    protected $fillable = ['pengguna_id', 'magz_id', 'order_id', 'gross_amount', 'status'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function magz()
    {
        return $this->belongsTo(Magz::class, 'magz_id');
    }
}
