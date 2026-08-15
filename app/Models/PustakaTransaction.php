<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PustakaTransaction extends Model
{
    protected $table = 'pustaka_transactions';
    protected $fillable = ['pengguna_id', 'pustaka_id', 'order_id', 'gross_amount', 'status'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function pustaka()
    {
        return $this->belongsTo(Pustaka::class, 'pustaka_id');
    }
}
