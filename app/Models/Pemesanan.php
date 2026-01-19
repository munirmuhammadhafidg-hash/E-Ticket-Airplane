<?php

namespace App\Models;

use App\Models\User;
use App\Models\DetailTicket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemesanan extends Model
{
    protected $fillable = [
        'id_pengguna',
        'kode_pemesanan',
        'total_biaya',
        'status_pembayaran',
        'status_pemesanan',
        'waktu_pemesanan',
        'bukti_pembayaran'
    ];

    protected $casts = [
        'waktu_pemesanan' => 'datetime',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailTicket::class, 'id_pemesanan');
    }
}
