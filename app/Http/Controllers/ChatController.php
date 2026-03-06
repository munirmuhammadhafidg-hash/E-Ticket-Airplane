<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $messages = Pesan::where('user_id', Auth::id())->orderBy('created_at', 'asc')->get();
        return view('user.chat', compact('messages'));
    }

    public function adminIndex()
    {
        $users = User::whereHas('pesans')->with(['pesans' => fn($q) => $q->latest()])->get()
            ->sortByDesc(fn($u) => $u->pesans->first()->created_at);
        return view('admin.chat.index', compact('users'));
    }

    public function adminShow($id)
    {
        $user = User::findOrFail($id);
        $messages = Pesan::where('user_id', $id)->orderBy('created_at', 'asc')->get();
        return view('admin.chat.show', compact('user', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate(['pesan' => 'required']);

        Pesan::create([
            'user_id' => $request->user_id ?? Auth::id(),
            'pesan' => $request->pesan,
            'is_admin' => Auth::user()->role === 'admin'
        ]);

        return back();
    }
}
