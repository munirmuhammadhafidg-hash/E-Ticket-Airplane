<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BandaraSeeder extends Seeder
{
    public function run()
    {
        $bandaraList = [
            ['kode_iata' => 'CGK', 'nama_bandara' => 'Soekarno–Hatta International', 'kota' => 'Jakarta', 'negara' => 'Indonesia'],
            ['kode_iata' => 'DPS', 'nama_bandara' => 'Ngurah Rai International', 'kota' => 'Bali', 'negara' => 'Indonesia'],
            ['kode_iata' => 'SUB', 'nama_bandara' => 'Juanda International', 'kota' => 'Surabaya', 'negara' => 'Indonesia'],
            ['kode_iata' => 'KNO', 'nama_bandara' => 'Kualanamu International', 'kota' => 'Medan', 'negara' => 'Indonesia'],
            ['kode_iata' => 'BPN', 'nama_bandara' => 'Sultan Aji Muhammad Sulaiman', 'kota' => 'Balikpapan', 'negara' => 'Indonesia'],
            ['kode_iata' => 'UPG', 'nama_bandara' => 'Sultan Hasanuddin', 'kota' => 'Makassar', 'negara' => 'Indonesia'],
            ['kode_iata' => 'SIN', 'nama_bandara' => 'Changi Airport', 'kota' => 'Singapore', 'negara' => 'Singapore'],
            ['kode_iata' => 'KUL', 'nama_bandara' => 'Kuala Lumpur International', 'kota' => 'Kuala Lumpur', 'negara' => 'Malaysia'],
            ['kode_iata' => 'BKK', 'nama_bandara' => 'Suvarnabhumi Airport', 'kota' => 'Bangkok', 'negara' => 'Thailand'],
            ['kode_iata' => 'HND', 'nama_bandara' => 'Haneda Airport', 'kota' => 'Tokyo', 'negara' => 'Japan'],
            ['kode_iata' => 'ICN', 'nama_bandara' => 'Incheon International', 'kota' => 'Seoul', 'negara' => 'South Korea'],
            ['kode_iata' => 'HKG', 'nama_bandara' => 'Hong Kong International', 'kota' => 'Hong Kong', 'negara' => 'China'],
            ['kode_iata' => 'PVG', 'nama_bandara' => 'Shanghai Pudong', 'kota' => 'Shanghai', 'negara' => 'China'],
            ['kode_iata' => 'TPE', 'nama_bandara' => 'Taoyuan International', 'kota' => 'Taipei', 'negara' => 'Taiwan'],
            ['kode_iata' => 'DXB', 'nama_bandara' => 'Dubai International', 'kota' => 'Dubai', 'negara' => 'UAE'],
            ['kode_iata' => 'DOH', 'nama_bandara' => 'Hamad International', 'kota' => 'Doha', 'negara' => 'Qatar'],
            ['kode_iata' => 'IST', 'nama_bandara' => 'Istanbul Airport', 'kota' => 'Istanbul', 'negara' => 'Turkey'],
            ['kode_iata' => 'LHR', 'nama_bandara' => 'London Heathrow', 'kota' => 'London', 'negara' => 'UK'],
            ['kode_iata' => 'CDG', 'nama_bandara' => 'Charles de Gaulle', 'kota' => 'Paris', 'negara' => 'France'],
            ['kode_iata' => 'AMS', 'nama_bandara' => 'Schiphol Airport', 'kota' => 'Amsterdam', 'negara' => 'Netherlands'],
            ['kode_iata' => 'FRA', 'nama_bandara' => 'Frankfurt Airport', 'kota' => 'Frankfurt', 'negara' => 'Germany'],
            ['kode_iata' => 'ZRH', 'nama_bandara' => 'Zurich Airport', 'kota' => 'Zurich', 'negara' => 'Switzerland'],
            ['kode_iata' => 'JFK', 'nama_bandara' => 'John F. Kennedy', 'kota' => 'New York', 'negara' => 'USA'],
            ['kode_iata' => 'LAX', 'nama_bandara' => 'Los Angeles International', 'kota' => 'Los Angeles', 'negara' => 'USA'],
            ['kode_iata' => 'SYD', 'nama_bandara' => 'Kingsford Smith', 'kota' => 'Sydney', 'negara' => 'Australia'],
            ['kode_iata' => 'MEL', 'nama_bandara' => 'Melbourne Airport', 'kota' => 'Melbourne', 'negara' => 'Australia'],
        ];

        foreach ($bandaraList as $data) {
            DB::table('bandaras')->updateOrInsert(
                ['kode_iata' => $data['kode_iata']],
                $data
            );
        }
    }
}
