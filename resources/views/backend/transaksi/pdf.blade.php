<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk</title>

    <style>
        body { font-family: Arial; font-size: 12px; }
        .center { text-align:center; }
        .line { border-top:1px dashed #000; margin:10px 0; }
        table { width:100%; }
        .right { text-align:right; }
    </style>
</head>
<body>

<div class="center">
    <h3>☕ Coffee Shop</h3>
    <p>Struk Pembayaran</p>
</div>

<div class="line"></div>

<p>Invoice: <b>{{ $transaksi->invoice }}</b></p>
<p>Tanggal: {{ $transaksi->tanggal_format }}</p>

<div class="line"></div>

<table>
@foreach($transaksi->details as $d)
<tr>
    <td>{{ $d->menu->nama_menu }} x{{ $d->qty }}</td>
    <td class="right">{{ $d->subtotal_rupiah }}</td>
</tr>
@endforeach
</table>

<div class="line"></div>

<table>
<tr>
    <td>Total</td>
    <td class="right">{{ $transaksi->total_rupiah }}</td>
</tr>
<tr>
    <td>Bayar</td>
    <td class="right">{{ $transaksi->bayar_rupiah }}</td>
</tr>
<tr>
    <td>Kembalian</td>
    <td class="right">{{ $transaksi->kembalian_rupiah }}</td>
</tr>
</table>

<div class="line"></div>

<div class="center">
    <p>Terima kasih 🙏</p>
</div>

</body>
</html>