@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold text-blue-800 mb-6">Data Dinas Luar Kota</h2>

<a href="{{ route('dinas.create') }}" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">
    + Tambah Dinas
</a>

<table class="w-full table-auto border-collapse border border-gray-300 mt-4">
    <thead class="bg-blue-100">
        <tr>
            <th class="border px-4 py-2">Nama Karyawan</th>
            <th class="border px-4 py-2">Tgl Berangkat</th>
            <th class="border px-4 py-2">Tgl Kembali</th>
            <th class="border px-4 py-2">Kota Tujuan</th>
            <th class="border px-4 py-2">Keperluan</th>
            <th class="border px-4 py-2">Biaya Transport</th>
            <th class="border px-4 py-2">Biaya Penginapan</th>
            <th class="border px-4 py-2">Uang Harian</th>
            <th class="border px-4 py-2">Total Biaya</th>
            <th class="border px-4 py-2">Status</th>
            <th class="border px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($dinass as $dinas)
        <tr>
            <td class="border px-4 py-2">{{ $dinas->karyawan->nama_karyawan }}</td>
            <td class="border px-4 py-2">{{ $dinas->tgl_berangkat }}</td>
            <td class="border px-4 py-2">{{ $dinas->tgl_kembali }}</td>
            <td class="border px-4 py-2">{{ $dinas->kota_tujuan }}</td>
            <td class="border px-4 py-2">{{ $dinas->keperluan }}</td>
            <td class="border px-4 py-2">Rp{{ number_format($dinas->biaya_transport) }}</td>
            <td class="border px-4 py-2">Rp{{ number_format($dinas->biaya_penginapan) }}</td>
            <td class="border px-4 py-2">Rp{{ number_format($dinas->uang_harian) }}</td>
            <td class="border px-4 py-2">Rp{{ number_format($dinas->total_biaya) }}</td>
            <td class="border px-4 py-2 capitalize">{{ $dinas->status }}</td>
            <td class="border px-4 py-2 flex gap-2">
                <a href="{{ route('dinas.edit', $dinas->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                <form action="{{ route('dinas.destroy', $dinas->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="11" class="border px-4 py-2 text-center text-gray-500">Belum ada data dinas luar kota.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
