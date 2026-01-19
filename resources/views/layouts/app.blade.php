<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>
<body x-data="{ mobileMenu: false }">

    @if(!Route::is('login') && !Route::is('register'))
<nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
    <div class="container mx-auto px-4 md:px-8">
        <div class="flex justify-between items-center h-20">
            <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200 group-hover:scale-110 transition-transform">
                    <i class="fas fa-plane-departure"></i>
                </div>
                <span class="text-gray-900 font-bold text-xl tracking-tight">Sky<span class="text-indigo-600">Ticket</span></span>
            </a>

            <div class="hidden md:flex items-center gap-1">
                @auth
                    @if(auth()->user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ Route::is('admin.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }} transition-all">Dashboard</a>
                        <a href="{{ route('admin.penerbangan.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-indigo-600 transition-all">Penerbangan</a>
                        <a href="{{ route('admin.bandara.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-indigo-600 transition-all">Bandara</a>
                        <a href="{{ route('admin.pemesanan.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-indigo-600 transition-all">Pemesanan</a>
                    @else
                        <a href="{{ url('/') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ Request::is('/') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }} transition-all">Home</a>
                        <a href="{{ route('user.riwayat') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ Route::is('user.riwayat') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }} transition-all">Riwayat Pesanan</a>
                    @endif
                @endauth
            </div>

            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-indigo-600 px-4 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold bg-indigo-600 text-white px-6 py-2.5 rounded-full hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-100 transition-all">Daftar</a>
                @endguest

                @auth
                    <div class="h-8 w-[1px] bg-gray-200 mx-2 hidden md:block"></div>
                    <div class="flex items-center gap-3 pl-2">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs text-gray-400 leading-none mb-1">Selamat datang,</p>
                            <p class="text-sm font-bold text-gray-800 leading-none">{{ auth()->user()->nama }}</p>
                        </div>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white font-bold border-2 border-white shadow-md">
                                {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                            </button>
                            
                            <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-[60]">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                        <i class="fas fa-sign-out-alt"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth

                <button @click="mobileMenu = !mobileMenu" class="md:hidden w-10 h-10 flex items-center justify-center text-gray-600">
                    <i class="fas" :class="mobileMenu ? 'fa-times' : 'fa-bars'"></i>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileMenu" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="md:hidden bg-white border-b border-gray-100 pb-4 px-4">
        <div class="flex flex-col gap-2">
            @auth
                @if(auth()->user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="p-3 rounded-lg hover:bg-gray-50">Dashboard</a>
                    <a href="{{ route('admin.penerbangan.index') }}" class="p-3 rounded-lg hover:bg-gray-50">Penerbangan</a>
                @else
                    <a href="{{ url('/') }}" class="p-3 rounded-lg hover:bg-gray-50 font-bold text-indigo-600">Home</a>
                    <a href="{{ route('user.riwayat') }}" class="p-3 rounded-lg hover:bg-gray-50">Riwayat Pesanan</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="p-3 rounded-lg hover:bg-gray-50">Masuk</a>
                <a href="{{ route('register') }}" class="m-2 p-3 rounded-lg bg-indigo-600 text-white text-center">Daftar Sekarang</a>
            @endauth
        </div>
    </div>
</nav>
@endif

    <main class="{{ Route::is('login') || Route::is('register') ? '' : 'py-8' }}">
        <div class="container mx-auto px-4 md:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>