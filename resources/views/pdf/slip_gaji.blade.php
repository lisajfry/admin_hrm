<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - {{ $nama_karyawan }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 6px 8px; border: 1px solid #000; }
        h2, h4 { text-align: center; }
    </style>
</head>
<body>
    <h2>Slip Gaji</h2>
    <h4>Bulan {{ $bulan }} {{ $tahun }}</h4>

    <table>
        <tr>
            <th>Nama Karyawan</th>
            <td>{{ $nama_karyawan }}</td>
        </tr>
        <tr>
            <th>Jabatan</th>
            <td>{{ $nama_jabatan }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th colspan="2">Rekap Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            <tr><th>Hadir</th><td>{{ $kehadiran }}</td></tr>
            <tr><th>Dinas Luar Kota</th><td>{{ $dinas_luar_kota }}</td></tr>
            <tr><th>Total Kehadiran</th><td>{{ $total_kehadiran }}</td></tr>
            <tr><th>Izin</th><td>{{ $izin }}</td></tr>
            <tr><th>Cuti</th><td>{{ $cuti }}</td></tr>
            <tr><th>Terlambat</th><td>{{ $terlambat }}</td></tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th colspan="2">Gaji & Tunjangan</th>
            </tr>
        </thead>
        <tbody>
            <tr><th>Gaji Pokok</th><td>Rp {{ number_format($gaji_pokok) }}</td></tr>
            <tr><th>Tunjangan</th><td>Rp {{ number_format($tunjangan) }}</td></tr>
            <tr><th>Bonus (lembur & poin)</th><td>Rp {{ number_format($total_bonus) }}</td></tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr><th colspan="2">Uang Kehadiran & Makan</th></tr>
        </thead>
        <tbody>
            <tr><th>Uang Kehadiran</th><td>Rp {{ number_format($uang_kehadiran) }}</td></tr>
            <tr><th>Uang Makan</th><td>Rp {{ number_format($uang_makan) }}</td></tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr><th colspan="2">Potongan</th></tr>
        </thead>
        <tbody>
            <tr><th>Potongan Terlambat</th><td>Rp {{ number_format($total_potongan) }}</td></tr>
        </tbody>
    </table>

    <h4>Total Gaji Kotor: Rp {{ number_format(
        $gaji_pokok + $tunjangan + $total_bonus + $uang_kehadiran + $uang_makan
    ) }}</h4>

    <h4>Potongan: Rp {{ number_format($total_potongan) }}</h4>

    <h3 style="text-align: right;">Gaji Bersih: Rp {{ number_format(
        $gaji_pokok + $tunjangan + $total_bonus + $uang_kehadiran + $uang_makan - $total_potongan
    ) }}</h3>
</body>
</html>
