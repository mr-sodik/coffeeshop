<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Coffee Shop</title>

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
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        p {
            text-align: center;
            color: gray;
            margin-bottom: 25px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        input:focus {
            border-color: black;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background: black;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #333;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
        }

        .footer a {
            text-decoration: none;
            color: black;
        }

        .error {
            background: #ffe5e5;
            color: red;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
        }

        .logo {
            text-align: center;
            font-size: 26px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="card">

    <div class="logo">☕</div>
    <h2>Register</h2>
    <p>Buat akun baru</p>

    {{-- ERROR --}}
    @if($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('register.proses') }}" method="POST">
        @csrf

        <input type="text" name="name" placeholder="Nama" required>

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Register</button>
    </form>

    <div class="footer">
        <p>Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
    </div>

</div>

</body>
</html>