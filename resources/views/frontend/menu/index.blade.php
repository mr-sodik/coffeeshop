@extends('frontend.layouts.app')

@section('content')

<style>
.title {
    text-align:center;
    margin:40px 0;
    font-size:30px;
    font-weight:bold;
}

/* FILTER */
.filter {
    text-align:center;
    margin-bottom:30px;
}

.filter button {
    border:none;
    padding:8px 18px;
    margin:5px;
    border-radius:20px;
    background:#f1f1f1;
    cursor:pointer;
    transition:0.3s;
}

.filter button.active,
.filter button:hover {
    background:black;
    color:white;
}

/* GRID */
.menu-grid {
    display:grid;
    grid-template-columns: repeat(auto-fill, minmax(220px,1fr));
    gap:20px;
}

/* CARD */
.card {
    background:white;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 4px 10px rgba(0,0,0,0.05);
    transition:0.3s;
    cursor:pointer;
}

.card:hover {
    transform:translateY(-5px);
}

.card img {
    width:100%;
    height:200px;
    object-fit:cover;
}

.card-body {
    padding:15px;
}

.card-body h4 {
    margin:0;
}

.card-body p {
    margin:5px 0;
    color:#777;
}

.price {
    color:#8B5E3C;
    font-weight:bold;
}
</style>

<div class="container" id="menuSection">

    <div class="title">☕ Menu 404 CAFE</div>

    <!-- FILTER -->
    <div class="filter">
        <button class="active" onclick="filterMenu('all', event)">All</button>

        @foreach($kategori as $k)
        <button onclick="filterMenu('{{ $k->id }}', event)">
            {{ $k->nama_kategori }}
        </button>
        @endforeach
    </div>

    <!-- MENU -->
    <div class="menu-grid" id="menuList">

        @foreach($menu as $m)
        <div class="card"
             data-kategori="{{ $m->kategori_id }}"
             onclick="window.location='{{ route('menu.detail',$m->id) }}'">

            <img src="{{ $m->gambar ? asset('images/'.$m->gambar) : 'https://via.placeholder.com/300' }}">

            <div class="card-body">
                <h4>{{ $m->nama_menu }}</h4>

                <p>{{ $m->kategori->nama_kategori ?? 'Tanpa Kategori' }}</p>

                <div class="price">
                    Rp {{ number_format($m->harga,0,',','.') }}
                </div>

                <!-- OPTIONAL ADD TO CART -->
                <button onclick="event.stopPropagation(); addToCart({{ $m->id }}, '{{ $m->nama_menu }}', {{ $m->harga }})"
                        style="margin-top:10px; padding:6px 12px; border:none; background:#8B5E3C; color:white; border-radius:6px;">
                    + Keranjang
                </button>

            </div>

        </div>
        @endforeach

    </div>

</div>

<script>
function filterMenu(kategori, event){

    let items = document.querySelectorAll('.card');

    items.forEach(item=>{
        if(kategori === 'all'){
            item.style.display = 'block';
        } else {
            item.style.display =
                item.dataset.kategori == kategori ? 'block' : 'none';
        }
    });

    document.querySelectorAll('.filter button').forEach(btn=>{
        btn.classList.remove('active');
    });

    event.target.classList.add('active');
}
</script>

@endsection