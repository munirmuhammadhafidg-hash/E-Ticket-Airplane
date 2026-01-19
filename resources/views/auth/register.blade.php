@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[80vh] py-10">
    <div class="w-full max-w-lg bg-white p-8 md:p-10 rounded-3xl shadow-xl border border-gray-100">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl mb-4">
                <i class="fas fa-user-plus text-2xl"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Buat Akun Baru</h2>
            <p class="text-gray-500 mt-2 font-medium">Bergabunglah dengan SkyTicket dan mulai petualangan Anda</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                        placeholder="John Doe" required>
                    @error('nama') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon') }}" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                        placeholder="0812xxxx">
                    @error('nomor_telepon') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                    placeholder="email@contoh.com" required>
                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                    <input type="password" name="password" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                        placeholder="••••••••" required>
                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Sandi</label>
                    <input type="password" name="password_confirmation" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                        placeholder="••••••••" required>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-bold hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all hover:-translate-y-1 active:scale-95">
                    Daftar Sekarang
                </button>
            </div>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-600 font-medium">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:text-indigo-800 transition">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection