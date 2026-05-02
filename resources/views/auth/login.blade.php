<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Coffee Shop</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #1e1e1e, #3a3a3a);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .login-container {
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

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container p {
            text-align: center;
            color: gray;
            margin-bottom: 30px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            outline: none;
            transition: 0.2s;
        }

        input:focus {
            border-color: black;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            background: black;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #333;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
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

<div class="login-container">

    <div class="logo">☕</div>
    <h2>Coffee Shop</h2>
    <p>Silakan login ke akun Anda</p>

    {{-- ERROR --}}
    @if(session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('login.proses') }}" method="POST">
        @csrf

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <div class="footer">
        <p>Belum punya akun? <a href="{{ route('register') }}">Register</a></p>
        <p><a href="{{ route('lupa.password') }}">Lupa Password?</a></p>
    </div>

</div>

</body>
</html>