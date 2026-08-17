<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Magz extends Model
{
    protected $table = 'magzs';

    protected $fillable = [
        'judul',
        'slug',
        'edisi',
        'kategori',
        'penulis',
        'status',
        'deskripsi',
        'cover_gambar',
        'file_pdf',
        'file_pdf_preview',
        'harga',
        'isi_preview',
        'table_of_contents',
    ];

    protected $casts = [
        'table_of_contents' => 'array',
    ];

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
        $slug = \Illuminate\Support\Str::slug($judul);
        $count = static::where('slug', 'like', $slug . '%')->count();
        return $count > 0 ? $slug . '-' . ($count + 1) : $slug;
    }
}
