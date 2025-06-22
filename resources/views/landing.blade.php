<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - PayrollMetrics</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background-color: #f3f4f6;
      color: #1f2937;
    }
    header {
      background-color: #1e3a8a;
      color: white;
      padding: 2rem;
      text-align: center;
    }
    section {
      padding: 2rem;
      max-width: 1000px;
      margin: auto;
    }
    .cards {
      display: flex;
      flex-wrap: wrap;
      gap: 1.5rem;
      justify-content: center;
      margin-top: 2rem;
    }
    .card {
      background: white;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      width: 250px;
      transition: 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card h3 {
      color: #1e3a8a;
      margin-bottom: 0.5rem;
    }
    .actions {
      text-align: center;
      margin-top: 3rem;
    }
    .btn {
      background: #1e3a8a;
      color: white;
      padding: 1rem 2rem;
      text-decoration: none;
      border-radius: 8px;
      transition: 0.3s;
    }
    .btn:hover {
      background: #3749b5;
    }
  </style>
</head>
<body>

  <header>
    <h1>Selamat Datang, Admin 👋</h1>
    <p>Kelola sistem PayrollMetrics dengan efisien dan praktis</p>
  </header>

  <section>
    <h2 style="text-align:center;">Fitur yang Tersedia</h2>
    <div class="cards">
      <div class="card">
        <h3>Absensi Karyawan</h3>
        <p>Monitoring kehadiran, izin, keterlambatan, dan riwayat absensi.</p>
      </div>
      <div class="card">
        <h3>Penggajian</h3>
        <p>Perhitungan gaji otomatis termasuk lembur dan potongan.</p>
      </div>
      <div class="card">
        <h3>Manajemen Tugas</h3>
        <p>Buat dan kontrol tugas-tugas karyawan secara harian.</p>
      </div>
      <div class="card">
        <h3>Data Karyawan</h3>
        <p>Tambah, ubah, dan atur status serta jabatan karyawan.</p>
      </div>
    </div>

    <div class="actions">
      <a href="/dashboard" class="btn">Masuk ke Dashboard</a>
    </div>


    <section style="text-align:center; margin-top: 3rem;">
    <h2>Akses Admin PayrollMetrics</h2>
    <p>Login atau buat akun admin untuk mulai mengelola absensi dan penggajian.</p>

    <div style="margin-top: 1.5rem;">
        <a href="{{ route('login') }}" class="btn" style="background:#1e3a8a; color:white; padding: 0.8rem 1.5rem; margin: 0 10px; border-radius: 8px; text-decoration: none;">
            Login Admin
        </a>
        <a href="{{ route('register') }}" class="btn" style="background:#1e40af; color:white; padding: 0.8rem 1.5rem; margin: 0 10px; border-radius: 8px; text-decoration: none;">
            Register Admin
        </a>
    </div>
</section>

  </section>

</body>
</html>
