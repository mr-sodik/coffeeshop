<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    // =========================
    // FRONTEND / REDIRECT ROLE
    // =========================
    public function index()
    {
        // kalau sudah login → arahkan sesuai role
        if (Auth::check()) {

            if (Auth::user()->role == 'admin') {
                return redirect()->route('backend.beranda');
            }

            if (Auth::user()->role == 'kasir') {
                return redirect()->route('kasir.index');
            }
        }

        // =========================
        // CUSTOMER (BELUM LOGIN / CUSTOMER)
        // =========================
        $menu = Menu::with('kategori')
            ->where('status', 1)
            ->latest()
            ->get();

        $kategori = Kategori::all();

        return view('frontend.beranda.beranda', [
            'judul' => 'Beranda',
            'menu' => $menu,
            'kategori' => $kategori
        ]);
    }


    // =========================
    // BACKEND (ADMIN DASHBOARD)
    // =========================
    public function berandaBackend()
    {
        // proteksi tambahan (optional tapi bagus)
        if (Auth::user()->role != 'admin') {
            abort(403, 'Akses ditolak');
        }

        $totalMenu = Menu::count();
        $totalKategori = Kategori::count();
        $menuPublish = Menu::where('status', 1)->count();
        $menuDraft = Menu::where('status', 0)->count();

        return view('backend.beranda.index', [
            'judul' => 'Dashboard',
            'totalMenu' => $totalMenu,
            'totalKategori' => $totalKategori,
            'menuPublish' => $menuPublish,
            'menuDraft' => $menuDraft
        ]);
    }
}