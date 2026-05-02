<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Kategori;

class MenuController extends Controller
{
    // =========================
    // FRONTEND (CUSTOMER)
    // =========================

    public function index()
    {
        $menu = Menu::with('kategori')
            ->where('status', 1)
            ->latest()
            ->get();

        $kategori = Kategori::all();

        return view('frontend.menu.index', compact('menu', 'kategori'));
    }

    public function detail($id)
    {
        $menu = Menu::with('kategori')->findOrFail($id);

        return view('frontend.menu.detail', compact('menu'));
    }


    // =========================
    // BACKEND (ADMIN)
    // =========================

    public function indexBackend()
    {
        $menu = Menu::with('kategori')->latest()->get();

        return view('backend.menu.index', [
            'judul' => 'Data Menu',
            'menu'  => $menu
        ]);
    }

    public function create()
    {
        $kategori = Kategori::all();

        return view('backend.menu.create', [
            'judul' => 'Tambah Menu',
            'kategori' => $kategori
        ]);
    }

    // =========================
    // STORE (UPLOAD GAMBAR)
    // =========================
    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => 'required',
            'nama_menu'   => 'required',
            'harga'       => 'required|numeric',
            'status'      => 'required',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // upload gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);

            $data['gambar'] = $filename;
        }

        Menu::create($data);

        return redirect()->route('backend.menu.index')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $kategori = Kategori::all();

        return view('backend.menu.edit', [
            'judul' => 'Edit Menu',
            'menu' => $menu,
            'kategori' => $kategori
        ]);
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $data = $request->validate([
            'kategori_id' => 'required',
            'nama_menu'   => 'required',
            'harga'       => 'required|numeric',
            'status'      => 'required',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // ganti gambar
        if ($request->hasFile('gambar')) {

            // hapus lama
            if ($menu->gambar && file_exists(public_path('images/' . $menu->gambar))) {
                unlink(public_path('images/' . $menu->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);

            $data['gambar'] = $filename;
        }

        $menu->update($data);

        return redirect()->route('backend.menu.index')
            ->with('success', 'Menu berhasil diupdate');
    }

    // =========================
    // DELETE
    // =========================
    public function delete($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->gambar && file_exists(public_path('images/' . $menu->gambar))) {
            unlink(public_path('images/' . $menu->gambar));
        }

        $menu->delete();

        return back()->with('success', 'Menu berhasil dihapus');
    }


    // =========================
    // KASIR (OPTIONAL)
    // =========================
    public function kasir()
    {
        $menu = Menu::where('status', 1)->get();

        return view('backend.kasir.index', [
            'judul' => 'Kasir',
            'menu'  => $menu
        ]);
    }
}