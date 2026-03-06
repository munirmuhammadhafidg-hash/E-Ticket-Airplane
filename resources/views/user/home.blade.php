@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary-blue: #2563eb;
            --secondary-blue: #eff6ff;
            --accent-green: #10b981;
            /* Emerald yang lebih segar */
            --accent-red: #ef4444;
            --accent-amber: #f59e0b;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --white: #ffffff;
        }

        body {
            background-color: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
        }

        .main-wrapper {
            max-width: 1100px;
            /* Sedikit lebih lebar agar lega */
            margin: 50px auto;
            padding: 0 20px;
        }

        /* Hero Section */
        .hero-section {
            margin-bottom: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .hero-section h2 {
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--text-main);
            font-size: 2rem;
        }

        .hero-section p {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        /* Search Card */
        .search-card-modern {
            background: var(--white);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
        }

        .search-card-modern h5 {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .input-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .input-group-custom label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .form-control-modern {
            width: 100%;
            padding: 14px 18px;
            background: #f8fafc;
            border: 2px solid #f1f5f9;
            border-radius: 14px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .form-control-modern:focus {
            background: #fff;
            border-color: var(--primary-blue);
            outline: none;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .btn-search-modern {
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 14px;
            font-weight: 700;
            width: 100%;
            margin-top: 10px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);
        }

        .btn-search-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 20px -5px rgba(37, 99, 235, 0.3);
        }

        /* Table Area */
        .section-header {
            margin-top: 60px;
            margin-bottom: 25px;
        }

        .section-header h3 {
            font-weight: 700;
            font-size: 1.3rem;
        }

        .table-container {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid #f1f5f9;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        }

        .table-modern {
            width: 100%;
            border-collapse: collapse;
        }

        .table-modern th {
            background: #f8fafc;
            padding: 18px 24px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 800;
            color: var(--text-muted);
            border-bottom: 1px solid #f1f5f9;
        }

        .table-modern td {
            padding: 20px 24px;
            border-bottom: 1px solid #f8fafc;
            font-size: 0.95rem;
        }

        .table-modern tr:last-child td {
            border-bottom: none;
        }

        /* Badge Status */
        .badge-status {
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-lunas {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #d1fae5;
        }

        .status-batal {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fee2e2;
        }

        .status-pending {
            background: #fffbeb;
            color: #d97706;
            border: 1px solid #fef3c7;
        }

        .id-order {
            font-family: 'Monaco', monospace;
            font-weight: 700;
            color: var(--primary-blue);
        }

        .price-text {
            font-weight: 800;
            color: var(--text-main);
        }

        /* Empty State */
        .empty-state-login {
            background: white;
            border-radius: 24px;
            padding: 60px 40px;
            text-align: center;
            border: 2px dashed #e2e8f0;
        }

        .lock-icon-circle {
            width: 70px;
            height: 70px;
            background: var(--secondary-blue);
            color: var(--primary-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 20px;
        }
    </style>

    <div class="main-wrapper">
        <div class="hero-section">
            <h2>Selamat Datang di SkyTicket</h2>
            <p>Temukan harga terbaik untuk perjalanan Anda selanjutnya.</p>
        </div>

        <div class="search-card-modern">
            <h5><span>🔍</span> Cari Penerbangan Baru</h5>
            <form action="{{ route('penerbangan.search') }}" method="GET">
                <div class="input-grid">
                    <div class="input-group-custom">
                        <label>Asal Penerbangan</label>
                        <input type="text" name="search" class="form-control-modern" placeholder="Contoh: Jakarta (CGK)"
                            required>
                    </div>

                    <div class="input-grid" style="grid-template-columns: 1.5fr 1fr 1fr; gap: 15px;">
                        <div class="input-group-custom">
                            <label>Tujuan</label>
                            <input type="text" name="tujuan" class="form-control-modern" placeholder="Contoh: Bali (DPS)"
                                required>
                        </div>
                        <div class="input-group-custom">
                            <label>Tanggal Pergi</label>
                            <input type="date" name="tanggal" class="form-control-modern" value="{{ date('Y-m-d') }}"
                                required>
                        </div>
                        <div class="input-group-custom">
                            <label>Jumlah Penumpang</label>
                            <input type="number" name="penumpang" class="form-control-modern" min="1" max="10" value="1"
                                required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-search-modern">Cari Tiket Sekarang</button>
            </form>
        </div>

        @auth
            <div class="section-header">
                <h3>📜 Riwayat Pemesanan</h3>
            </div>
            <div class="table-container">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Destinasi</th>
                            <th>Total Bayar</th>
                            <th style="text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orderHistory as $history)
                            <tr class="hover:bg-gray-50/50">
                                <td><span class="id-order">#{{ $history->kode_pemesanan }}</span></td>
                                <td>
                                    @if($history->details->isNotEmpty())
                                        <div style="display: flex; align-items: center; gap: 10px; font-weight: 600;">
                                            {{ $history->details->first()->penerbangan->bandaraAsal->kota }}
                                            <i class="fas fa-arrow-right" style="font-size: 0.7rem; color: #cbd5e1;"></i>
                                            {{ $history->details->first()->penerbangan->bandaraTujuan->kota }}
                                        </div>
                                    @endif
                                </td>
                                <td><span class="price-text">Rp {{ number_format($history->total_biaya, 0, ',', '.') }}</span></td>
                                <td style="text-align: center;">
                                    @php
                                        $statusClass = match ($history->status_pembayaran) {
                                            'Lunas' => 'status-lunas',
                                            'Dibatalkan' => 'status-batal',
                                            default => 'status-pending'
                                        };
                                        $icon = match ($history->status_pembayaran) {
                                            'Lunas' => 'fa-check-circle',
                                            'Dibatalkan' => 'fa-times-circle',
                                            default => 'fa-clock'
                                        };
                                    @endphp
                                    <span class="badge-status {{ $statusClass }}">
                                        <i class="fas {{ $icon }}"></i> {{ $history->status_pembayaran }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 50px; color: #94a3b8; font-style: italic;">
                                    Belum ada riwayat pemesanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endauth

        @guest
            <div class="section-header">
                <h3>📜 Riwayat Pemesanan</h3>
            </div>
            <div class="empty-state-login">
                <div class="lock-icon-circle">
                    <i class="fas fa-lock"></i>
                </div>
                <h4 style="font-weight: 800; margin-bottom: 10px;">Akses Terbatas</h4>
                <p style="color: var(--text-muted); margin-bottom: 25px;">Silakan masuk ke akun Anda untuk melihat riwayat
                    perjalanan dan tiket aktif.</p>
                <a href="{{ route('login') }}" class="btn-search-modern"
                    style="max-width: 250px; display: inline-block; text-decoration: none; margin-top: 0;">Login Sekarang</a>
            </div>
        @endguest
    </div>
@endsection