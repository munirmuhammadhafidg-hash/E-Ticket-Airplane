<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Penerbangan;
use Illuminate\Support\Str;
use App\Models\DetailTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PemesananController extends Controller
{
    /**
     * Menampilkan daftar pemesanan (Monitoring Admin)
     */
    public function index(Request $request)
    {
        $query = Pemesanan::with(['details.penerbangan.bandaraAsal', 'details.penerbangan.bandaraTujuan']);

        if (!auth()->user()->can('access-admin')) {
            $query->where('id_pengguna', auth()->id());
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('kode_pemesanan', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status != '' && $request->status != 'Semua Status Bayar') {
            $query->where('status_pembayaran', $request->status);
        }

        $pemesanans = $query->latest()->paginate(10);

        $view = auth()->user()->can('access-admin') ? 'admin.pemesanan.index' : 'user.riwayat';
        return view($view, compact('pemesanans'));
    }

    /**
     * Form Checkout (Akses User)
     */
    public function create(Request $request)
    {
        $id_penerbangan = $request->id;
        $requestedPassengers = $request->penumpang ?? 1;

        $flight = Penerbangan::with(['bandaraAsal', 'bandaraTujuan'])->findOrFail($id_penerbangan);

        $bookedSeats = DetailTicket::where('id_penerbangan', $id_penerbangan)
            ->pluck('nomor_kursi')
            ->toArray();

        return view('user.pemesanan', compact('flight', 'requestedPassengers', 'bookedSeats'));
    }

    /**
     * Logika Simpan Transaksi (Mendukung Banyak Penumpang)
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'id_penerbangan'    => 'required|exists:penerbangans,id',
            'nama'              => 'required|array|min:1',
            'nama.*'            => 'required|string|max:255',
            'nik'               => 'required|array',
            'nik.*'             => 'required|string|size:16', 
            'email'             => 'required|array',
            'nomor_telepon'     => 'required|array', 
            'nomor_telepon.*'   => 'required|string|max:15',
            'nomor_kursi'       => 'required|string',
        ]);

        return DB::transaction(function () use ($request) {
            
            $penerbangan = Penerbangan::lockForUpdate()->findOrFail($request->id_penerbangan);

            $seatsArray = explode(',', $request->nomor_kursi);
            $jumlahOrder = count($request->nama);

            if ($penerbangan->sisa_kursi < $jumlahOrder) {
                return redirect()->back()->with('error', 'Maaf, sisa kursi tidak mencukupi.');
            }

            $totalBiaya = ($penerbangan->harga_dasar + 50000) * $jumlahOrder;

            $pemesanan = Pemesanan::create([
                'id_pengguna'       => auth()->id(),
                'kode_pemesanan'    => 'TIX-' . strtoupper(Str::random(8)),
                'total_biaya'       => $totalBiaya,
                'status_pembayaran' => 'Pending',
                'status_pemesanan'  => 'Aktif',
                'waktu_pemesanan'   => now(),
            ]);

            foreach ($request->nama as $key => $namaPenumpang) {
                DetailTicket::create([
                    'id_pemesanan'    => $pemesanan->id,
                    'id_penerbangan'  => $penerbangan->id,
                    'nama_penumpang'  => $namaPenumpang,
                    'nik'             => $request->nik[$key], 
                    'nomor_telepon'   => $request->nomor_telepon[$key], 
                    'nomor_kursi'     => trim($seatsArray[$key] ?? '?'),
                    'tipe_kelas'      => 'ekonomi',
                    'harga_beli'      => $penerbangan->harga_dasar,
                ]);
            }

            $penerbangan->decrement('sisa_kursi', $jumlahOrder);

            return redirect()->route('user.pemesanan.index')->with('success', 'Pemesanan berhasil dibuat!');
        });
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:Pending,Lunas,Dibatalkan'
        ]);

        $pemesanan = Pemesanan::with('details')->findOrFail($id);

        if ($request->status_pembayaran == 'Lunas' && !$pemesanan->bukti_pembayaran) {
            return redirect()->back()->with('error', 'Gagal: Bukti pembayaran belum diunggah oleh penumpang.');
        }

        if ($request->status_pembayaran == 'Dibatalkan' && $pemesanan->status_pembayaran != 'Dibatalkan') {
            $jumlahKursi = $pemesanan->details->count();
            $firstDetail = $pemesanan->details->first();

            if ($firstDetail) {
                Penerbangan::where('id', $firstDetail->id_penerbangan)
                    ->increment('sisa_kursi', $jumlahKursi);
            }
        }

        $pemesanan->update([
            'status_pembayaran' => $request->status_pembayaran
        ]);

        return redirect()->back()->with('success', 'Status transaksi ' . $pemesanan->kode_pemesanan . ' berhasil diperbarui.');
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pemesanan = Pemesanan::where('id', $id)
            ->where('id_pengguna', auth()->id())
            ->firstOrFail();

        if ($request->hasFile('bukti_pembayaran')) {
        
            if ($pemesanan->bukti_pembayaran) {
                Storage::delete('public/' . $pemesanan->bukti_pembayaran);
            }

            $path = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');
            $pemesanan->update(['bukti_pembayaran' => $path]);

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah gambar.');
    }

    /**
     * Menghapus Pemesanan
     */
    public function destroy($id)
    {
        $pemesanan = Pemesanan::with('details')->findOrFail($id);

        if ($pemesanan->status_pembayaran != 'Dibatalkan') {
            $jumlahKursi = $pemesanan->details->count();
            $idPenerbangan = $pemesanan->details->first()->id_penerbangan;

            Penerbangan::where('id', $idPenerbangan)->increment('sisa_kursi', $jumlahKursi);
        }

        $pemesanan->delete();
        return redirect()->back()->with('success', 'Data pemesanan berhasil dihapus.');
    }

    public function downloadPdf($id)
    {
        // 1. Ambil data pemesanan berdasarkan ID
        $order = Pemesanan::with(['details.penerbangan.bandaraAsal', 'details.penerbangan.bandaraTujuan'])
            ->findOrFail($id);

        // 2. Keamanan: Gunakan 'id_pengguna' sesuai dengan struktur tabel Anda
        // Tambahkan pengecekan agar Admin tetap bisa download (opsional)
        if ($order->id_pengguna !== auth()->id() && !auth()->user()->can('access-admin')) {
            abort(403, 'Anda tidak memiliki akses ke tiket ini.');
        }

        // 3. Siapkan data untuk tampilan PDF
        $data = [
            'order' => $order,
            'title' => 'E-Tiket ' . $order->kode_pemesanan
        ];

        // Import class PDF di bagian paling atas jika belum: use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('user.pdf_invoice', $data);

        // 4. Tampilkan di browser
        return $pdf->stream('Tiket-' . $order->kode_pemesanan . '.pdf');
    }
}
