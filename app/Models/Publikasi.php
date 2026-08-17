<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Publikasi extends Model
{
    protected $table = 'publikasi';

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'status',
        'deskripsi',
        'cover_gambar',
        'file_pdf',
        'file_pdf_preview',
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
        $slug = Str::slug($judul);
        $count = static::where('slug', 'like', $slug . '%')->count();
        return $count > 0 ? $slug . '-' . ($count + 1) : $slug;
    }
}
