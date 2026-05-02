<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Coffee Shop</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f7f6f3;
            color: #333;
        }

        /* HEADER */
        .header {
            background: #2c2a28;
            color: #fff;
            padding: 14px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .header b {
            font-size: 16px;
            letter-spacing: 0.5px;
        }

        .logout {
            color: #fff;
            text-decoration: none;
            margin-left: 10px;
            opacity: 0.8;
        }

        .logout:hover {
            opacity: 1;
        }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            height: 100vh;
            position: fixed;
            background: #ffffff;
            padding: 25px 15px;
            border-right: 1px solid #eee;
        }

        .sidebar h4 {
            font-size: 14px;
            margin-bottom: 15px;
            color: #999;
            padding-left: 10px;
        }

        .sidebar a {
            display: block;
            padding: 12px 15px;
            margin-bottom: 8px;
            text-decoration: none;
            color: #333;
            border-radius: 10px;
            transition: 0.2s;
            font-size: 14px;
        }

        .sidebar a:hover {
            background: #f1eee9;
            transform: translateX(3px);
        }

        /* CONTENT */
        .content {
            margin-left: 250px;
            padding: 25px;
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        /* BUTTON STYLE */
        button, .btn {
            background: #2c2a28;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover, .btn:hover {
            background: #444;
        }

        /* FORM STYLE */
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
        }

        input:focus, select:focus {
            border-color: #2c2a28;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #f5f3f0;
            text-align: left;
            padding: 12px;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

    </style>

</head>
<body>

<!-- HEADER -->
<div class="header">
    <div><b>☕ COFFEE SHOP ADMIN</b></div>

    <div>
        @auth
            <span>{{ auth()->user()->name }}</span> |
            <a href="{{ route('logout') }}" class="logout">Logout</a>
        @endauth
    </div>
</div>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>MAIN MENU</h4>

    <a href="{{ route('backend.beranda') }}">🏠 Dashboard</a>
    <a href="{{ route('backend.menu.index') }}">📦 Menu</a>
    <a href="#">🧾 Transaksi</a>
    <a href="#">📊 Laporan</a>
</div>

<!-- CONTENT -->
<div class="content">
    <div class="card">
        @yield('content')
    </div>
</div>

<!-- JS -->
<script src="{{ asset('backend/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('backend/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/extra-libs/DataTables/datatables.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#zero_config').DataTable();
    });
</script>

</body>
</html>