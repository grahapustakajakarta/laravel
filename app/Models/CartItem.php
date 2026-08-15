<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_items';
    protected $guarded = ['id'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function getItemAttribute()
    {
        if ($this->item_type === 'magz') {
            return Magz::find($this->item_id);
        } elseif ($this->item_type === 'pustaka') {
            return Pustaka::find($this->item_id);
        }
        return null;
    }

    public function getHargaAttribute()
    {
        $item = $this->item;
        if (!$item) return 0;
        return (float) preg_replace('/[^0-9]/', '', $item->harga ?? '0');
    }

    public function getJudulAttribute()
    {
        $item = $this->item;
        if (!$item) return 'Item tidak ditemukan';
        return $item->judul ?? $item->title ?? '-';
    }

    public function getCoverAttribute()
    {
        $item = $this->item;
        if (!$item) return null;
        if ($this->item_type === 'magz') {
            return $item->cover ?? null;
        }
        return $item->gambar_1 ?? null;
    }

    public function getSlugAttribute()
    {
        $item = $this->item;
        return $item?->slug ?? null;
    }
}
