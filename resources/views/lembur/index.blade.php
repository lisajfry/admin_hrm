@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold text-blue-800 mb-6">Data Lembur</h2>

<a href="{{ route('lembur.create') }}" class="mb-4 inline-block bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Lembur</a>

@if(session('success'))
    <div class="bg-green-200 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
@endif

<table class="w-full table-auto border border-collapse">
    <thead class="bg-blue-100">
        <tr>
            <th class="py-2 px-4 border">Nama Karyawan</th>
            <th class="py-2 px-4 border">Tanggal</th>
            <th class="py-2 px-4 border">Jam Mulai</th>
            <th class="py-2 px-4 border">Jam Selesai</th>
            <th class="py-2 px-4 border">Durasi</th>
            <th class="py-2 px-4 border">Alasan</th>
            <th class="py-2 px-4 border">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lemburs as $lembur)
        <tr>
            <td class="py-2 px-4 border">{{ $lembur->karyawan->nama_karyawan }}</td>
            <td class="py-2 px-4 border">{{ $lembur->tanggal_lembur }}</td>
            <td class="py-2 px-4 border">{{ $lembur->jam_mulai }}</td>
            <td class="py-2 px-4 border">{{ $lembur->jam_selesai }}</td>
            <td class="py-2 px-4 border">{{ $lembur->durasi_lembur }} jam</td>
            <td class="py-2 px-4 border">{{ $lembur->alasan_lembur }}</td>
            <td class="py-2 px-4 border">
                <a href="{{ route('lembur.edit', $lembur->id) }}" class="text-yellow-500 hover:underline">Edit</a> |
                <form action="{{ route('lembur.destroy', $lembur->id) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
