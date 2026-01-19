@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Ringkasan Sistem</h1>
            <p class="text-gray-500 text-sm">Halo {{ auth()->user()->nama }}, berikut adalah performa bisnis Anda hari ini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Total Penerbangan</p>
                <div class="flex justify-between items-end">
                    <h3 class="text-3xl font-black text-gray-800">{{ number_format($stats['total_penerbangan']) }}</h3>
                    <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plane"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Total Pelanggan</p>
                <div class="flex justify-between items-end">
                    <h3 class="text-3xl font-black text-gray-800">{{ number_format($stats['total_pelanggan']) }}</h3>
                    <div class="w-10 h-10 bg-amber-50 text-amber-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Tiket Terjual</p>
                <div class="flex justify-between items-end">
                    <h3 class="text-3xl font-black text-gray-800">{{ number_format($stats['tiket_terjual']) }}</h3>
                    <div class="w-10 h-10 bg-emerald-50 text-emerald-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex justify-between items-center">
        <h3 class="font-bold text-gray-800">Riwayat Pemesanan Terbaru</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50/80">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">ID Order</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Penerbangan</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentPemesanan ?? [] as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-mono font-bold text-blue-600 tracking-tight">{{ $order->kode_pemesanan }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($order->details->isNotEmpty())
                                <div class="flex items-center text-sm text-gray-700">
                                    <span class="font-semibold">{{ $order->details->first()->penerbangan->bandaraAsal->kota }}</span>
                                    <i class="fas fa-arrow-right text-[10px] mx-2 text-gray-400"></i>
                                    <span class="font-semibold">{{ $order->details->first()->penerbangan->bandaraTujuan->kota }}</span>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-0.5 uppercase tracking-wide">
                                    {{ $order->details->first()->penerbangan->maskapai ?? 'Penerbangan' }}
                                </p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusClasses = [
                                    'Lunas' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                    'Dibatalkan' => 'bg-red-100 text-red-700 border-red-200',
                                    'Pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                ];
                                $class = $statusClasses[$order->status_pembayaran] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $class }}">
                                {{ $order->status_pembayaran }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-inbox text-3xl text-gray-200 mb-3"></i>
                                <p class="text-gray-400 italic">Belum ada pemesanan masuk hari ini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
    </div>
@endsection