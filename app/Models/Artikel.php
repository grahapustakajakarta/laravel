<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Artikel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'artikel';
    
    protected $guarded = [];

    protected $casts = [
        'tanggal_publikasi' => 'date',
    ];

    /**
     * Boot the model and add slug generation.
     */
    protected static function boot()
    {
        parent::boot();

        if (!request()->is('admin/*')) {
            static::addGlobalScope('published', function (Builder $builder) {
                // If there's a status column, we filter it.
                $builder->where('status', 'publish');
            });
        }

        static::saving(function ($model) {
            if (empty($model->slug) || $model->isDirty('judul')) {
                $model->slug = Str::slug($model->judul);
                
                // Ensure slug is unique
                $originalSlug = $model->slug;
                $count = 1;
                
                while (static::withTrashed()
                             ->where('slug', $model->slug)
                             ->when($model->exists, function($q) use ($model) {
                                 return $q->where('id', '!=', $model->id);
                             })
                             ->exists()) {
                    $model->slug = "{$originalSlug}-{$count}";
                    $count++;
                }
            }
        });
    }

    /**
     * Get the kategori associated with the artikel.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    /**
     * Get the penulis associated with the artikel.
     */
    public function penulis()
    {
        return $this->belongsTo(Penulis::class, 'penulis_id', 'id')->withDefault([
            'nama' => $this->penulis_manual ?? 'Editorial Team',
        ]);
    }

    /**
     * Get the gambar associated with the artikel.
     */
    public function gambar()
    {
        return $this->hasMany(GambarArtikel::class, 'artikel_id', 'id')->orderBy('urutan', 'asc');
    }

    /**
     * Accessor to get first image directly (for backward compatibility / ease of use).
     */
    public function getGambarPertamaAttribute()
    {
        // Jika diset manual (seperti di livePreview), kembalikan nilai tersebut
        if (array_key_exists('gambar_pertama', $this->attributes)) {
            return $this->attributes['gambar_pertama'];
        }
        $gambar = $this->gambar()->first();
        return $gambar ? $gambar->file_gambar : 'default.jpg';
    }

    /**
     * Get array of all images (for backward compatibility).
     */
    public function getGambarArrayAttribute()
    {
        return $this->gambar()->pluck('file_gambar')->toArray();
    }
}
