<?php

namespace App\Http\Controllers;

use App\Models\Bandara;
use App\Models\Pemesanan;
use App\Models\DetailTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $upcomingFlight = null;
        $orderHistory = [];

        if (auth()->check()) {
            $userId = auth()->id();

            $orderHistory = Pemesanan::where('id_pengguna', $userId)
                ->orderBy('waktu_pemesanan', 'desc')
                ->get();

            $upcomingFlight = DetailTicket::whereHas('pemesanan', function ($q) use ($userId) {
                $q->where('id_pengguna', $userId)
                    ->where('status_pemesanan', 'confirmed');
            })
                ->whereHas('penerbangan', function ($q) {
                    $q->where('waktu_berangkat', '>=', now());
                })
                ->with(['penerbangan.bandaraAsal', 'penerbangan.bandaraTujuan'])
                ->first();
        }

        return view('user.home', compact('upcomingFlight', 'orderHistory'));
    }
}
