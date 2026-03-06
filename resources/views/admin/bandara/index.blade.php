@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Manajemen Bandara</h1>
                <p class="text-sm text-gray-500">Daftar titik keberangkatan dan tujuan penerbangan.</p>
            </div>
            <a href="{{ route('admin.bandara.create') }}"
                class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                <i class="fas fa-plus mr-2 text-xs"></i> Registrasi Bandara
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50">
                    <tr class="text-[11px] font-black text-gray-400 uppercase tracking-widest border-b">
                        <th class="px-6 py-4">Kode IATA</th>
                        <th class="px-6 py-4">Nama Bandara</th>
                        <th class="px-6 py-4">Lokasi</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @forelse($bandaras as $b)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 font-mono font-bold text-indigo-600">{{ $b->kode_iata }}</td>
                            <td class="px-6 py-4 font-bold text-gray-800">{{ $b->nama_bandara }}</td>
                            <td class="px-6 py-4 text-gray-500">
                                <i class="fas fa-map-marker-alt mr-1 text-rose-400"></i> {{ $b->kota }}, {{ $b->negara }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <a href="{{ route('admin.bandara.edit', $b->id) }}"
                                        class="text-gray-400 hover:text-indigo-600 transition">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.bandara.destroy', $b->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Hapus bandara ini?')">
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
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400">Belum ada data bandara.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6 px-2">
            {{ $bandaras->links() }}
        </div>
    </div>
@endsection