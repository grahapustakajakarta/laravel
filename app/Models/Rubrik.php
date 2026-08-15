<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubrik extends Model
{
    use HasFactory;

    protected $table = 'tb_rubrik';
    
    // Disable timestamps if the native table doesn't have created_at/updated_at
    public $timestamps = false;

    protected $guarded = [];

    /**
     * Get the artikek for the rubrik.
     */
    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'rubrik_id', 'id');
    }
}
