@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
        <a href="{{ route('admin.penerbangan.index') }}" class="hover:text-indigo-600">Manajemen Penerbangan</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-gray-800 font-medium">Edit Jadwal #{{ $penerbangan->nomor_penerbangan }}</span>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Jadwal Terbang</h1>
                <p class="text-sm text-gray-500">Perbarui informasi jadwal atau harga tiket.</p>
            </div>
            <span class="px-4 py-2 bg-amber-50 text-amber-600 text-xs font-bold rounded-xl border border-amber-100">Mode Edit</span>
        </div>

        <form action="{{ route('admin.penerbangan.update', $penerbangan->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Maskapai</label>
                    <input type="text" name="maskapai" value="{{ $penerbangan->maskapai }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Penerbangan</label>
                    <input type="text" name="nomor_penerbangan" value="{{ $penerbangan->nomor_penerbangan }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50 uppercase">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-amber-50/30 rounded-2xl border border-amber-100/50">
                <div>
                    <label class="block text-sm font-bold text-amber-900 mb-2">Bandara Asal</label>
                    <select name="id_bandara_asal" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                        @foreach($bandaras as $bandara)
                            <option value="{{ $bandara->id }}" {{ $penerbangan->id_bandara_asal == $bandara->id ? 'selected' : '' }}>
                                {{ $bandara->nama_bandara }} ({{ $bandara->kode_iata }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-amber-900 mb-2">Bandara Tujuan</label>
                    <select name="id_bandara_tujuan" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                        @foreach($bandaras as $bandara)
                            <option value="{{ $bandara->id }}" {{ $penerbangan->id_bandara_tujuan == $bandara->id ? 'selected' : '' }}>
                                {{ $bandara->nama_bandara }} ({{ $bandara->kode_iata }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Waktu Berangkat</label>
                    <input type="datetime-local" name="waktu_berangkat" value="{{ $penerbangan->waktu_berangkat->format('Y-m-d\TH:i') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Waktu Datang</label>
                    <input type="datetime-local" name="waktu_datang" value="{{ $penerbangan->waktu_datang->format('Y-m-d\TH:i') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Harga Tiket (Rp)</label>
                    <input type="number" name="harga_dasar" value="{{ $penerbangan->harga_dasar }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Total Kursi</label>
                    <input type="number" name="sisa_kursi" value="{{ $penerbangan->sisa_kursi }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50">
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-50">
                <a href="{{ route('admin.penerbangan.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500">Batal</a>
                <button type="submit" class="px-10 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all">
                    Perbarui Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection