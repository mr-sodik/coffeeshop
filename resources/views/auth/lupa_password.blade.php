<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #1e1e1e, #3a3a3a);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            width: 350px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        h2 {
            margin-bottom: 10px;
        }

        p {
            color: gray;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            background: black;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
        }

        a:hover {
            background: #333;
        }

        .logo {
            font-size: 26px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="card">

    <div class="logo">☕</div>

    <h2>Lupa Password</h2>

    <p>Fitur reset password belum tersedia.</p>
    <p>Silakan hubungi admin untuk bantuan.</p>

    <a href="{{ route('login') }}">Kembali ke Login</a>

</div>

</body>
</html>