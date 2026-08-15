<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenggunaKoleksi extends Model
{
    protected $table = 'pengguna_koleksi';
    protected $guarded = ['id'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function getKoleksiItemAttribute()
    {
        if ($this->item_type === 'magz') {
            return Magz::find($this->item_id);
        } elseif ($this->item_type === 'publikasi') {
            return Publikasi::find($this->item_id);
        } elseif ($this->item_type === 'pustaka') {
            return Pustaka::find($this->item_id);
        }
        return null;
    }
}
