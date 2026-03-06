@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 text-left">
        <div class="mb-4">
            <a href="{{ route('admin.chat.index') }}"
                class="text-indigo-600 hover:text-indigo-800 flex items-center gap-2 text-sm font-medium">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Chat
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col h-[600px]">
            <div class="p-4 border-b border-gray-100 flex items-center gap-3 bg-gray-50 rounded-t-2xl">
                <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr($user->nama, 0, 1)) }}
                </div>
                <div>
                    <h2 class="font-bold text-gray-900 leading-none text-sm">{{ $user->nama }}</h2>
                    <span class="text-[10px] text-green-500 font-medium italic">● Sedang Terhubung</span>
                </div>
            </div>

            <div id="chatBox" class="flex-1 overflow-y-auto p-4 space-y-4 bg-slate-50 flex flex-col">
                @foreach($messages as $m)
                        <div class="flex {{ $m->is_admin ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[75%] px-4 py-2 rounded-2xl shadow-sm 
                                        {{ $m->is_admin
                    ? 'bg-indigo-600 text-white rounded-tr-none'
                    : 'bg-white text-gray-800 rounded-tl-none border border-gray-100' 
                                        }}">
                                <p class="text-sm leading-relaxed">{{ $m->pesan }}</p>
                                <span class="text-[10px] block mt-1 {{ $m->is_admin ? 'text-indigo-200' : 'text-gray-400' }}">
                                    {{ $m->created_at->format('H:i') }}
                                </span>
                            </div>
                        </div>
                @endforeach
            </div>

            <div class="p-4 border-t border-gray-100 bg-white rounded-b-2xl">
                <form action="{{ route('user.chat.store') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="text" name="pesan" placeholder="Balas pesan user..."
                        class="flex-1 border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition-all outline-none"
                        required autocomplete="off">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-5 rounded-xl hover:bg-indigo-700 transition flex items-center justify-center shadow-md shadow-indigo-100 font-medium text-sm gap-2">
                        <i class="fas fa-paper-plane"></i> <span class="hidden md:block">Balas</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>
@endsection