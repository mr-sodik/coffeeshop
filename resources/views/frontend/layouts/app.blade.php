<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>404 CAFE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- FONT PREMIUM -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Playfair+Display:wght@500&display=swap" rel="stylesheet">

    <style>
        body {
            margin:0;
            font-family: 'Inter', sans-serif;
            background:#fafafa;
            color:#333;
        }

        /* ================= NAVBAR ================= */
        .navbar {
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:20px 40px;
            background:white;
            border-bottom:1px solid #eee;
            position:sticky;
            top:0;
            z-index:100;
        }

        .logo {
            font-size:22px;
            font-weight:600;
            letter-spacing:1px;
        }

        .nav-right {
            display:flex;
            align-items:center;
        }

        .navbar a {
            text-decoration:none;
            color:#333;
            margin-left:20px;
            font-size:14px;
        }

        .navbar a:hover {
            color:#8B5E3C;
        }

        /* ================= CART BUTTON ================= */
        .cart-btn {
            background:black;
            color:white;
            padding:8px 15px;
            border-radius:30px;
            cursor:pointer;
            margin-left:15px;
            font-size:14px;
        }

        /* ================= HERO PREMIUM ================= */
        .hero {
            position:relative;
            height:85vh;
            background:url("{{ asset('images/home.png') }}"); center/cover;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .hero-overlay {
            position:absolute;
            width:100%;
            height:100%;
            background:rgba(0,0,0,0.45);
        }

        .hero-content {
            position:relative;
            color:white;
            text-align:center;
            max-width:700px;
            padding:20px;
            animation:fadeIn 1s ease;
        }

        .hero-content .sub {
            letter-spacing:3px;
            font-size:12px;
            opacity:0.8;
        }

        .hero-content h1 {
            font-family: 'Playfair Display', serif;
            font-size:48px;
            margin:10px 0;
        }

        .hero-content p {
            font-size:14px;
            opacity:0.8;
        }

        .btn-hero {
            display:inline-block;
            margin-top:20px;
            padding:12px 25px;
            background:white;
            color:black;
            border-radius:30px;
            text-decoration:none;
            font-size:14px;
        }

        .btn-hero:hover {
            background:#8B5E3C;
            color:white;
        }

        @keyframes fadeIn {
            from {opacity:0; transform:translateY(20px);}
            to {opacity:1; transform:translateY(0);}
        }

        /* ================= CONTAINER ================= */
        .container {
            padding:40px;
        }

        /* ================= FOOTER ================= */
        .footer {
            text-align:center;
            padding:20px;
            background:white;
            border-top:1px solid #eee;
            margin-top:40px;
            font-size:12px;
            color:#777;
        }

        /* ================= CART PANEL ================= */
        .cart-panel {
            position:fixed;
            right:-400px;
            top:0;
            width:350px;
            height:100%;
            background:white;
            box-shadow:-5px 0 15px rgba(0,0,0,0.1);
            transition:0.3s;
            z-index:999;
            padding:20px;
            overflow:auto;
        }

        .cart-panel.active {
            right:0;
        }

        .cart-header {
            font-weight:600;
            margin-bottom:15px;
        }

        .cart-item {
            border-bottom:1px solid #eee;
            padding:10px 0;
            font-size:14px;
        }

        .cart-total {
            font-weight:bold;
            margin-top:15px;
        }

        .btn-checkout {
            width:100%;
            padding:12px;
            background:black;
            color:white;
            border:none;
            margin-top:10px;
            cursor:pointer;
            border-radius:6px;
        }

        .btn-remove {
            color:red;
            cursor:pointer;
            font-size:12px;
        }
    </style>

</head>
<body>

<!-- ================= NAVBAR ================= -->
<div class="navbar">
    <div class="logo">☕ 404 CAFE</div>

    <div class="nav-right">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('menu') }}">Menu</a>

        @auth
            <span style="margin-left:15px;">{{ auth()->user()->name }}</span>
            <a href="{{ route('logout') }}">Logout</a>
        @else
            <a href="{{ route('login') }}">Login</a>
        @endauth

        <span class="cart-btn" onclick="toggleCart()">🛒</span>
    </div>
</div>

<!-- ================= HERO ================= -->
<div class="hero">
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <p class="sub">404 CAFE</p>

        <h1>Not Found<br>
            But Wort It.
        </h1>
        <p>Sebuah Pengalaman Kopi yang tidak bisa Kamu cari,
            tapi akan Kamu ingat.
        </p>
        <a href="{{ route('menu') }}" #menuSection class="btn-hero">Explore Menu -></a>
    </div>
</div>

<!-- ================= CONTENT ================= -->
@yield('content')

<!-- ================= CART ================= -->
<div id="cartPanel" class="cart-panel">
    <div class="cart-header">🛒 Keranjang</div>

    <div id="cartItems"></div>

    <div class="cart-total">
        Total: Rp <span id="cartTotal">0</span>
    </div>

    <button class="btn-checkout">Checkout</button>
</div>

<!-- ================= FOOTER ================= -->
<div class="footer">
    © {{ date('Y') }} 404 CAFE • Inspired by DOA
</div>

<!-- ================= SCRIPT ================= -->
<script>
let cart = {};

function toggleCart(){
    document.getElementById('cartPanel').classList.toggle('active');
}

function addToCart(id, nama, harga){
    if(cart[id]) cart[id].qty++;
    else cart[id] = {nama, harga, qty:1};

    renderCart();
}

function removeItem(id){
    delete cart[id];
    renderCart();
}

function renderCart(){
    let html = '';
    let total = 0;

    Object.keys(cart).forEach(id=>{
        let item = cart[id];
        let sub = item.qty * item.harga;
        total += sub;

        html += `
        <div class="cart-item">
            <b>${item.nama}</b><br>
            ${item.qty} x Rp ${item.harga.toLocaleString()}<br>
            <span class="btn-remove" onclick="removeItem(${id})">hapus</span>
        </div>`;
    });

    document.getElementById('cartItems').innerHTML = html || '<p>Keranjang kosong</p>';
    document.getElementById('cartTotal').innerText = total.toLocaleString();
}
</script>

@stack('scripts')

</body>
</html>