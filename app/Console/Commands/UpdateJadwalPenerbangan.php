<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateJadwalPenerbangan extends Command
{
    protected $signature = 'penerbangan:update-schedule';
    protected $description = 'Otomatis menambah jadwal dengan kolom kode_iata yang benar';

    public function handle()
    {
        $bandaraLokal = DB::table('bandaras')->where('negara', 'Indonesia')->pluck('id')->toArray();
        $bandaraIntl = DB::table('bandaras')->where('negara', '!=', 'Indonesia')->pluck('id')->toArray();

        // Gunakan kode_iata sesuai migrasi kamu
        $bandaraSibuk = DB::table('bandaras')
            ->whereIn('kode_iata', ['CGK', 'SUB', 'DPS', 'KNO', 'UPG'])
            ->pluck('id')
            ->toArray();

        $armada = DB::table('penerbangans')->distinct()->pluck('nomor_penerbangan');

        foreach ($armada as $noPenerbangan) {
            $lastFlight = DB::table('penerbangans')
                ->where('nomor_penerbangan', $noPenerbangan)
                ->orderBy('waktu_datang', 'desc')
                ->first();

            if ($lastFlight) {
                $waktuBisaTerbangLagi = Carbon::parse($lastFlight->waktu_datang)->addMinutes(rand(120, 180));

                if ($waktuBisaTerbangLagi->hour >= 23 || $waktuBisaTerbangLagi->hour < 5) {
                    $waktuBisaTerbangLagi->addDay()->hour(rand(5, 7));
                }

                if ($waktuBisaTerbangLagi->isBefore(now()->addDays(2))) {
                    $asal = $lastFlight->id_bandara_tujuan;

                    $dice = rand(1, 100);
                    if ($dice > 90 && !empty($bandaraIntl)) {
                        $tujuan = $bandaraIntl[array_rand($bandaraIntl)];
                        $durasi = 150;
                    } elseif ($dice > 30 && !empty($bandaraSibuk)) {
                        $tujuan = $bandaraSibuk[array_rand($bandaraSibuk)];
                        $durasi = 90;
                    } else {
                        $tujuan = $bandaraLokal[array_rand($bandaraLokal)];
                        $durasi = 90;
                    }

                    while ($tujuan == $asal) {
                        $tujuan = $bandaraLokal[array_rand($bandaraLokal)];
                    }

                    DB::table('penerbangans')->insert([
                        'nomor_penerbangan' => $noPenerbangan,
                        'maskapai'          => $lastFlight->maskapai,
                        'id_bandara_asal'   => $asal,
                        'id_bandara_tujuan' => $tujuan,
                        'waktu_berangkat'   => $waktuBisaTerbangLagi,
                        'waktu_datang'      => (clone $waktuBisaTerbangLagi)->addMinutes($durasi),
                        'harga_dasar'       => rand(600000, 1600000),
                        'sisa_kursi'        => rand(150, 200),
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ]);
                }
            }
        }
        $this->info("Command update schedule berhasil dijalankan.");
    }
}
