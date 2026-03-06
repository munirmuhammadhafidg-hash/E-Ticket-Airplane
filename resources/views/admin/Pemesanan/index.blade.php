@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Monitoring Pemesanan</h1>
                <p class="text-sm text-gray-500">Verifikasi bukti pembayaran dan kelola status reservasi penumpang.</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
            <form action="{{ route('admin.pemesanan.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 w-full justify-between">
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-search text-sm"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition" 
                        placeholder="Cari Kode Booking...">
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <select name="status" onchange="this.form.submit()"
                        class="bg-gray-50 border border-gray-200 text-gray-600 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        <option value="">Semua Status Bayar</option>
                        <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50">
                        <tr class="text-[11px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">
                            <th class="px-6 py-4">Transaksi</th>
                            <th class="px-6 py-4">Penumpang Utama</th>
                            <th class="px-6 py-4 text-center">Bukti Bayar</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($pemesanans as $order)
                            @php 
                                $firstDetail = $order->details->first();
    $flight = $firstDetail ? $firstDetail->penerbangan : null;
                            @endphp
                                <tr class="hover:bg-gray-50/50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <span class="font-mono font-bold text-indigo-600 tracking-tighter">{{ $order->kode_pemesanan }}</span>
                                        <p class="text-[10px] text-gray-400 mt-1">{{ $order->waktu_pemesanan->format('d/m/Y H:i') }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-700">
                                            {{ $order->details->first()?->nama_penumpang ?? 'Data Tidak Ada' }}
                                        </div>
                                        <div class="text-[10px] text-gray-400 uppercase tracking-tighter">Total: {{ $order->details->count() }} Kursi</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($order->bukti_pembayaran)
                                            <span class="text-emerald-500 bg-emerald-50 px-2 py-1 rounded text-[10px] font-bold">
                                                <i class="fas fa-image mr-1"></i> Tersedia
                                            </span>
                                        @else
                                            <span class="text-gray-400 bg-gray-50 px-2 py-1 rounded text-[10px] font-bold">
                                                <i class="fas fa-times-circle mr-1"></i> Belum Ada
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-1 {{ $order->status_pembayaran == 'Lunas' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100' }} text-[9px] font-black uppercase rounded-lg border">
                                            {{ $order->status_pembayaran }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button type="button" onclick="showModal('modal-{{ $order->id }}')"
                                            class="inline-flex items-center px-3 py-1.5 bg-gray-50 text-gray-600 text-xs font-bold rounded-lg hover:bg-indigo-600 hover:text-white transition group">
                                            <i class="fas fa-search-dollar mr-2 group-hover:scale-110 transition"></i> Periksa
                                        </button>
                                    </td>
                                </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-gray-400 italic">Tidak ada data pemesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach($pemesanans as $order)
                <div id="modal-{{ $order->id }}" class="fixed inset-0 z-[60] hidden overflow-y-auto">
                    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="hideModal('modal-{{ $order->id }}')"></div>
                    <div class="flex items-center justify-center min-h-screen p-4">
                        <div class="relative bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden transform transition-all flex flex-col md:flex-row">


            <div class="w-full md:w-1/2 bg-gray-100 flex flex-col">
                <div class="p-4 bg-gray-200/50 flex justify-between items-center">
                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-600">Lampiran Bukti Bayar</span>
                </div>
                <div class="flex-1 flex items-center justify-center p-6">
                    @if($order->bukti_pembayaran && \Illuminate\Support\Facades\Storage::disk('public')->exists($order->bukti_pembayaran))
                        <a href="{{ asset('storage/' . $order->bukti_pembayaran) }}" target="_blank" class="group relative">
                            <img src="{{ asset('storage/' . $order->bukti_pembayaran) }}" 
                                 class="max-h-[400px] rounded-xl shadow-lg group-hover:opacity-90 transition object-contain"
                                 alt="Bukti Pembayaran">
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                <span class="bg-black/50 text-white px-3 py-1 rounded-full text-xs">Klik untuk Perbesar</span>
                            </div>
                        </a>
                    @else
                        <div class="text-center space-y-3">
                            <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto text-gray-400">
                                <i class="fas fa-image text-3xl"></i>
                            </div>
                            <p class="text-sm text-gray-500 font-medium">
                                @if($order->bukti_pembayaran)
                                    File ditemukan di database, tapi tidak ditemukan di folder storage.
                                @else
                                    User belum mengunggah<br>bukti pembayaran.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>

                            {{-- KANAN: Detail & Aksi --}}
                            <div class="w-full md:w-1/2 flex flex-col">
                                <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-indigo-600 text-white">
                                    <div>
                                        <h3 class="text-lg font-bold flex items-center">
                                            <i class="fas fa-check-double mr-3"></i> Validasi Pesanan
                                        </h3>
                                    </div>
                                    <button type="button" onclick="hideModal('modal-{{ $order->id }}')">
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>

                                <div class="p-8 space-y-6 overflow-y-auto max-h-[500px]">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase">Kode Booking</p>
                                            <p class="text-lg font-black text-indigo-600">{{ $order->kode_pemesanan }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase">Status Saat Ini</p>
                                            <span class="text-xs font-bold {{ $order->status_pembayaran == 'Lunas' ? 'text-emerald-600' : 'text-amber-600' }}">
                                                {{ $order->status_pembayaran }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase mb-2">Informasi Rute</p>
                                        <div class="flex justify-between items-center text-sm font-bold text-gray-700">
            @if($flight)
                <span>{{ $flight->bandaraAsal->kode_iata }}</span>
                <i class="fas fa-plane text-indigo-300"></i>
                <span>{{ $flight->bandaraTujuan->kode_iata }}</span>
            @else
                <span class="text-red-500 italic">Data penerbangan hilang</span>
            @endif
        </div>
                                    </div>

                                    <div class="space-y-3">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase">Daftar Penumpang</p>
                                        @foreach($order->details as $item)
                                            <div class="flex justify-between text-xs border-b border-gray-50 pb-2">
                                                <span class="text-gray-600">{{ $item->nama_penumpang }}</span>
                                                <span class="font-bold text-gray-800">Kursi {{ $item->nomor_kursi }}</span>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="pt-4 border-t border-gray-100">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase">Total Tagihan</p>
                                        <p class="text-2xl font-black text-gray-800">Rp {{ number_format($order->total_biaya, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                {{-- Form Update Status --}}
                                <div class="p-6 bg-gray-50 mt-auto">
                                    @if($order->status_pembayaran != 'Lunas')
                                        <form action="{{ route('admin.pemesanan.updateStatus', $order->id) }}" method="POST" class="space-y-3">
                                            @csrf @method('PATCH')
                                            <div class="flex gap-2">
                                                <select name="status_pembayaran" class="flex-1 text-sm border-gray-200 rounded-xl focus:ring-indigo-500">
                                                    <option value="Pending" {{ $order->status_pembayaran == 'Pending' ? 'selected' : '' }}>Tetap Pending</option>
                                                    <option value="Lunas" {{ !$order->bukti_pembayaran ? 'disabled' : '' }}>Lunas (Konfirmasi Bayar)</option>
                                                    <option value="Dibatalkan">Batalkan Pesanan</option>
                                                </select>
                                                <button type="submit" 
                                                    class="bg-indigo-600 text-white px-6 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                                                    Update
                                                </button>
                                            </div>
                                            @if(!$order->bukti_pembayaran)
                                                <p class="text-[10px] text-red-500 font-medium italic">* Opsi Lunas terkunci karena bukti bayar belum diupload.</p>
                                            @endif
                                        </form>
                                    @else
                                        <div class="text-center p-3 bg-emerald-100 text-emerald-700 rounded-xl text-xs font-bold">
                                            <i class="fas fa-check-circle mr-2"></i> Transaksi ini telah selesai (Lunas)
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    @endforeach

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
    </script>
@endsection