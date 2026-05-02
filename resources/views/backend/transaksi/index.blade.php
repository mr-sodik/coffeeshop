@extends('backend.v_layouts.app')

@section('content')

<h2>📊 Riwayat Transaksi</h2>

<table border="1" width="100%" cellpadding="10">
    <thead style="background:#f5f5f5;">
        <tr>
            <th>No</th>
            <th>Invoice</th>
            <th>Total</th>
            <th>Bayar</th>
            <th>Kembalian</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($transaksi as $t)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td><b>{{ $t->invoice }}</b></td>
            <td>{{ $t->total_rupiah }}</td>
            <td>{{ $t->bayar_rupiah }}</td>
            <td>{{ $t->kembalian_rupiah }}</td>
            <td>{{ $t->tanggal_format }}</td>
            <td>
                <a href="{{ route('backend.transaksi.detail', $t->id) }}">Detail</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" align="center">Belum ada transaksi</td>
        </tr>
        @endforelse
    </tbody>

</table>

@endsection