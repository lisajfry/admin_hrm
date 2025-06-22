@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold text-blue-800 mb-6">Daftar Izin</h2>

<a href="{{ route('izin.create') }}" class="bg-blue-700 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition mb-4 inline-block">
    + Tambah Izin
</a>

@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<table class="min-w-full bg-white border border-gray-300 rounded">
    <thead class="bg-blue-100 text-blue-900">
        <tr>
            <th class="py-2 px-4 border">No</th>
            <th class="py-2 px-4 border">Nama Karyawan</th>
            <th class="py-2 px-4 border">Tanggal Mulai</th>
            <th class="py-2 px-4 border">Tanggal Selesai</th>
            <th class="py-2 px-4 border">Alasan</th>
            <th class="py-2 px-4 border">Keterangan</th>
            <th class="py-2 px-4 border">Durasi</th>
            <th class="py-2 px-4 border">Status</th>
            <th class="py-2 px-4 border">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($izins as $izin)
        <tr class="text-center">
            <td class="py-2 px-4 border">{{ $loop->iteration }}</td>
            <td class="py-2 px-4 border">{{ $izin->karyawan->nama_karyawan ?? '-' }}</td>
            <td class="py-2 px-4 border">{{ $izin->tgl_mulai }}</td>
            <td class="py-2 px-4 border">{{ $izin->tgl_selesai }}</td>
            <td class="py-2 px-4 border">{{ ucfirst($izin->alasan) }}</td>
            <td class="py-2 px-4 border">{{ $izin->keterangan }}</td>
            <td class="py-2 px-4 border">{{ $izin->durasi }} hari</td>
            <td class="py-2 px-4 border">{{ $izin->status }}</td>
            <td class="py-2 px-4 border space-x-2">
                <a href="{{ route('izin.edit', $izin->id) }}" class="text-blue-600 hover:underline">Edit</a>
                <form action="{{ route('izin.destroy', $izin->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="py-4 text-center text-gray-500">Data izin belum tersedia.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
