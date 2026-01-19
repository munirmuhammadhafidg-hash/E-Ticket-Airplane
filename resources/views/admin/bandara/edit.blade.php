@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-2">
        <a href="{{ route('admin.bandara.index') }}" class="hover:text-indigo-600 transition">Manajemen Bandara</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-gray-800 font-medium">Edit Bandara</span>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-8">
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Ubah Data Bandara</h1>
                <p class="text-gray-500 text-sm">Pastikan informasi kode IATA tetap akurat.</p>
            </div>
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                <i class="fas fa-building text-xl"></i>
            </div>
        </div>

        <form action="{{ route('admin.bandara.update', $bandara->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Bandara</label>
                <input type="text" name="nama_bandara" value="{{ old('nama_bandara', $bandara->nama_bandara) }}" 
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kota</label>
                    <input type="text" name="kota" value="{{ old('kota', $bandara->kota) }}" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Negara</label>
                    <input type="text" name="negara" value="{{ old('negara', $bandara->negara) }}" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Kode IATA (3 Huruf)</label>
                <input type="text" name="kode_iata" value="{{ old('kode_iata', $bandara->kode_iata) }}" maxlength="3" 
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50 uppercase font-mono tracking-widest" required>
            </div>

            <div class="pt-6 flex gap-3">
                <button type="submit" class="flex-1 bg-indigo-600 text-white py-4 rounded-2xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all hover:-translate-y-1 active:scale-95">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.bandara.index') }}" class="px-8 py-4 border border-gray-200 text-gray-500 font-bold rounded-2xl hover:bg-gray-50 transition text-center text-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection