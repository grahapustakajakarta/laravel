<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Subscriber — merepresentasikan tabel subscribers.
 *
 * FASE 1 Normalisasi 3NF:
 * - Relasi proper ke Pengguna via pengguna_id (FK).
 * - Kolom nama & email tetap ada untuk backward compat (diisi via model event).
 * - Penyimpanan/pencarian kini diutamakan via pengguna_id, bukan email.
 */
class Subscriber extends Model
{
    protected $table = 'subscribers';

    protected $fillable = [
        'pengguna_id',
        'paket',
        'status',
        'berlaku_hingga',
    ];

    public function histories()
    {
        return $this->hasMany(SubscriptionHistory::class, 'pengguna_id', 'pengguna_id');
    }

    protected $casts = [
        'berlaku_hingga' => 'datetime',
    ];

    // ─── Relasi ─────────────────────────────────────────────────────

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    // ─── Accessors / Helpers ─────────────────────────────────────────

    /**
     * Cek apakah langganan masih aktif (status aktif DAN belum kedaluwarsa).
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'aktif'
            && $this->berlaku_hingga
            && Carbon::parse($this->berlaku_hingga)->isFuture();
    }

    // ─── Scope Helpers ───────────────────────────────────────────────

    /**
     * Temukan subscriber aktif berdasarkan pengguna_id.
     */
    public static function findActiveByPenggunaId(int $penggunaId): ?self
    {
        return static::where('pengguna_id', $penggunaId)->first();
    }

    /**
     * Hitung tanggal berlaku_hingga baru berdasarkan paket yang dipilih.
     * Jika langganan masih aktif, tambahkan dari tanggal kedaluwarsa lama.
     * Jika sudah habis, mulai dari sekarang.
     */
    public static function hitungBerlakuHingga(string $paket, ?self $existing = null): Carbon
    {
        $baseDate = now();

        if ($existing && $existing->berlaku_hingga && Carbon::parse($existing->berlaku_hingga)->isFuture()) {
            $baseDate = Carbon::parse($existing->berlaku_hingga);
        }

        return match ($paket) {
            'paket4bulan' => $baseDate->copy()->addMonths(4),
            'paket6bulan' => $baseDate->copy()->addMonths(6),
            default       => $baseDate->copy()->addMonth(), // bulanan
        };
    }
}
