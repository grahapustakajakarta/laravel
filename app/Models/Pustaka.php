<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Pustaka extends Model
{
    protected $table = 'pustaka';

    protected $fillable = [
        'judul', 'slug', 'tipe_buku', 'kategori', 'penulis_id', 'penulis_manual', 'status', 'is_on_tour', 'harga',
        'penerbit', 'isbn', 'bahasa', 'tanggal_terbit', 'halaman', 'format_buku', 'ukuran', 'berat',
        'deskripsi', 'ulasan', 'tentang_pengarang',
        'link_vidio_produk', 'link_read_sample',
        'link_tokopedia', 'link_shopee', 'link_instagram', 'link_tiktok', 
        'link_coffeesophia', 'link_togamas', 'link_ebook', 'link_lainnya', 'nomor_wa',
        'gambar_1', 'gambar_2', 'gambar_3', 'file_pdf', 'file_pdf_preview'
    ];

    public function penulis()
    {
        return $this->belongsTo(Penulis::class, 'penulis_id')->withDefault([
            'nama' => $this->penulis_manual ?? 'Editorial Team',
        ]);
    }

    protected static function boot()
    {
        parent::boot();

        if (!request()->is('admin/*')) {
            static::addGlobalScope('published', function (Builder $builder) {
                $builder->where('status', 'publish');
            });
        }
    }

    public static function generateSlug(string $judul): string
    {
        $slug = Str::slug($judul);
        $count = static::where('slug', 'like', $slug . '%')->count();
        return $count > 0 ? $slug . '-' . ($count + 1) : $slug;
    }
}
