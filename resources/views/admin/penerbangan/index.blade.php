@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Manajemen Penerbangan</h1>
                <p class="text-sm text-gray-500">Daftar jadwal, maskapai, dan ketersediaan kursi pesawat.</p>
            </div>
            <a href="{{ route('admin.penerbangan.create') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                <i class="fas fa-plus mr-2 text-xs"></i> Tambah Jadwal
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[11px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">
                            <th class="px-8 py-5">No. Penerbangan</th>
                            <th class="px-8 py-5">Maskapai</th>
                            <th class="px-8 py-5">Keberangkatan</th>
                            <th class="px-8 py-5">Kedatangan</th>
                            <th class="px-8 py-5">Sisa Kursi</th>
                            <th class="px-8 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($penerbangan as $item)
                        <tr class="hover:bg-gray-50/50 transition duration-150">
                            <td class="px-8 py-5 font-bold text-indigo-600 uppercase tracking-wider">
                                {{ $item->nomor_penerbangan }}
                            </td>

                            <td class="px-8 py-5 font-bold text-gray-800">
                                {{ $item->maskapai }}
                            </td>

                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-700">{{ $item->bandaraAsal->kode_iata }}</span>
                                    <span class="text-xs text-gray-500">{{ $item->waktu_berangkat->format('d M Y') }}</span>
                                    <span class="text-xs text-indigo-500 font-medium">{{ $item->waktu_berangkat->format('H:i') }}</span>
                                </div>
                            </td>

                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-700">{{ $item->bandaraTujuan->kode_iata }}</span>
                                    <span class="text-xs text-gray-500">{{ $item->waktu_datang->format('d M Y') }}</span>
                                    <span class="text-xs text-rose-500 font-medium">{{ $item->waktu_datang->format('H:i') }}</span>
                                </div>
                            </td>

                            <td class="px-8 py-5 text-gray-500">
                                <span class="{{ $item->sisa_kursi < 10 ? 'text-rose-500 font-bold' : '' }}">
                                    {{ $item->sisa_kursi }} Kursi
                                </span>
                            </td>

                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end items-center gap-4">
                                    <a href="{{ route('admin.penerbangan.edit', $item->id) }}" class="text-gray-400 hover:text-indigo-600 transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.penerbangan.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jadwal ini?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-rose-500 transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-8 py-10 text-center text-gray-400 italic">Belum ada data penerbangan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6 px-2">
            {{ $penerbangan->links() }}
        </div>
    </div>
@endsection