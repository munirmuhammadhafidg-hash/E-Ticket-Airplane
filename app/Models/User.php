<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    protected $fillable = ['nama', 'email', 'kata_sandi', 'nomor_telepon', 'role'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'id_pengguna');
    }
}
