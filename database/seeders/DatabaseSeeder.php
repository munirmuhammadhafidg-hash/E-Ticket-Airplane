<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Bandara;
use App\Models\Penerbangan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Administrator Utama',
            'email' => 'admin@sky.com',
            'kata_sandi' => Hash::make('admin123'), 
            'nomor_telepon' => '08123456789',
            'role' => 'admin',
        ]);

        User::create([
            'nama' => 'Hafid',
            'email' => 'hafid@gmail.com',
            'kata_sandi' => Hash::make('hafid123'),
            'nomor_telepon' => '02839272538',
            'role' => 'user',
        ]);

        $this->call([
            BandaraSeeder::class,
            PenerbanganSeeder::class,
        ]);
    }
}