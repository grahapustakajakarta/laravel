<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartTransaction extends Model
{
    protected $table = 'cart_transactions';
    protected $guarded = ['id'];
    protected $casts = [
        'items' => 'array',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
