@extends('layouts.app')

@section('content')
    <style>
        .search-results-wrapper {
            max-width: 850px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .search-header {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            border-radius: 16px;
            padding: 18px 24px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.2);
        }

        .sort-pill-container {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            align-items: center;
        }

        .btn-sort-pill {
            border: 1px solid #e2e8f0;
            background: white;
            color: #64748b;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.3s;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-sort-pill.active {
            background: #4f46e5;
            color: white;
            border-color: #4f46e5;
            shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
        }

        .btn-sort-pill:hover:not(.active) {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .flight-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .flight-card:hover {
            border-color: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.04);
        }

        .airline-sec {
            width: 25%;
            border-right: 1px solid #f1f5f9;
            padding-right: 15px;
        }

        .route-sec {
            width: 45%;
            padding: 0 30px;
        }

        .price-sec {
            width: 30%;
            text-align: right;
            border-left: 1px solid #f1f5f9;
            padding-left: 15px;
        }

        .time-text {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: -2px;
        }

        .iata-text {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .duration-line {
            position: relative;
            text-align: center;
            flex-grow: 1;
            margin: 0 20px;
        }

        .duration-line::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            border-top: 2px dashed #e2e8f0;
        }

        .duration-line i {
            background: white;
            position: relative;
            z-index: 1;
            padding: 0 8px;
            font-size: 14px;
            color: #4f46e5;
        }

        .price-val {
            font-size: 1.3rem;
            font-weight: 800;
            color: #4f46e5;
            display: block;
        }

        .btn-pilih-premium {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
            text-decoration: none !important;
        }

        .btn-pilih-premium:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
            color: white;
        }

        .btn-pilih-premium:active {
            transform: translateY(-1px);
        }

        .btn-login-premium {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        }

        .btn-login-premium:hover {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        }

        .btn-ubah-cari {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-ubah-cari:hover {
            background: white;
            color: #4f46e5;
            transform: scale(1.05);
        }
    </style>

    <div class="search-results-wrapper">
        <div class="search-header">
            <div>
                <h5 class="mb-1 fw-bold text-capitalize d-flex align-items-center gap-2">
                    {{ request('search') }} <i class="fas fa-long-arrow-alt-right opacity-75"></i> {{ request('tujuan') }}
                </h5>
                <p class="mb-0 opacity-90" style="font-size: 0.85rem;">
                    <i class="far fa-calendar-alt me-1"></i>
                    {{ \Carbon\Carbon::parse(request('tanggal'))->translatedFormat('d F Y') }}
                    <span class="mx-2">|</span>
                    <i class="fas fa-user-friends me-1"></i> <span class="fw-bold">{{ request('penumpang', 1) }}
                        Penumpang</span>
                </p>
            </div>
            <a href="{{ url('/') }}" class="btn-ubah-cari text-decoration-none">
                <i class="fas fa-edit me-1"></i> Ubah Pencarian
            </a>
        </div>

        <div class="sort-pill-container">
            <span class="text-muted small fw-bold me-2 uppercase tracking-wider">URUTKAN:</span>
            <div class="btn-sort-pill active" onclick="sortFlights('price', this)">
                <i class="fas fa-tag"></i> Harga Terendah
            </div>
            
        </div>

        <div id="flight-list">
            @forelse($results as $flight)
                @php
                    $requestedPassengers = (int) request('penumpang', 1);
                    $isAvailable = $flight->sisa_kursi >= $requestedPassengers;
                @endphp
               <div class="flight-card" 
     data-price="{{ (int) $flight->harga_dasar }}"
     data-time="{{ $flight->waktu_berangkat->format('Hi') }}"
     style="{{ !$isAvailable ? 'opacity: 0.6; grayscale(1); pointer-events: none;' : '' }}">

                    <div class="airline-sec">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600 flex flex-row items-center justify-center">
                                <i class="fas fa-plane"></i>
                                <h6 class="ml-2 fw-bold" style="font-size: 1rem;">{{ $flight->maskapai }}</h6>
                            </div>
                        </div>
                        <div class="flex flex-row gap-1 items-center justify-center">
                            <span class="text-muted d-block" style="font-size: 0.75rem;">{{ $flight->nomor_penerbangan }}</span>
                            <span class="badge bg-indigo-100 text-indigo-700 rounded-md py-1 px-2 ml-5"
                                style="font-size: 0.65rem; width: fit-content">Ekonomi</span>
                        </div>
                    </div>

                    <div class="route-sec d-flex align-items-center justify-content-between">
                        <div class="text-center">
                            <p class="time-text">{{ $flight->waktu_berangkat->format('H:i') }}</p>
                            <span class="iata-text">{{ $flight->bandaraAsal->kode_iata }}</span>
                        </div>

                        <div class="duration-line">
                            <span class="dur-time" style="font-size: 0.7rem; font-weight: 600;">{{ $flight->durasi }}</span>
                            <i class="fas fa-plane"></i>
                            <span class="d-block text-muted mt-1" style="font-size: 0.6rem;">Langsung</span>
                        </div>

                        <div class="text-center">
                            <p class="time-text">{{ $flight->waktu_datang->format('H:i') }}</p>
                            <span class="iata-text">{{ $flight->bandaraTujuan->kode_iata }}</span>
                        </div>
                    </div>

                    <div class="price-sec">
                        <span class="text-muted small d-block mb-1">Total harga</span>
                        <span class="price-val mb-2">Rp
                            {{ number_format($flight->harga_dasar * $requestedPassengers, 0, ',', '.') }}</span>

                        <div class="mb-3">
                            @if(!$isAvailable)
                                <div class="p-3 bg-red-50 border border-red-100 rounded-xl text-center">
                                    <span class="text-red-600 fw-bold d-block" style="font-size: 0.85rem;">
                                        <i class="fas fa-times-circle me-1"></i> Kursi Habis
                                    </span>
                                    <small class="text-red-400 d-block mt-1" style="font-size: 0.65rem;">
                                        Penerbangan ini tidak tersedia untuk {{ $requestedPassengers }} orang
                                    </small>
                                </div>
                            @elseif($flight->sisa_kursi <= ($requestedPassengers + 2))
                                <span class="badge bg-orange-100 text-orange-600 py-1 px-2 border border-orange-200"
                                    style="border-radius: 8px; font-size: 0.7rem;">
                                    <i class="fas fa-fire me-1"></i> Sisa {{ $flight->sisa_kursi }} Kursi!
                                </span>
                            @else
                                <span class="text-green-600 fw-bold d-flex align-items-center justify-content-end gap-1"
                                    style="font-size: 0.75rem;">
                                    <i class="fas fa-check-circle"></i> Tersedia
                                </span>
                            @endif
                        </div>

                        @if($isAvailable)
                            @auth
                                <a href="{{ route('user.pemesanan.create', ['id' => $flight->id, 'penumpang' => $requestedPassengers]) }}"
                                    class="btn-pilih-premium">
                                    <span>Pilih Tiket</span>
                                    <i class="fas fa-chevron-right small"></i>
                                </a>
                            @else
                                @php
                                    $intendedUrl = route('user.pemesanan.create', ['id' => $flight->id, 'penumpang' => $requestedPassengers]);
                                @endphp
                                <a href="{{ route('auth.save_url', ['return_url' => $intendedUrl]) }}"
                                    class="btn-pilih-premium btn-login-premium">
                                    <i class="fas fa-lock small"></i>
                                    <span>Login & Pesan</span>
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-5 bg-white rounded-3 border-dashed border-2">
                    <h5 class="fw-bold text-gray-800">Tidak ada penerbangan ditemukan</h5>
                    <p class="text-muted small">Coba cari rute atau tanggal yang berbeda.</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function sortFlights(type, element) {
            const list = document.getElementById('flight-list');
            const cards = Array.from(list.getElementsByClassName('flight-card'));

            document.querySelectorAll('.btn-sort-pill').forEach(btn => btn.classList.remove('active'));
            element.classList.add('active');

            cards.sort((a, b) => {
                const valA = parseInt(a.getAttribute(`data-${type}`));
                const valB = parseInt(b.getAttribute(`data-${type}`));
                return valA - valB;
            });

            list.innerHTML = "";
            cards.forEach(card => list.appendChild(card));
        }
    </script>
@endsection