<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PenerbanganSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('penerbangans')->truncate();

        Schema::enableForeignKeyConstraints();

        $maskapai = [
            ['n' => 'Garuda Indonesia', 'k' => 'GA'],
            ['n' => 'Singapore Airlines', 'k' => 'SQ'],
            ['n' => 'Emirates', 'k' => 'EK'],
            ['n' => 'Qatar Airways', 'k' => 'QR'],
            ['n' => 'AirAsia', 'k' => 'AK'],
            ['n' => 'Turkish Airlines', 'k' => 'TK'],
            ['n' => 'Cathay Pacific', 'k' => 'CX'],
            ['n' => 'ANA All Nippon', 'k' => 'NH'],
            ['n' => 'Qantas', 'k' => 'QF'],
            ['n' => 'Lufthansa', 'k' => 'LH'],
        ];

        $bandaraIds = DB::table('bandaras')->pluck('id')->toArray();

        $totalPenerbangan = 150;

        $batch = [];
        $now = Carbon::now();

        for ($i = 1; $i <= $totalPenerbangan; $i++) {
            $m = $maskapai[array_rand($maskapai)];
            $asal = $bandaraIds[array_rand($bandaraIds)];
            $tujuan = $bandaraIds[array_rand($bandaraIds)];

            while ($asal === $tujuan) {
                $tujuan = $bandaraIds[array_rand($bandaraIds)];
            }

            $nomorPenerbangan = $m['k'] . '-' . str_pad($i, 5, '0', STR_PAD_LEFT);

            $waktuBerangkat = (clone $now)->addMinutes(rand(60, 43200));
            $durasi = rand(90, 900);
            $waktuDatang = (clone $waktuBerangkat)->addMinutes($durasi);

            $batch[] = [
                'nomor_penerbangan' => $nomorPenerbangan,
                'maskapai' => $m['n'],
                'id_bandara_asal' => $asal,
                'id_bandara_tujuan' => $tujuan,
                'waktu_berangkat' => $waktuBerangkat,
                'waktu_datang' => $waktuDatang,
                'harga_dasar' => rand(1500000, 25000000),
                'sisa_kursi' => rand(20, 380),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('penerbangans')->insert($batch);
    }
}
