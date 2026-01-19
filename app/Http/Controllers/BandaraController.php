<?php

namespace App\Http\Controllers;

use App\Models\Bandara;
use Illuminate\Http\Request;

class BandaraController extends Controller
{

    public function index()
    {
        $bandaras = Bandara::latest()->paginate(10);
        return view('admin.bandara.index', compact('bandaras'));
    }


    public function create()
    {
        return view('admin.bandara.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bandara' => 'required|string|max:255',
            'kota'         => 'required|string|max:255',
            'negara'       => 'required|string|max:255',
            'kode_iata'    => 'required|string|size:3|unique:bandaras',
        ]);

        Bandara::create($validated);

        return redirect()->route('admin.bandara.index')->with('success', 'Bandara berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $bandara = Bandara::findOrFail($id);
        return view('admin.bandara.edit', compact('bandara'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_bandara' => 'required',
            'kota'         => 'required',
            'negara'       => 'required',
            'kode_iata'    => 'required|size:3|unique:bandaras,kode_iata,' . $id,
        ]);

        $bandara = Bandara::findOrFail($id);
        $bandara->update($validated);

        return redirect()->route('admin.bandara.index')->with('success', 'Data diperbarui!');
    }

    public function destroy($id)
    {
        $bandara = Bandara::findOrFail($id);
        $bandara->delete();

        return redirect()->route('admin.bandara.index')->with('success', 'Bandara berhasil dihapus!');
    }
}
