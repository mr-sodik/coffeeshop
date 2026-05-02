@extends('frontend.layouts.app')

@section('content')

<style>
.container {
    width: 92%;
    max-width: 1200px;
    margin: auto;
}

/* TITLE */
.title {
    text-align: center;
    margin: 50px 0 30px;
    font-size: 32px;
    font-weight: 600;
}

/* KATEGORI */
.kategori {
    text-align: center;
    margin-bottom: 40px;
}

.kategori button {
    border: none;
    background: #f1f1f1;
    padding: 10px 22px;
    margin: 5px;
    cursor: pointer;
    border-radius: 999px;
}

.kategori button.active {
    background: black;
    color: rgb(255, 255, 255);
}

/* GRID */
.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
    gap: 25px;
}

/* CARD */
.card-menu {
    background: white;(239, 239, 242);
    border-radius: 14px;
    overflow: hidden;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.card-menu:hover {
    transform: translateY(-6px);
}

.card-menu img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card-body {
    padding: 16px;
}

.price {
    font-weight: bold;
}

/* CART */
#cartSidebar {
    position:fixed;
    right:0;
    top:0;
    width:350px;
    height:100%;
    background:white;
    padding:20px;
    display:none;
    box-shadow:-5px 0 15px rgba(0,0,0,0.1);
    z-index:1000;
}

/* MODAL */
#modalMenu {
    display:none;
    position:fixed;
    top:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
}
</style>

<div class="container">

    <div class="title">☕ Coffee Shop</div>

    <!-- KATEGORI -->
    <div class="kategori">
        <button class="active" onclick="filterMenu('all', event)">All</button>
        @foreach($kategori as $k)
            <button onclick="filterMenu('{{ $k->id }}', event)">
                {{ $k->nama_kategori }}
            </button>
        @endforeach
    </div>

    <!-- MENU -->
    <div class="menu-grid">

        @foreach($menu as $item)
        <div class="card-menu"
            data-kategori="{{ $item->kategori_id }}"
            onclick="openModal(
                {{ $item->id }},
                '{{ $item->nama_menu }}',
                '{{ number_format($item->harga,0,',','.') }}',
                '{{ $item->deskripsi ?? 'Menu enak ☕' }}',
                '{{ $item->gambar ? asset('images/'.$item->gambar) : 'https://via.placeholder.com/300' }}'
            )">

            <img src="{{ $item->gambar ? asset('images/'.$item->gambar) : 'https://via.placeholder.com/300' }}">

            <div class="card-body">
                <h4>{{ $item->nama_menu }}</h4>
                <p>{{ $item->kategori->nama_kategori ?? '-' }}</p>
                <div class="price">Rp {{ number_format($item->harga,0,',','.') }}</div>
            </div>
        </div>
        @endforeach

    </div>

</div>

<!-- MODAL -->
<div id="modalMenu">
    <div style="background:white; width:300px; margin:80px auto; padding:20px;">
        <h3 id="mNama"></h3>
        <p id="mHarga"></p>
        <p id="mDesc"></p>

        <button onclick="addToCart()">Tambah ke Keranjang</button>
        <button onclick="closeModal()">Tutup</button>
    </div>
</div>

<!-- CART -->
<div id="cartSidebar">
    <h3>🛒 Keranjang</h3>

    <table width="100%" border="1">
        <tbody id="cartList"></tbody>
    </table>

    <h3>Total: Rp <span id="cartTotal">0</span></h3>

    <input type="number" id="bayar" placeholder="Bayar">

    <button onclick="checkout()">Checkout</button>
    <button onclick="toggleCart()">Tutup</button>
</div>

<button onclick="toggleCart()" style="position:fixed; bottom:20px; right:20px;">
🛒
</button>

<script>
let cart = {};
let selected = {};

// FILTER
function filterMenu(kategori, event){
    document.querySelectorAll('.card-menu').forEach(item=>{
        item.style.display = (kategori=='all'||item.dataset.kategori==kategori) ? 'block':'none';
    });
}

// MODAL
function openModal(id,nama,harga,desc){
    selected = {
        id:id,
        nama:nama,
        harga:parseInt(harga.replace(/\./g,''))
    };

    document.getElementById('mNama').innerText = nama;
    document.getElementById('mHarga').innerText = harga;
    document.getElementById('mDesc').innerText = desc;

    document.getElementById('modalMenu').style.display='block';
}

function closeModal(){
    document.getElementById('modalMenu').style.display='none';
}

// CART
function addToCart(){
    let key = selected.id;

    if(cart[key]){
        cart[key].qty++;
    } else {
        cart[key] = {...selected, qty:1};
    }

    renderCart();
    closeModal();
}

function renderCart(){
    let html='';
    let total=0;

    Object.values(cart).forEach(item=>{
        total += item.qty * item.harga;

        html+=`
        <tr>
            <td>${item.nama}</td>
            <td>
                <button onclick="qty(${item.id},-1)">-</button>
                ${item.qty}
                <button onclick="qty(${item.id},1)">+</button>
            </td>
            <td><button onclick="removeItem(${item.id})">X</button></td>
        </tr>`;
    });

    document.getElementById('cartList').innerHTML = html;
    document.getElementById('cartTotal').innerText = total.toLocaleString();
}

function qty(id,val){
    cart[id].qty += val;
    if(cart[id].qty<=0) delete cart[id];
    renderCart();
}

function removeItem(id){
    delete cart[id];
    renderCart();
}

function toggleCart(){
    let c = document.getElementById('cartSidebar');
    c.style.display = c.style.display=='block'?'none':'block';
}

// CHECKOUT
function checkout(){

    let bayar = document.getElementById('bayar').value;
    let total = parseInt(document.getElementById('cartTotal').innerText.replace(/,/g,''));

    if(!bayar || bayar < total){
        alert('Uang kurang');
        return;
    }

    let items=[];

    Object.values(cart).forEach(i=>{
        items.push({
            id:i.id,
            qty:i.qty,
            harga:i.harga
        });
    });

    fetch("{{ route('kasir.transaksi') }}",{
        method:"POST",
        headers:{
            "Content-Type":"application/json",
            "X-CSRF-TOKEN":"{{ csrf_token() }}"
        },
        body:JSON.stringify({
            total:total,
            bayar:bayar,
            kembalian:bayar-total,
            items:items
        })
    })
    .then(res=>res.json())
    .then(res=>{
        alert("Sukses! Invoice: "+res.invoice);
        cart={};
        renderCart();
        toggleCart();
    });
}
</script>

@endsection