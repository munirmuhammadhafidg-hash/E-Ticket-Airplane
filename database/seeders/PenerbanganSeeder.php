<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PenerbanganSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('penerbangans')->truncate();
        Schema::enableForeignKeyConstraints();

        $maskapai = [
            ['n' => 'Garuda Indonesia', 'k' => 'GA'],
            ['n' => 'AirAsia', 'k' => 'AK'],
            ['n' => 'Lion Air', 'k' => 'JT'],
            ['n' => 'Batik Air', 'k' => 'ID'],
            ['n' => 'Citilink', 'k' => 'QG'],
            ['n' => 'Super Air Jet', 'k' => 'IU'],
            ['n' => 'Pelita Air', 'k' => 'IP'],
        ];

        $bandaraLokal = DB::table('bandaras')->where('negara', 'Indonesia')->pluck('id')->toArray();
        $bandaraIntl = DB::table('bandaras')->where('negara', '!=', 'Indonesia')->pluck('id')->toArray();
        $bandaraSibuk = DB::table('bandaras')
            ->whereIn('kode_iata', ['CGK', 'SUB', 'DPS', 'KNO', 'UPG', 'BPN'])
            ->pluck('id')
            ->toArray();

        if (empty($bandaraLokal)) {
            $this->command->error("Data bandara kosong! Jalankan BandaraSeeder dulu.");
            return;
        }

        $startDate = Carbon::now()->startOfDay();
        $endDate = (clone $startDate)->addMonths(2);

        $this->command->info("Memulai seeding untuk periode: " . $startDate->format('Y-m-d') . " s/d " . $endDate->format('Y-m-d'));

        // Counter global agar nomor penerbangan tidak pernah duplikat
        $globalFlightCounter = 1000;

        foreach ($maskapai as $m) {
            // Simulasi 8 pesawat per maskapai
            for ($i = 1; $i <= 8; $i++) {
                $currentLocation = $bandaraLokal[array_rand($bandaraLokal)];
                $currentTime = (clone $startDate)->addHours(rand(4, 11))->addMinutes(rand(0, 59));

                $batch = [];

                while ($currentTime->isBefore($endDate)) {
                    // Jam operasional
                    if ($currentTime->hour >= 23 || $currentTime->hour < 4) {
                        $currentTime->addDay()->hour(rand(4, 6))->minute(rand(0, 55));
                    }

                    if ($currentTime->isAfter($endDate)) break;

                    $dice = rand(1, 100);
                    if ($dice > 90 && !empty($bandaraIntl)) {
                        $destination = $bandaraIntl[array_rand($bandaraIntl)];
                        $durasi = 150;
                    } elseif ($dice > 35 && !empty($bandaraSibuk)) {
                        $destination = $bandaraSibuk[array_rand($bandaraSibuk)];
                        $durasi = 90;
                    } else {
                        $destination = $bandaraLokal[array_rand($bandaraLokal)];
                        $durasi = 90;
                    }

                    while ($destination == $currentLocation) {
                        $destination = $bandaraLokal[array_rand($bandaraLokal)];
                    }

                    $waktuBerangkat = clone $currentTime;
                    $waktuDatang = (clone $waktuBerangkat)->addMinutes($durasi);

                    $batch[] = [
                        // Menggunakan Counter Global agar unik
                        'nomor_penerbangan' => $m['k'] . '-' . str_pad($globalFlightCounter, 6, '0', STR_PAD_LEFT),
                        'maskapai'          => $m['n'],
                        'id_bandara_asal'   => $currentLocation,
                        'id_bandara_tujuan' => $destination,
                        'waktu_berangkat'   => $waktuBerangkat->toDateTimeString(),
                        'waktu_datang'      => $waktuDatang->toDateTimeString(),
                        'harga_dasar'       => rand(600000, 1500000),
                        'sisa_kursi'        => rand(100, 210),
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ];

                    $globalFlightCounter++; // Naikkan terus tanpa reset

                    if (count($batch) >= 50) {
                        DB::table('penerbangans')->insert($batch);
                        $batch = [];
                    }

                    $currentLocation = $destination;
                    $currentTime = (clone $waktuDatang)->addMinutes(rand(90, 180));
                }

                if (!empty($batch)) {
                    DB::table('penerbangans')->insert($batch);
                }
            }
        }
        $this->command->info("Seeding Penerbangan Berhasil (Tanpa Duplikat)!");
    }
}
