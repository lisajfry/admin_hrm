<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - PayrollMetrics</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f3f4f6;
        }
        .form-box {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            width: 350px;
        }
        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #1e3a8a;
        }
        input {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
        }
        button {
            background: #1e3a8a;
            color: white;
            padding: 0.8rem;
            width: 100%;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .link {
            text-align: center;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Admin Login</h2>
<form method="POST" action="{{ route('login.proses') }}">
    @csrf
    <input type="email" name="email" required>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
</form>


        <div class="link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
        </div>
    </div>
</body>
</html>
