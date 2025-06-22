<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Register - PayrollMetrics</title>
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
        <h2>Admin Register</h2>
        <form method="POST" action="#">
            @csrf
            <input type="text" name="name" placeholder="Nama Lengkap" required>
            <input type="email" name="email" placeholder="Email Admin" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
            <button type="submit">Daftar</button>
        </form>
        <div class="link">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
        </div>
    </div>
</body>
</html>
