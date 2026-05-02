<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use PDF;

class TransaksiController extends Controller
{
    // LIST TRANSAKSI
    public function index()
    {
        $transaksi = Transaksi::latest()->get();

        return view('backend.transaksi.index', compact('transaksi'));
    }

    // DETAIL TRANSAKSI
    public function show($id)
    {
        $transaksi = Transaksi::with('detail.menu')->findOrFail($id);

        return view('backend.transaksi.show', compact('transaksi'));
    }

    // RIWAYAT TRANSAKSI
    public function riwayat()
    {
        $transaksi = Transaksi::latest()->paginate(10);

        return view('backend.transaksi.riwayat', compact('transaksi'));
    }

    // EXPORT PDF
    public function pdf($id)
    {
        $transaksi = Transaksi::with('detail.menu')->findOrFail($id);

        $pdf = PDF::loadView('backend.transaksi.pdf', compact('transaksi'));

        return $pdf->download('transaksi-'.$transaksi->invoice.'.pdf');
    }
}