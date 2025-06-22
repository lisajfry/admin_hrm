@extends('layouts.admin')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-6">📄 Rekap Payroll Bulan {{ $bulan }} Tahun {{ $tahun }}</h1>

    {{-- Filter --}}
    <form method="GET" action="{{ route('payroll.index') }}" class="flex items-center gap-4 mb-6">
        <div>
            <label for="month" class="text-sm">Bulan</label>
            <select name="month" id="month" class="border rounded px-2 py-1">
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $i == $bulan ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                    </option>
                @endfor
            </select>
        </div>
        <div>
            <label for="year" class="text-sm">Tahun</label>
            <select name="year" id="year" class="border rounded px-2 py-1">
                @foreach ($filters as $f)
                    <option value="{{ $f->year }}" {{ $f->year == $tahun ? 'selected' : '' }}>
                        {{ $f->year }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            🔄 Tampilkan
        </button>
        <a href="{{ route('payroll.exportExcel', ['month' => $bulan, 'year' => $tahun]) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            📥 Export Excel
        </a>
    </form>

    {{-- Tabel --}}
    <div class="overflow-auto">
        <table class="min-w-full border text-sm bg-white shadow rounded">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Jabatan</th>
                    <th class="px-2 py-2 border">Izin</th>
                    <th class="px-2 py-2 border">Cuti</th>
                    <th class="px-2 py-2 border">Dinas</th>
                    <th class="px-2 py-2 border">Hadir</th>
                    <th class="px-2 py-2 border">Lembur</th>
                    <th class="px-2 py-2 border">Point</th>
                    <th class="px-2 py-2 border">Terlambat</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_izin = $total_cuti = $total_dinas = $total_hadir = $total_lembur = $total_point = $total_terlambat = 0;
                @endphp
                @forelse($rekap as $r)
                    @php
                        $total_izin += $r['izin'];
                        $total_cuti += $r['cuti'];
                        $total_dinas += $r['dinas'];
                        $total_hadir += $r['kehadiran'];
                        $total_lembur += $r['lembur'];
                        $total_point += $r['point'];
                        $total_terlambat += $r['terlambat'];
                    @endphp
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $r['karyawan']->nama_karyawan }}</td>
                        <td class="px-4 py-2 border">{{ $r['karyawan']->jabatan->jabatan ?? '-' }}</td>
                        <td class="text-center border">{{ $r['izin'] }}</td>
                        <td class="text-center border">{{ $r['cuti'] }}</td>
                        <td class="text-center border">{{ $r['dinas'] }}</td>
                        <td class="text-center border">{{ $r['kehadiran'] }}</td>
                        <td class="text-center border">{{ $r['lembur'] }}</td>
                        <td class="text-center border">{{ $r['point'] }}</td>
                        <td class="text-center border">{{ $r['terlambat'] }}</td>
                        <td class="px-4 py-2 border">
                            <a href="{{ route('payroll.slip', ['id' => $r['karyawan']->id, 'month' => $bulan, 'year' => $tahun]) }}"
                               class="text-blue-600 hover:underline text-sm">🧾 Slip</a>
                            {{-- <a href="#" class="ml-2 text-green-600 hover:underline text-sm">🔍 Detail</a> --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-gray-500 py-4">Tidak ada data.</td>
                    </tr>
                @endforelse

                {{-- Ringkasan Total --}}
                <tr class="bg-gray-100 font-bold border-t">
                    <td colspan="2" class="text-right px-4 py-2">Total</td>
                    <td class="text-center border">{{ $total_izin }}</td>
                    <td class="text-center border">{{ $total_cuti }}</td>
                    <td class="text-center border">{{ $total_dinas }}</td>
                    <td class="text-center border">{{ $total_hadir }}</td>
                    <td class="text-center border">{{ $total_lembur }}</td>
                    <td class="text-center border">{{ $total_point }}</td>
                    <td class="text-center border">{{ $total_terlambat }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
