@extends('backend.v_layouts.app')

@section('content')

<h2>Data Menu</h2>

<a href="{{ route('backend.menu.create') }}">+ Tambah Menu</a>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach ($menu as $m)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $m->nama_menu }}</td>
        <td>{{ $m->kategori->nama_kategori }}</td>
        <td>{{ $m->harga }}</td>
        <td>{{ $m->status }}</td>
        <td>
            <a href="{{ route('backend.menu.edit', $m->id) }}">Edit</a> |
            <a href="{{ route('backend.menu.delete', $m->id) }}">Hapus</a>
        </td>
    </tr>
    @endforeach

</table>

@endsection