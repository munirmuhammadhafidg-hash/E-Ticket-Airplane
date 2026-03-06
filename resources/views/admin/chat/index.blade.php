@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-left">
            <div class="p-6 border-b border-gray-100 bg-indigo-600">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-inbox"></i> Pesan Masuk Pelanggan
                </h2>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($users as $user)
                    <a href="{{ route('admin.chat.show', $user->id) }}" class="block p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-4 text-left">
                            <div
                                class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-lg">
                                {{ strtoupper(substr($user->nama, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-center mb-1">
                                    <h3 class="font-semibold text-gray-900 text-sm md:text-base">{{ $user->nama }}</h3>
                                    <span class="text-[10px] md:text-xs text-gray-400 italic">
                                        {{ $user->pesans->first() ? $user->pesans->first()->created_at->diffForHumans() : '' }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 truncate">
                                    @if($user->pesans->first() && $user->pesans->first()->is_admin)
                                        <span
                                            class="text-indigo-600 font-medium text-xs bg-indigo-50 px-1.5 py-0.5 rounded mr-1">Anda:</span>
                                    @endif
                                    {{ $user->pesans->first() ? $user->pesans->first()->pesan : 'Belum ada pesan' }}
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-300 text-sm"></i>
                        </div>
                    </a>
                @empty
                    <div class="p-10 text-center text-gray-400">
                        <i class="fas fa-comments fa-3x mb-3 opacity-20"></i>
                        <p>Belum ada pesan masuk dari pelanggan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection