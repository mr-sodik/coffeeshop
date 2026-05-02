<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class KasirController extends Controller
{
    // =========================
    // HALAMAN KASIR (POS)
    // =========================
    public function index()
    {
        $menu = Menu::where('status', 1)
            ->with('kategori')
            ->get();

        return view('kasir.index', compact('menu'));
    }

    // =========================
    // SIMPAN TRANSAKSI (REALTIME POS)
    // =========================
    public function simpanTransaksi(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'total'     => 'required|numeric',
            'bayar'     => 'required|numeric',
            'kembalian' => 'required|numeric',
            'items'     => 'required|array'
        ]);

        DB::beginTransaction();

        try {

            $transaksi = Transaksi::create([
                'user_id'   => Auth::id(),
                'invoice'   => 'INV-' . strtoupper(Str::random(6)),
                'total'     => $data['total'],
                'bayar'     => $data['bayar'],
                'kembalian' => $data['kembalian'],
                'diskon'    => $data['diskon'] ?? 0,
                'pajak'     => $data['pajak'] ?? 0,
                'metode'    => $data['metode'] ?? 'cash'
            ]);

            foreach ($data['items'] as $item) {

                $menu = Menu::find($item['id']);

                if (!$menu) {
                    throw new \Exception('Menu tidak ditemukan');
                }

                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id'      => $item['id'],
                    'qty'          => $item['qty'],
                    'harga'        => $item['harga']
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil',
                'invoice' => $transaksi->invoice,
                'id'      => $transaksi->id
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Gagal transaksi',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // =========================
    // RIWAYAT TRANSAKSI
    // =========================
    public function riwayat()
    {
        $transaksi = Transaksi::with('details.menu', 'user')
            ->latest()
            ->get();

        return view('backend.transaksi.index', compact('transaksi'));
    }

    // =========================
    // DETAIL TRANSAKSI
    // =========================
    public function detail($id)
    {
        $transaksi = Transaksi::with('details.menu', 'user')
            ->findOrFail($id);

        return view('backend.transaksi.detail', compact('transaksi'));
    }

    // =========================
    // CETAK PDF
    // =========================
    public function cetak($id)
    {
        $transaksi = Transaksi::with('details.menu')
            ->findOrFail($id);

        $pdf = Pdf::loadView('backend.transaksi.pdf', compact('transaksi'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('struk-' . $transaksi->invoice . '.pdf');
    }

    // =========================
    // LAPORAN + GRAFIK
    // =========================
    public function laporan(Request $request)
    {
        $dari = $request->dari ?? date('Y-m-01');
        $sampai = $request->sampai ?? date('Y-m-d');

        $transaksi = Transaksi::whereBetween('created_at', [$dari, $sampai])
            ->get();

        $totalOmzet = $transaksi->sum('total');
        $totalTransaksi = $transaksi->count();

        $grafik = Transaksi::selectRaw('DATE(created_at) as tanggal, SUM(total) as total')
            ->whereBetween('created_at', [$dari, $sampai])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->get();

        return view('backend.laporan.index', compact(
            'transaksi',
            'totalOmzet',
            'totalTransaksi',
            'grafik',
            'dari',
            'sampai'
        ));
    }
}