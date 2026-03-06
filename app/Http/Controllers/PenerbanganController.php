<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Penerbangan;
use App\Models\Bandara;
use Illuminate\Http\Request;

class PenerbanganController extends Controller
{
    public function index()
    {
        $penerbangan = Penerbangan::with(['bandaraAsal', 'bandaraTujuan'])
            ->where('waktu_berangkat', '>=', now()) // Hanya tampilkan yang belum berangkat
            ->orderBy('waktu_berangkat', 'asc')
            ->paginate(15);

        return view('admin.penerbangan.index', compact('penerbangan'));
    }
    public function create()
    {
        $bandaras = \App\Models\Bandara::all();
        return view('admin.penerbangan.create', compact('bandaras'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'maskapai' => 'required|string|max:255',
            'nomor_penerbangan' => 'required|string|unique:penerbangans',
            'id_bandara_asal' => 'required|exists:bandaras,id',
            'id_bandara_tujuan' => 'required|exists:bandaras,id|different:id_bandara_asal',
            'waktu_berangkat' => 'required|date',
            'waktu_datang' => 'required|date|after:waktu_berangkat',
            'harga_dasar' => 'required|numeric|min:0',
            'sisa_kursi' => 'required|integer|min:0',
        ]);

        Penerbangan::create($request->all());

        return redirect()->route('admin.penerbangan.index')->with('success', 'Jadwal penerbangan berhasil ditambahkan!');
    }

    public function edit(Penerbangan $penerbangan)
    {
        $bandaras = Bandara::all();
        return view('admin.penerbangan.edit', compact('penerbangan', 'bandaras'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'maskapai' => 'required',
            'nomor_penerbangan' => 'required|unique:penerbangans,nomor_penerbangan,' . $id,
            'id_bandara_asal' => 'required',
            'id_bandara_tujuan' => 'required|different:id_bandara_asal',
            'waktu_berangkat' => 'required',
            'waktu_datang' => 'required|after:waktu_berangkat',
            'harga_dasar' => 'required|numeric',
            'sisa_kursi' => 'required|integer',
        ]);

        $penerbangan = Penerbangan::findOrFail($id);
        $penerbangan->update($request->all());

        return redirect()->route('admin.penerbangan.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy(Penerbangan $penerbangan)
    {
        $penerbangan->delete();
        return redirect()->route('admin.penerbangan.index')->with('success', 'Penerbangan berhasil dihapus.');
    }

    public function search(Request $request)
    {
        // Mengambil input dari URL
        $asal = $request->input('search');   // Isinya "bali"
        $tujuan = $request->input('tujuan'); // Isinya "surabaya"
        $tanggal = $request->input('tanggal');

        $query = Penerbangan::with(['bandaraAsal', 'bandaraTujuan']);

        // Filter ASAL
        if ($asal) {
            $query->whereHas('bandaraAsal', function ($q) use ($asal) {
                $q->where(function ($sub) use ($asal) {
                    $sub->where('kota', '=', $asal)
                        ->orWhere('kode_iata', 'LIKE', "%$asal%")
                        ->orWhere('nama_bandara', 'LIKE', "%$asal%")
                        ->orWhere('negara', 'LIKE', "%$asal%"); // Tambahan jika user ketik nama negara
                });
            });
        }

        // Filter TUJUAN
        if ($tujuan) {
            $query->whereHas('bandaraTujuan', function ($q) use ($tujuan) {
                $q->where(function ($sub) use ($tujuan) {
                    $sub->where('kota', '=', $tujuan)
                        ->orWhere('kode_iata', 'LIKE', "%$tujuan%")
                        ->orWhere('nama_bandara', 'LIKE', "%$tujuan%");
                });
            });
        }

        // Filter TANGGAL
        if ($tanggal) {
            $query->whereDate('waktu_berangkat', $tanggal);
        }

        $query->where('sisa_kursi', '>', 0);

        $results = $query->orderBy('waktu_berangkat', 'asc')->get();

        return view('user.pencarian', compact('results', 'asal', 'tujuan', 'tanggal'));
    }
}
