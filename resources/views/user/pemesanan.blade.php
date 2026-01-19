@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-8 px-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-8 flex items-center gap-3">
            <i class="fas fa-file-invoice text-indigo-600"></i> Detail Pemesanan Penerbangan
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <form action="{{ route('user.pemesanan.store') }}" method="POST" id="bookingForm">
                    @csrf
                    <input type="hidden" name="id_penerbangan" value="{{ $flight->id }}">
                    <input type="hidden" name="jumlah_penumpang" value="{{ $requestedPassengers }}">
                    
                    {{-- Hidden input untuk menyimpan array kursi yang dipilih --}}
                    <input type="hidden" name="nomor_kursi" id="input_nomor_kursi">

                    @for($i = 1; $i <= $requestedPassengers; $i++)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                        <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100">
                            <h3 class="font-bold text-indigo-900 flex items-center gap-2">
                                <i class="fas fa-user-circle"></i> Data Penumpang {{ $i }}
                                @if($i == 1 && auth()->check())
                                    <span class="text-[10px] bg-indigo-200 text-indigo-700 px-2 py-0.5 rounded-full ml-2">Data Akun</span>
                                @endif
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            {{-- Baris 1: Nama Lengkap --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap (Sesuai KTP/Paspor)</label>
                                <input type="text" name="nama[]" required
                                    value="{{ ($i == 1 && auth()->check()) ? auth()->user()->nama : '' }}"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                                    placeholder="Contoh: Budi Santoso">
                            </div>

                            {{-- Baris 2: NIK --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">NIK (Nomor Induk Kependudukan)</label>
                                <input type="text" name="nik[]" required maxlength="16" minlength="16"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none"
                                    placeholder="16 Digit Nomor KTP">
                            </div>

                            {{-- Baris 3: Email & Telepon --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Kontak</label>
                                    <input type="email" name="email[]" required
                                        value="{{ ($i == 1 && auth()->check()) ? auth()->user()->email : '' }}"
                                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none"
                                        placeholder="contoh@mail.com">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                                    {{-- Menggunakan name="nomor_telepon[]" agar sinkron dengan database --}}
                                    <input type="text" name="nomor_telepon[]" required
                                        value="{{ ($i == 1 && auth()->check()) ? auth()->user()->nomor_telepon : '' }}"
                                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none"
                                        placeholder="Contoh: 08123456789">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor

                    {{-- Section Pilih Kursi --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mt-6">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-th text-indigo-600"></i> Pilih Kursi Pesawat
                        </h3>
                        
                        <div class="flex flex-col items-center overflow-x-auto pb-4">
                            <div class="inline-grid grid-cols-7 gap-2 p-4 bg-gray-50 rounded-2xl border border-gray-200">
                                <div class="text-center text-[10px] font-bold text-gray-400 uppercase">A</div>
                                <div class="text-center text-[10px] font-bold text-gray-400 uppercase">B</div>
                                <div class="text-center text-[10px] font-bold text-gray-400 uppercase">C</div>
                                <div class="w-8"></div> 
                                <div class="text-center text-[10px] font-bold text-gray-400 uppercase">D</div>
                                <div class="text-center text-[10px] font-bold text-gray-400 uppercase">E</div>
                                <div class="text-center text-[10px] font-bold text-gray-400 uppercase">F</div>

                                @for ($row = 1; $row <= 10; $row++)
                                    @foreach (['A', 'B', 'C', 'AISLE', 'D', 'E', 'F'] as $col)
                                        @if ($col == 'AISLE')
                                            <div class="flex items-center justify-center text-[10px] font-bold text-gray-300">{{ $row }}</div>
                                        @else
                                            @php 
                                                $seatNum = $row . $col; 
                                                $isBooked = in_array($seatNum, $bookedSeats ?? []); 
                                            @endphp
                                            <button type="button" 
                                                    onclick="selectSeat('{{ $seatNum }}')"
                                                    id="seat-{{ $seatNum }}"
                                                    class="w-9 h-9 rounded-lg flex items-center justify-center text-[10px] font-bold transition-all border-2
                                                    {{ $isBooked ? 'bg-gray-200 border-gray-200 text-gray-400 cursor-not-allowed' : 'bg-white border-indigo-50 text-indigo-600 hover:border-indigo-400' }}"
                                                    {{ $isBooked ? 'disabled' : '' }}>
                                                {{ $col }}
                                            </button>
                                        @endif
                                    @endforeach
                                @endfor
                            </div>
                        </div>

                        <div class="mt-4 p-4 bg-indigo-50 rounded-xl border border-indigo-100">
                            <div class="flex justify-between items-center">
                                <p class="text-sm font-semibold text-indigo-800">Kursi Terpilih:</p>
                                <p class="text-xs text-indigo-500 font-medium">Butuh: {{ $requestedPassengers }} Kursi</p>
                            </div>
                            <div id="selected-seats-display" class="mt-1 text-sm font-black text-indigo-600 uppercase tracking-widest">
                                Belum ada kursi terpilih
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4 pb-2 border-b">Ringkasan Penerbangan</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Maskapai</p>
                                <p class="font-bold text-gray-800">{{ $flight->maskapai }} ({{ $flight->nomor_penerbangan }})</p>
                            </div>
                            <span class="bg-indigo-100 text-indigo-700 text-[10px] px-2 py-1 rounded-md font-bold uppercase">Ekonomi</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Rute & Waktu</p>
                            <p class="font-semibold text-gray-700">{{ $flight->bandaraAsal->kota }} → {{ $flight->bandaraTujuan->kota }}</p>
                            <p class="text-sm text-gray-500">{{ $flight->waktu_berangkat->format('H:i') }} - {{ $flight->waktu_datang->format('H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4 pb-2 border-b">Rincian Biaya</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Tiket ({{ $requestedPassengers }} Penumpang)</span>
                            <span class="font-semibold">Rp {{ number_format($flight->harga_dasar * $requestedPassengers, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Pajak & Biaya</span>
                            <span class="font-semibold">Rp {{ number_format(50000 * $requestedPassengers, 0, ',', '.') }}</span>
                        </div>
                        <div class="pt-3 border-t flex justify-between items-center">
                            <span class="font-bold text-gray-800">Total</span>
                            <span class="text-xl font-black text-indigo-600">Rp {{ number_format(($flight->harga_dasar + 50000) * $requestedPassengers, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit" form="bookingForm"
                        class="w-full mt-6 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-credit-card"></i> Pesan Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedSeats = [];
        const maxSeats = {{ $requestedPassengers }};

        function selectSeat(seatNum) {
            const index = selectedSeats.indexOf(seatNum);
            const btn = document.getElementById('seat-' + seatNum);

            if (index > -1) {
                selectedSeats.splice(index, 1);
                btn.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                btn.classList.add('bg-white', 'text-indigo-600', 'border-indigo-50');
            } else {
                if (selectedSeats.length < maxSeats) {
                    selectedSeats.push(seatNum);
                    btn.classList.remove('bg-white', 'text-indigo-600', 'border-indigo-50');
                    btn.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
                } else {
                    alert('Anda hanya bisa memilih ' + maxSeats + ' kursi.');
                }
            }
            updateSeatUI();
        }

        function updateSeatUI() {
            const display = document.getElementById('selected-seats-display');
            const hiddenInput = document.getElementById('input_nomor_kursi');
            
            if (selectedSeats.length > 0) {
                display.innerText = selectedSeats.join(', ');
                hiddenInput.value = selectedSeats.join(',');
            } else {
                display.innerText = 'Belum ada kursi terpilih';
                hiddenInput.value = '';
            }
        }

        document.getElementById('bookingForm').onsubmit = function(e) {
            if (selectedSeats.length < maxSeats) {
                e.preventDefault();
                alert('Silakan pilih ' + maxSeats + ' kursi terlebih dahulu.');
                return false;
            }
        };
    </script>
@endsection