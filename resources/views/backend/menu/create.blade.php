@extends('backend.v_layouts.app')

@section('content')

<h2>Tambah Menu</h2>

<form action="{{ route('backend.menu.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- ================= KATEGORI ================= --}}
    <label>Kategori Menu</label><br>

    <select name="kategori_id" required>
        <option value="">-- Pilih Kategori --</option>

        {{-- MINUMAN --}}
        <optgroup label="Minuman">
            @foreach($kategori->whereIn('nama_kategori', ['Coffee','Non Coffee']) as $k)
                <option value="{{ $k->id }}">
                    {{ $k->nama_kategori }}
                </option>
            @endforeach
        </optgroup>

        {{-- MAKANAN --}}
        <optgroup label="Makanan">
            @foreach($kategori->where('nama_kategori', 'Snack') as $k)
                <option value="{{ $k->id }}">
                    {{ $k->nama_kategori }}
                </option>
            @endforeach
        </optgroup>

    </select>

    <br><br>

    {{-- ================= NAMA MENU ================= --}}
    <label>Nama Menu</label><br>
    <input type="text" name="nama_menu" required>

    <br><br>

    {{-- ================= HARGA ================= --}}
    <label>Harga</label><br>
    <input type="number" name="harga" required>

    <br><br>

    {{-- ================= GAMBAR ================= --}}
    <label>Gambar</label><br>
    <input type="file" name="gambar">

    <br><br>

    {{-- ================= STATUS ================= --}}
    <label>Status</label><br>
    <select name="status">
        <option value="1">Publish</option>
        <option value="0">Draft</option>
    </select>

    <br><br>

    <button type="submit">Simpan Menu</button>

</form>

@endsection