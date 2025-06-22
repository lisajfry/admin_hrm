<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Izin</th>
            <th>Cuti</th>
            <th>Dinas</th>
            <th>Kehadiran</th>
            <th>Lembur</th>
            <th>Point</th>
            <th>Terlambat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rekap as $r)
            <tr>
                <td>{{ $r['karyawan']->nama_karyawan }}</td>
                <td>{{ $r['karyawan']->jabatan->jabatan ?? '-' }}</td>
                <td>{{ $r['izin'] }}</td>
                <td>{{ $r['cuti'] }}</td>
                <td>{{ $r['dinas'] }}</td>
                <td>{{ $r['kehadiran'] }}</td>
                <td>{{ $r['lembur'] }}</td>
                <td>{{ $r['point'] }}</td>
                <td>{{ $r['terlambat'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
