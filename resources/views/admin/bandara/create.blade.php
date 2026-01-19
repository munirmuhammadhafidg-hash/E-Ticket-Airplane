@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Registrasi Bandara Baru</h1>
        <p class="text-gray-500 text-sm mb-8">Tambahkan titik lokasi keberangkatan atau tujuan baru ke sistem.</p>

        <form action="{{ route('admin.bandara.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Bandara</label>
                <input type="text" name="nama_bandara" placeholder="Contoh: Juanda International" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kota</label>
                    <input type="text" name="kota" placeholder="Surabaya" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Negara</label>
                    <input type="text" name="negara" placeholder="Indonesia" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Kode IATA (3 Huruf)</label>
                <input type="text" name="kode_iata" placeholder="SUB" maxlength="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition bg-gray-50/50 uppercase font-mono tracking-widest" required>
                <p class="mt-2 text-[10px] text-gray-400 uppercase font-bold">Pastikan kode sesuai dengan standar penerbangan internasional.</p>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="flex-1 bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all">
                    Simpan Bandara
                </button>
                <a href="{{ route('admin.bandara.index') }}" class="px-6 py-3 border border-gray-200 text-gray-500 font-bold rounded-xl hover:bg-gray-50 transition text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection