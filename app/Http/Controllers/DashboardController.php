<?php

namespace App\Http\Controllers;

use App\Models\Penerbangan;
use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_penerbangan' => Penerbangan::count(),
            'total_pelanggan'   => User::where('role', 'user')->count(),
            'tiket_terjual'     => Pemesanan::where('status_pembayaran', 'Lunas')->count(),
            'total_pendapatan'  => Pemesanan::where('status_pembayaran', 'Lunas')->sum('total_biaya'),
        ];

        $recentPemesanan = Pemesanan::with([
            'pengguna',
            'details.penerbangan.bandaraAsal',
            'details.penerbangan.bandaraTujuan'
        ])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPemesanan'));
    }
}
