@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto py-8 px-4">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Riwayat Pesanan</h2>
                <p class="text-gray-500 text-sm">Pantau status tiket dan perjalanan Anda di sini.</p>
            </div>
            <a href="{{ url('/') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                Cari Tiket Lagi
            </a>
        </div>

        <div class="space-y-6">
            @forelse($pemesanans as $order)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100 flex flex-wrap justify-between items-center gap-4">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">ID Pesanan</span>
                            <span class="font-mono font-bold text-indigo-600">{{ $order->kode_pemesanan }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($order->status_pembayaran == 'Lunas')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                    <i class="fas fa-check-circle"></i> Terbayar
                                </span>
                            @elseif($order->status_pembayaran == 'Dibatalkan')
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                    <i class="fas fa-times-circle"></i> Dibatalkan
                                </span>
                            @else
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                    <i class="fas fa-clock"></i> {{ $order->bukti_pembayaran ? 'Menunggu Verifikasi' : 'Pending' }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6">
                        @foreach($order->details as $detail)
                            <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-4 last:mb-0">
                                @if($detail->penerbangan)
                                    <div class="flex items-center gap-4 w-full md:w-1/4">
                                        <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 text-xl">
                                            <i class="fas fa-plane"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800 leading-tight">{{ $detail->penerbangan->maskapai }}</p>
                                            <p class="text-xs text-gray-500">{{ $detail->penerbangan->nomor_penerbangan }} • {{ ucfirst($detail->tipe_kelas) }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between flex-1 w-full md:w-auto px-4">
                                        <div class="text-center">
                                            <p class="text-lg font-bold text-gray-800">{{ $detail->penerbangan->waktu_berangkat->format('H:i') }}</p>
                                            <p class="text-xs font-bold text-gray-400">{{ $detail->penerbangan->bandaraAsal->kode_iata ?? '???' }}</p>
                                        </div>
                                        <div class="flex-1 flex flex-col items-center px-4">
                                            <span class="text-[10px] text-gray-400 font-bold mb-1">{{ $detail->penerbangan->durasi }}</span>
                                            <div class="w-full h-[2px] border-t-2 border-dashed border-gray-200 relative">
                                                <i class="fas fa-plane text-gray-300 absolute -top-1.5 left-1/2 -translate-x-1/2 bg-white px-2 text-[10px]"></i>
                                            </div>
                                            <span class="text-[10px] text-gray-400 mt-1">Langsung</span>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-lg font-bold text-gray-800">{{ $detail->penerbangan->waktu_datang->format('H:i') }}</p>
                                            <p class="text-xs font-bold text-gray-400">{{ $detail->penerbangan->bandaraTujuan->kode_iata ?? '???' }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="w-full flex-1 bg-red-50 p-2 rounded text-red-500 text-xs italic text-center">
                                        Data penerbangan sudah tidak tersedia.
                                    </div>
                                @endif

                                <div class="w-full md:w-1/4 text-right border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-6">
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Penumpang</p>
                                    <p class="font-bold text-gray-800 text-sm">{{ $detail->nama_penumpang }}</p>
                                    <p class="text-xs font-semibold text-indigo-600 bg-indigo-50 inline-block px-2 py-0.5 rounded mt-1">Kursi {{ $detail->nomor_kursi }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="px-6 py-4 bg-gray-50/30 border-t border-gray-100 flex justify-between items-center">
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase leading-none mb-1">Total Pembayaran</p>
                            <p class="text-lg font-black text-gray-800">Rp {{ number_format($order->total_biaya, 0, ',', '.') }}</p>
                        </div>

                        <div class="flex gap-2">
                            @if($order->status_pembayaran == 'Lunas')
                                <button type="button" onclick="showModal('invoice-{{ $order->id }}')" 
                                    class="bg-indigo-600 text-white px-6 py-2 rounded-xl text-xs font-bold hover:bg-indigo-700 transition shadow-md shadow-indigo-100 flex items-center gap-2">
                                    <i class="fas fa-file-invoice"></i> Detail Pemesanan
                                </button>
                            @elseif($order->status_pembayaran == 'Pending')
                                <button type="button" onclick="showModal('detail-pending-{{ $order->id }}')" 
                                    class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-gray-200 transition flex items-center gap-2">
                                    <i class="fas fa-info-circle"></i> Detail
                                </button>

                                <button type="button" onclick="showModal('upload-{{ $order->id }}')" 
                                    class="bg-orange-500 text-white px-6 py-2 rounded-xl text-xs font-bold hover:bg-orange-600 transition shadow-md shadow-orange-100 flex items-center gap-2">
                                    <i class="fas fa-upload"></i> {{ $order->bukti_pembayaran ? 'Ganti Bukti' : 'Upload Bukti' }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Modal Detail Pending --}}
                @if($order->status_pembayaran == 'Pending')
                <div id="detail-pending-{{ $order->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
                    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="hideModal('detail-pending-{{ $order->id }}')"></div>
                    <div class="flex items-center justify-center min-h-screen p-4">
                        <div class="relative bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden transform transition-all">
                            <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-800 text-white">
                                <h3 class="font-bold flex items-center">
                                    <i class="fas fa-receipt mr-2 text-orange-400"></i> Detail Tagihan
                                </h3>
                                <button type="button" onclick="hideModal('detail-pending-{{ $order->id }}')" class="text-gray-400 hover:text-white">
                                    <i class="fas fa-times text-lg"></i>
                                </button>
                            </div>
                            <div class="p-8 space-y-6">
                                <div class="bg-orange-50 border border-orange-100 p-4 rounded-2xl">
                                    <p class="text-[10px] font-black text-orange-500 uppercase tracking-widest mb-2">Instruksi Pembayaran</p>
                                    <p class="text-sm text-gray-700">Silakan transfer ke rekening berikut:</p>
                                    <div class="mt-2 font-bold text-gray-800">
                                        <p>Bank BCA: 8830-1234-5678</p>
                                        <p>a.n PT SKY TICKET INDONESIA</p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex justify-between border-b border-dashed border-gray-200 pb-4">
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase">Kode Booking</p>
                                            <p class="text-xl font-black text-indigo-600">{{ $order->kode_pemesanan }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase">Status</p>
                                            <p class="text-xs font-bold text-orange-500 italic">Menunggu Pembayaran</p>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase">Rincian Penumpang</p>
                                        @foreach($order->details as $detail)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ $detail->nama_penumpang }}</span>
                                            <span class="font-bold text-gray-800">Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</span>
                                        </div>
                                        @endforeach
                                        <div class="flex justify-between pt-4 border-t border-gray-100 mt-2">
                                            <span class="font-bold text-gray-800">Total Tagihan</span>
                                            <span class="text-lg font-black text-indigo-600">Rp {{ number_format($order->total_biaya, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 bg-gray-50 flex gap-3">
                                <button type="button" onclick="hideModal('detail-pending-{{ $order->id }}')" class="flex-1 px-4 py-3 bg-white border border-gray-200 text-gray-600 text-xs font-bold rounded-xl hover:bg-gray-100 transition">Tutup</button>
                                <button type="button" onclick="hideModal('detail-pending-{{ $order->id }}'); showModal('upload-{{ $order->id }}')" class="flex-1 px-4 py-3 bg-indigo-600 text-white text-xs font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">Upload Bukti Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Modal Upload Bukti --}}
                @if($order->status_pembayaran == 'Pending')
                <div id="upload-{{ $order->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
                    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="hideModal('upload-{{ $order->id }}')"></div>
                    <div class="flex items-center justify-center min-h-screen p-4">
                        <div class="relative bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden p-6 transform transition-all">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-bold text-gray-800">Upload Bukti Pembayaran</h3>
                                <button type="button" onclick="hideModal('upload-{{ $order->id }}')" class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>

                            <form action="{{ route('user.pemesanan.upload', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                @method('PATCH')

                                <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-indigo-200 mb-3"></i>
                                    <input type="file" name="bukti_pembayaran" required class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer" />
                                    <p class="text-[10px] text-gray-400 mt-2">Format: JPG, PNG (Max. 2MB)</p>
                                </div>

                                @if($order->bukti_pembayaran)
                                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase mb-2">Bukti Saat Ini:</p>
                                        <img src="{{ asset('storage/' . $order->bukti_pembayaran) }}" class="w-full h-32 object-cover rounded-lg">
                                    </div>
                                @endif

                                <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold text-sm hover:bg-indigo-700 transition">
                                    Simpan Perubahan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Modal Invoice Lunas --}}
                @if($order->status_pembayaran == 'Lunas')
                    <div id="invoice-{{ $order->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
                        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
                            onclick="hideModal('invoice-{{ $order->id }}')"></div>
                        <div class="flex items-center justify-center min-h-screen p-4">
                            <div class="relative bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden transform transition-all">
                                <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-indigo-600 text-white">
                                    <h3 class="font-bold flex items-center">
                                        <i class="fas fa-ticket-alt mr-2"></i> Rincian E-Tiket
                                    </h3>
                                    <button type="button" onclick="hideModal('invoice-{{ $order->id }}')"
                                        class="text-indigo-200 hover:text-white transition">
                                        <i class="fas fa-times text-lg"></i>
                                    </button>
                                </div>

                                <div class="p-8 space-y-6">
                                    <div class="flex justify-between items-start border-b border-dashed border-gray-200 pb-6">
                                        <div>
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Kode Booking</p>
                                            <h4 class="text-2xl font-black text-indigo-600 leading-none">{{ $order->kode_pemesanan }}</h4>
                                            {{-- MENAMBAHKAN TANGGAL CETAK --}}
                                            <p class="text-[10px] text-gray-400 mt-2 uppercase font-bold">
                                                {{ \Carbon\Carbon::parse($order->waktu_pemesanan)->locale('id')->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') }}

                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</p>
                                            <span
                                                class="inline-block px-3 py-1 mt-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase rounded-lg border border-emerald-200">
                                                {{ $order->status_pembayaran }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Daftar Penumpang</p>
                                        @foreach($order->details as $detail)
                                            <div class="flex justify-between items-center bg-gray-50 p-3 rounded-xl border border-gray-100">
                                                <div>
                                                    <p class="text-sm font-bold text-gray-800">{{ $detail->nama_penumpang }}</p>
                                                    <p class="text-[10px] font-medium text-indigo-500 flex items-center gap-1">
                                                        <i class="fas fa-id-card text-[9px]"></i> NIK: <span
                                                            class="font-mono">{{ $detail->nik }}</span>
                                                    </p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-xs text-indigo-600 font-bold">Kursi {{ $detail->nomor_kursi }}</p>
                                                    <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $detail->tipe_kelas }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @php $firstFlight = $order->details->first()?->penerbangan; @endphp
                                @if($firstFlight)
                                    <div class="bg-indigo-50/50 p-5 rounded-2xl space-y-4 border border-indigo-100 relative">
                                        {{-- Label Maskapai --}}
                                        <div
                                            class="absolute -top-3 left-4 bg-indigo-600 text-white px-3 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider shadow-sm">
                                            {{ $firstFlight->maskapai }}
                                        </div>

                                        {{-- INFO TANGGAL KEBERANGKATAN --}}
                                        <div class="flex items-center gap-2 text-indigo-900 mb-2">
                                            <i class="far fa-calendar-alt text-xs text-indigo-400"></i>
                                            <span class="text-xs font-bold">{{ $firstFlight->waktu_berangkat->translatedFormat('l, d F Y') }}</span>
                                        </div>

                                        <div class="flex justify-between items-center">
                                            {{-- Berangkat --}}
                                            <div class="text-left">
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Keberangkatan</p>
                                                <p class="text-2xl font-black text-indigo-700 leading-none my-1">
                                                    {{ $firstFlight->waktu_berangkat->format('H:i') }}</p>
                                                <p class="text-sm font-black text-gray-800">{{ $firstFlight->bandaraAsal->kode_iata ?? '???' }}</p>
                                            </div>

                                            {{-- Dekorasi Pesawat --}}
                                            <div class="flex flex-col items-center flex-1 px-4">
                                                <span class="text-[9px] text-indigo-400 font-bold mb-1">{{ $firstFlight->durasi }}</span>
                                                <div class="flex items-center w-full">
                                                    <div class="h-[1.5px] flex-1 bg-indigo-200"></div>
                                                    <i class="fas fa-plane text-indigo-400 text-[11px] mx-2"></i>
                                                    <div class="h-[1.5px] flex-1 bg-indigo-200"></div>
                                                </div>
                                                <span class="text-[9px] text-gray-400 font-bold mt-1">Langsung</span>
                                            </div>

                                            {{-- Datang --}}
                                            <div class="text-right">
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Kedatangan</p>
                                                <p class="text-2xl font-black text-indigo-700 leading-none my-1">
                                                    {{ $firstFlight->waktu_datang->format('H:i') }}</p>
                                                <p class="text-sm font-black text-gray-800">{{ $firstFlight->bandaraTujuan->kode_iata ?? '???' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                </div>

                                <div class="p-6 bg-gray-50 flex gap-3">
                                    <button type="button" onclick="hideModal('invoice-{{ $order->id }}')"
                                        class="flex-1 px-4 py-3 bg-white border border-gray-200 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-100 transition shadow-sm">
                                        Tutup
                                    </button>
                                    <a href="{{ route('user.pemesanan.pdf', $order->id) }}" target="_blank"
                                        class="flex-1 px-4 py-3 bg-red-600 text-white text-sm font-bold rounded-xl hover:bg-red-700 transition shadow-lg shadow-red-100 flex items-center justify-center gap-2">
                                        <i class="fas fa-file-pdf"></i> Cetak PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            @empty
                <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-100">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300 text-3xl">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Belum ada pesanan</h3>
                    <p class="text-gray-500 text-sm max-w-xs mx-auto mt-1">Tiket yang Anda pesan akan muncul di sini.</p>
                    <a href="{{ url('/') }}" class="mt-6 inline-block text-indigo-600 font-bold text-sm hover:underline">
                        Cari Penerbangan Sekarang →
                    </a>
                </div>
            @endforelse

            <div class="mt-6">
                {{ $pemesanans->links() }}
            </div>
        </div>
    </div>

    <script>
        function showModal(id) {
            const modal = document.getElementById(id);
            if(modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function hideModal(id) {
            const modal = document.getElementById(id);
            if(modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                const modals = document.querySelectorAll('[id^="invoice-"], [id^="upload-"], [id^="detail-pending-"]');
                modals.forEach(modal => modal.classList.add('hidden'));
                document.body.style.overflow = 'auto';
            }
        });
    </script>
@endsection