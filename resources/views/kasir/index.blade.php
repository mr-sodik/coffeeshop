@extends('backend.v_layouts.app')

@section('content')

<h2>☕ POS Kasir</h2>

<div style="display:flex; gap:20px;">

<!-- ================= MENU ================= -->
<div style="width:60%;">
    <div class="menu-grid">
        @foreach($menu as $item)
        <div class="card-menu"
             onclick="tambahItem({{ $item->id }}, '{{ $item->nama_menu }}', {{ $item->harga }})">

            <img src="{{ $item->gambar ? asset('images/'.$item->gambar) : 'https://via.placeholder.com/200' }}">

            <b>{{ $item->nama_menu }}</b>
            <p>Rp {{ number_format($item->harga) }}</p>
        </div>
        @endforeach
    </div>
</div>

<!-- ================= KERANJANG ================= -->
<div style="width:40%;">

<h3>🛒 Keranjang</h3>

<table width="100%" border="1">
<thead>
<tr>
<th>Menu</th>
<th>Qty</th>
<th>Subtotal</th>
<th>Aksi</th>
</tr>
</thead>
<tbody id="keranjang"></tbody>
</table>

<h3>Total: Rp <span id="total">0</span></h3>

<hr>

<label>Diskon (%)</label>
<input type="number" id="diskon" value="0" oninput="renderCart()">

<label>Pajak (%)</label>
<input type="number" id="pajak" value="0" oninput="renderCart()">

<label>Metode</label>
<select id="metode">
<option value="cash">Cash</option>
<option value="transfer">Transfer</option>
<option value="qris">QRIS</option>
</select>

<br><br>

<label>Bayar</label>
<input type="number" id="bayar" oninput="hitungKembalian()">

<h3>Kembalian: Rp <span id="kembalian">0</span></h3>

<button onclick="prosesBayar()">Bayar</button>

</div>
</div>

<!-- ================= STYLE ================= -->
<style>
.menu-grid {
    display:grid;
    grid-template-columns: repeat(3,1fr);
    gap:10px;
}
.card-menu {
    background:#fff;
    padding:10px;
    border-radius:10px;
    cursor:pointer;
    text-align:center;
}
.card-menu img {
    width:100%;
    height:120px;
    object-fit:cover;
}
</style>

<!-- ================= SCRIPT ================= -->
<script>

let cart = {};
let total = 0;

function formatRupiah(angka){
    return angka.toLocaleString('id-ID');
}

function tambahItem(id, nama, harga){
    if(cart[id]) cart[id].qty++;
    else cart[id] = {nama, harga, qty:1};
    renderCart();
}

function renderCart(){
    let tbody = document.getElementById('keranjang');
    tbody.innerHTML = '';
    total = 0;

    Object.keys(cart).forEach(id=>{
        let item = cart[id];
        let sub = item.qty * item.harga;
        total += sub;

        tbody.innerHTML += `
        <tr>
            <td>${item.nama}</td>
            <td>
                <button onclick="ubahQty(${id}, -1)">-</button>
                ${item.qty}
                <button onclick="ubahQty(${id}, 1)">+</button>
            </td>
            <td>Rp ${formatRupiah(sub)}</td>
            <td><button onclick="hapusItem(${id})">X</button></td>
        </tr>`;
    });

    let diskon = document.getElementById('diskon').value || 0;
    let pajak = document.getElementById('pajak').value || 0;

    let totalDiskon = total * (diskon/100);
    let totalPajak = total * (pajak/100);

    let grandTotal = total - totalDiskon + totalPajak;

    document.getElementById('total').innerText = formatRupiah(grandTotal);

    hitungKembalian();
}

function ubahQty(id, val){
    cart[id].qty += val;
    if(cart[id].qty <= 0) delete cart[id];
    renderCart();
}

function hapusItem(id){
    delete cart[id];
    renderCart();
}

function hitungKembalian(){
    let bayar = document.getElementById('bayar').value || 0;
    let total = parseInt(document.getElementById('total').innerText.replace(/\./g,''));

    let kembali = bayar - total;
    document.getElementById('kembalian').innerText = formatRupiah(kembali > 0 ? kembali : 0);
}

function prosesBayar(){

    let bayar = document.getElementById('bayar').value;
    let total = parseInt(document.getElementById('total').innerText.replace(/\./g,''));

    if(!bayar || bayar < total){
        alert("Uang tidak cukup!");
        return;
    }

    let items = Object.keys(cart).map(id => ({
        id:id,
        qty:cart[id].qty,
        harga:cart[id].harga
    }));

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
            diskon:document.getElementById('diskon').value,
            pajak:document.getElementById('pajak').value,
            metode:document.getElementById('metode').value,
            items:items
        })
    })
    .then(res => res.json())
    .then(res => {

        if(!res.success){
            alert("Gagal: " + res.message);
            return;
        }

        alert("Transaksi berhasil! Invoice: " + res.invoice);

        cart = {};
        renderCart();
        document.getElementById('bayar').value = '';
    })
    .catch(err=>{
        alert("Server error!");
        console.log(err);
    });
}

</script>

@endsection