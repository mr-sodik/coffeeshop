@extends('frontend.layouts.app')

@section('content')

<style>
.detail-container {
    text-align: center;
    padding: 50px 20px;
}

.detail-img {
    width: 250px;
    border-radius: 15px;
    margin-bottom: 20px;
}

.formula {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 25px;
    margin-top: 30px;
    flex-wrap: wrap;
}

.formula img {
    width: 90px;
}

.price {
    font-size: 24px;
    font-weight: bold;
    color: #8B5E3C;
    margin-top: 20px;
}

.desc {
    max-width: 400px;
    margin: 20px auto;
    color: #666;
    line-height: 1.6;
}

.btn-cart {
    padding: 12px 25px;
    background: black;
    color: white;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    margin-top: 20px;
}
</style>

@php
    // =========================
    // LOGIKA GAMBAR FORMULA
    // =========================
    $base = 'espresso.png';
    $mix = 'milk.png';

    if(strtolower($menu->kategori->nama_kategori ?? '') == 'non coffee'){
        $base = 'tea.png';
        $mix = 'lemon.png';
    }
@endphp

<div class="detail-container">

    <!-- =========================
    GAMBAR UTAMA (C)
    ========================== -->
    <img class="detail-img"
         src="{{ $menu->gambar ? asset('images/'.$menu->gambar) : 'https://via.placeholder.com/300' }}">

    <h1>{{ strtoupper($menu->nama_menu) }}</h1>

    <!-- =========================
    FORMULA A + B = C
    ========================== -->
    <div class="formula">

        <!-- BASE -->
        <div>
            <img src="{{ asset('images/'.$base) }}">
            <p>Base</p>
        </div>

        <h2>+</h2>

        <!-- MIX -->
        <div>
            <img src="{{ asset('images/'.$mix) }}">
            <p>Mix</p>
        </div>

        <h2>=</h2>

        <!-- RESULT -->
        <div>
            <img src="{{ $menu->gambar ? asset('images/'.$menu->gambar) : 'https://via.placeholder.com/100' }}">
            <p>{{ $menu->nama_menu }}</p>
        </div>

    </div>

    <!-- =========================
    HARGA
    ========================== -->
    <div class="price">
        Rp {{ number_format($menu->harga, 0, ',', '.') }}
    </div>

    <!-- =========================
    DESKRIPSI
    ========================== -->
    <div class="desc">
        {{ $menu->deskripsi ?? 'A crafted beverage designed with precision, balance, and character.' }}
    </div>

    <!-- =========================
    BUTTON CART
    ========================== -->
    <button class="btn-cart"
        onclick="addToCart('{{ $menu->id }}','{{ $menu->nama_menu }}','{{ $menu->harga }}')">
        + Tambah ke Keranjang
    </button>

</div>

@endsection