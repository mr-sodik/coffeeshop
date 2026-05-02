@extends('backend.v_layouts.app')

@section('content')

<h2>Dashboard</h2>

<div style="display:grid; grid-template-columns: repeat(4,1fr); gap:20px; margin-top:20px;">

    <!-- TOTAL MENU -->
    <div style="background:#4e73df; color:white; padding:20px; border-radius:10px;">
        <h3>{{ $totalMenu }}</h3>
        <p>Total Menu</p>
    </div>

    <!-- TOTAL KATEGORI -->
    <div style="background:#1cc88a; color:white; padding:20px; border-radius:10px;">
        <h3>{{ $totalKategori }}</h3>
        <p>Total Kategori</p>
    </div>

    <!-- MENU PUBLISH -->
    <div style="background:#36b9cc; color:white; padding:20px; border-radius:10px;">
        <h3>{{ $menuPublish }}</h3>
        <p>Menu Publish</p>
    </div>

    <!-- MENU DRAFT -->
    <div style="background:#f6c23e; color:white; padding:20px; border-radius:10px;">
        <h3>{{ $menuDraft }}</h3>
        <p>Menu Draft</p>
    </div>

</div>

@endsection