<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penerbangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_penerbangan',
        'maskapai',
        'id_bandara_asal',
        'id_bandara_tujuan',
        'waktu_berangkat',
        'waktu_datang',
        'harga_dasar',
        'sisa_kursi',
    ];

    protected $casts = [
        'waktu_berangkat' => 'datetime',
        'waktu_datang' => 'datetime',
        'harga_dasar' => 'decimal:2',
        'sisa_kursi' => 'integer',
    ];

    public function cekKetersediaan($jumlah = 1): bool
    {
        return $this->sisa_kursi >= $jumlah;
    }

    public function getDurasiAttribute(): string
    {
        if ($this->waktu_berangkat && $this->waktu_datang) {
            $diff = $this->waktu_berangkat->diff($this->waktu_datang);
            return $diff->format('%hj %im');
        }
        return '0j 0m';
    }


    public function bandaraAsal(): BelongsTo
    {
        return $this->belongsTo(Bandara::class, 'id_bandara_asal');
    }

    public function bandaraTujuan(): BelongsTo
    {
        return $this->belongsTo(Bandara::class, 'id_bandara_tujuan');
    }

    public function detailTikets(): HasMany
    {
        return $this->hasMany(DetailTicket::class, 'id_penerbangan');
    }
}
