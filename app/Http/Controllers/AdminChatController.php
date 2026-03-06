<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pesan;
use Illuminate\Http\Request;

class AdminChatController extends Controller
{
    // Menampilkan daftar user yang pernah mengirim chat
    public function adminIndex()
    {
        // Mengambil user yang memiliki pesan, diurutkan dari pesan terbaru
        $users = User::whereHas('pesans')
            ->with(['pesans' => function ($q) {
                $q->latest();
            }])
            ->get()
            ->sortByDesc(function ($user) {
                return $user->pesans->first()->created_at;
            });

        return view('admin.chat.index', compact('users'));
    }

    // Menampilkan percakapan dengan user tertentu
    public function adminShow($id)
    {
        $user = User::findOrFail($id);
        $messages = Pesan::where('user_id', $id)->orderBy('created_at', 'asc')->get();

        // (Opsional) Tandai pesan sebagai terbaca di sini jika Anda punya kolom is_read

        return view('admin.chat.show', compact('user', 'messages'));
    }
}
