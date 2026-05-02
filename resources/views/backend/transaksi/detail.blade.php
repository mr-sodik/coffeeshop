@extends('backend.v_layouts.app')

@section('content')

<h2>🧾 Detail Transaksi</h2>

<div style="margin-bottom:20px;">
    <p>Invoice: <b>{{ $transaksi->invoice }}</b></p>
    <p>Total: <b>{{ $transaksi->total_rupiah }}</b></p>
    <p>Bayar: <b>{{ $transaksi->bayar_rupiah }}</b></p>
    <p>Kembalian: <b>{{ $transaksi->kembalian_rupiah }}</b></p>
    <p>Tanggal: <b>{{ $transaksi->tanggal_format }}</b></p>
</div>

<hr>

<table border="1" width="100%" cellpadding="10">
    <thead style="background:#f5f5f5;">
        <tr>
            <th>Menu</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>
    </thead>

    <tbody>
        @forelse($transaksi->details as $d)
        <tr>
            <td>{{ $d->menu->nama_menu ?? '-' }}</td>
            <td>{{ $d->qty }}</td>
            <td>{{ $d->harga_rupiah }}</td>
            <td>{{ $d->subtotal_rupiah }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" align="center">Tidak ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>

<br>

<a href="{{ route('backend.transaksi.pdf', $transaksi->id) }}">
    <button>🧾 Download PDF</button>
</a>

@endsection