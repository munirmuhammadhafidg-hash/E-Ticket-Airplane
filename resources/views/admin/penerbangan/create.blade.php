@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
        <a href="{{ route('admin.penerbangan.index') }}" class="hover:text-indigo-600 transition">Manajemen Penerbangan</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-gray-800 font-medium">Tambah Jadwal</span>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-100/50 overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <h1 class="text-2xl font-bold text-gray-800">Detail Penerbangan Baru</h1>
            <p class="text-sm text-gray-500">Lengkapi informasi rute, waktu, dan harga tiket di bawah ini.</p>
        </div>

        <form action="{{ route('admin.penerbangan.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Maskapai</label>
                    <input type="text" name="maskapai" placeholder="Contoh: Garuda Indonesia" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Penerbangan</label>
                    <input type="text" name="nomor_penerbangan" placeholder="Contoh: GA-123" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50 uppercase">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-indigo-50/30 rounded-2xl border border-indigo-100/50">
                <div>
                    <label class="block text-sm font-bold text-indigo-900 mb-2">Bandara Asal</label>
                    <select name="id_bandara_asal" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none bg-white transition">
                        <option value="" disabled selected>Pilih Keberangkatan</option>
                        @foreach($bandaras as $bandara)
                            <option value="{{ $bandara->id }}">{{ $bandara->nama_bandara }} ({{ $bandara->kode_iata }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-indigo-900 mb-2">Bandara Tujuan</label>
                    <select name="id_bandara_tujuan" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none bg-white transition">
                        <option value="" disabled selected>Pilih Tujuan</option>
                        @foreach($bandaras as $bandara)
                            <option value="{{ $bandara->id }}">{{ $bandara->nama_bandara }} ({{ $bandara->kode_iata }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Waktu Berangkat</label>
                    <input type="datetime-local" name="waktu_berangkat" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Waktu Datang</label>
                    <input type="datetime-local" name="waktu_datang" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Harga Tiket (Rp)</label>
                    <input type="number" name="harga_dasar" placeholder="850000" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Total Kursi Tersedia</label>
                    <input type="number" name="sisa_kursi" placeholder="180" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50">
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-50">
                <a href="{{ route('admin.penerbangan.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 transition">Batal</a>
                <button type="submit" class="px-10 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all active:scale-95">
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection