@extends('backend.v_layouts.app')

@section('content')

<h2>📊 Laporan Transaksi</h2>

<!-- FILTER -->
<form method="GET">
    Dari:
    <input type="date" name="dari" value="{{ $dari }}">

    Sampai:
    <input type="date" name="sampai" value="{{ $sampai }}">

    <button type="submit">Filter</button>
</form>

<hr>

<!-- RINGKASAN -->
<div style="display:flex; gap:20px;">
    <div class="card">
        <h3>Total Omzet</h3>
        <h2>Rp {{ number_format($totalOmzet,0,',','.') }}</h2>
    </div>

    <div class="card">
        <h3>Total Transaksi</h3>
        <h2>{{ $totalTransaksi }}</h2>
    </div>
</div>

<hr>

<!-- GRAFIK -->
<canvas id="chart" height="100"></canvas>

<hr>

<!-- TABEL -->
<table border="1" width="100%" cellpadding="10">
    <thead style="background:#f5f5f5;">
        <tr>
            <th>No</th>
            <th>Invoice</th>
            <th>Total</th>
            <th>Tanggal</th>
        </tr>
    </thead>

    <tbody>
        @foreach($transaksi as $t)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $t->invoice }}</td>
            <td>{{ $t->total_rupiah }}</td>
            <td>{{ $t->tanggal_format }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let labels = {!! json_encode($grafik->pluck('tanggal')) !!};
let data = {!! json_encode($grafik->pluck('total')) !!};

new Chart(document.getElementById('chart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Omzet Harian',
            data: data,
            fill: false,
            tension: 0.3
        }]
    }
});
</script>

@endsection