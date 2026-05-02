@extends('backend.v_layouts.app')

@section('content')

<h2>Edit Menu</h2>

<form action="{{ route('backend.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Kategori</label><br>
    <select name="kategori_id" required>
        @foreach($kategori as $k)
            <option value="{{ $k->id }}" {{ $menu->kategori_id == $k->id ? 'selected' : '' }}>
                {{ $k->nama_kategori }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Nama Menu</label><br>
    <input type="text" name="nama_menu" value="{{ $menu->nama_menu }}" required>
    <br><br>

    <label>Harga</label><br>
    <input type="number" name="harga" value="{{ $menu->harga }}" required>
    <br><br>

    <label>Gambar Baru (opsional)</label><br>
    <input type="file" name="gambar">
    <br><br>

    {{-- tampilkan gambar lama --}}
    @if($menu->gambar)
        <p>Gambar Saat Ini:</p>
        <img src="{{ asset('images/' . $menu->gambar) }}" width="120">
        <br><br>
    @endif

    <label>Status</label><br>
    <select name="status">
        <option value="1" {{ $menu->status == 1 ? 'selected' : '' }}>Publish</option>
        <option value="0" {{ $menu->status == 0 ? 'selected' : '' }}>Draft</option>
    </select>
    <br><br>

    <button type="submit">Update</button>

</form>

@endsection