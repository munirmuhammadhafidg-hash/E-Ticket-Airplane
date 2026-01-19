@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center">
    
    <div class="mb-8">
        <a href="{{ url('/') }}" class="flex items-center gap-2 text-indigo-600 font-bold text-3xl">
            <i class="fas fa-ticket-alt"></i> SkyTicket
        </a>
    </div>

    <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-2xl border border-gray-100">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold text-gray-800">Selamat Datang</h2>
            <p class="text-gray-500 mt-2">Silakan masuk ke akun Anda</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition" placeholder="admin@sky.com" required>
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                <input type="password" name="password" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none transition" placeholder="••••••••" required>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all">
                Masuk
            </button>
        </form>

        <p class="text-center mt-8 text-sm text-gray-500">
            Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:underline">Daftar sekarang</a>
        </p>
    </div>
    
    <a href="{{ url('/') }}" class="mt-8 text-gray-400 hover:text-gray-600 text-sm transition">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
    </a>
</div>
@endsection