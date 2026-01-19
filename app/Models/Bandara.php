<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bandara extends Model
{
    protected $fillable = [
        'nama_bandara',
        'kota',
        'negara',
        'kode_iata'
    ];

    /**
     * Relasi ke model Penerbangan sebagai bandara asal.
     */
    public function penerbanganAsal(): HasMany
    {
        return $this->hasMany(Penerbangan::class, 'id_bandara_asal');
    }

    /**
     * Relasi ke model Penerbangan sebagai bandara tujuan.
     */
    public function penerbanganTujuan(): HasMany
    {
        return $this->hasMany(Penerbangan::class, 'id_bandara_tujuan');
    }
}