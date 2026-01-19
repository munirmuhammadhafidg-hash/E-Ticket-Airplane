<?php

namespace App\Models;

use App\Models\Penerbangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTicket extends Model
{
    protected $fillable = [
        'id_pemesanan', 'id_penerbangan', 'nama_penumpang', 
        'nomor_kursi', 'tipe_kelas', 'harga_beli', 'nik', 'nomor_telepon'
    ];

    public function penerbangan(): BelongsTo {
        return $this->belongsTo(Penerbangan::class, 'id_penerbangan');
    }

    public function pemesanan() : BelongsTo {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }
}
