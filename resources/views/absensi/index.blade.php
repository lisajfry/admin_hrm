@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold text-blue-800 mb-6">Absensi Kehadiran</h2>

@if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif
<div class="mb-4 flex gap-3">
    <a href="{{ route('absensi.masuk.create') }}"
       class="bg-blue-700 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition">
        + Absen Masuk
    </a>
    <a href="{{ route('absensi.keluar.create') }}"
       class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-500 transition">
        + Absen Keluar
    </a>
</div>


<div class="bg-white shadow rounded-lg overflow-auto">
    <table class="min-w-full table-auto border-collapse">
        <thead class="bg-blue-100 text-blue-800 text-left text-sm">
            <tr>
                <th class="px-6 py-3 border-b">No</th>
                <th class="px-6 py-3 border-b">Nama Karyawan</th>
                <th class="px-6 py-3 border-b">Tanggal</th>
                <th class="px-6 py-3 border-b">Jam Masuk</th>
                <th class="px-6 py-3 border-b">Jam Keluar</th>
                <th class="px-6 py-3 border-b">Status</th>
                <th class="px-6 py-3 border-b">Foto Masuk</th>
                <th class="px-6 py-3 border-b">Foto Keluar</th>
                <th class="px-6 py-3 border-b">Aksi</th>

            </tr>
        </thead>
        <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
            @forelse($absensis as $absensi)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-3">{{ $loop->iteration }}</td>
                <td class="px-6 py-3">{{ $absensi->karyawan->nama_karyawan ?? '-' }}</td>
                <td class="px-6 py-3">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d-m-Y') }}</td>
                <td class="px-6 py-3">{{ $absensi->jam_masuk ?? '-' }}</td>
                <td class="px-6 py-3">{{ $absensi->jam_keluar ?? '-' }}</td>
                <td class="px-6 py-3 capitalize">{{ str_replace('_', ' ', $absensi->status) }}</td>
                <td class="px-6 py-3">
                    @if ($absensi->foto_masuk)
                        <img src="{{ asset('storage/' . $absensi->foto_masuk) }}" alt="Foto Masuk" class="h-12">
                    @else
                        -
                    @endif
                </td>
                <td class="px-6 py-3">
                    @if ($absensi->foto_keluar)
                        <img src="{{ asset('storage/' . $absensi->foto_keluar) }}" alt="Foto Keluar" class="h-12">
                    @else
                        -
                    @endif
                </td>
                <td class="px-6 py-3">
    <a href="{{ route('absensi.edit', $absensi->id) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
    
    <form action="{{ route('absensi.destroy', $absensi->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:underline text-sm ml-2">Hapus</button>
    </form>
    
</td>

            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-4 text-center text-gray-500">Tidak ada data absensi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
