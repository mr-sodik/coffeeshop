<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;

class LaporanController extends Controller
{
    public function index()
    {
        $total = Transaksi::sum('total');
        $jumlah = Transaksi::count();

        return view('backend.laporan.index', compact('total','jumlah'));
    }
}