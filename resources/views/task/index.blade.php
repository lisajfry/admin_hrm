@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold text-blue-800 mb-4">Daftar Tugas</h2>

<a href="{{ route('task.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-500 mb-4 inline-block">Tambah Tugas</a>

@if (session('success'))
    <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
@endif

<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-100">
            <th class="border px-4 py-2">#</th>
            <th class="border px-4 py-2">Nama Karyawan</th>
            <th class="border px-4 py-2">Judul Proyek</th>
            <th class="border px-4 py-2">Kegiatan</th>
            <th class="border px-4 py-2">Status</th>
            <th class="border px-4 py-2">Tanggal Mulai</th>
            <th class="border px-4 py-2">Batas Selesai</th>
            <th class="border px-4 py-2">Tanggal Selesai</th>
            <th class="border px-4 py-2">Point</th>
            <th class="border px-4 py-2">Approval</th>
            <th class="border px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
        <tr>
            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
            <td class="border px-4 py-2">{{ $task->karyawan->nama_karyawan ?? '-' }}</td>
            <td class="border px-4 py-2">{{ $task->judul_proyek }}</td>
            <td class="border px-4 py-2">{{ $task->kegiatan }}</td>
            <td class="border px-4 py-2">{{ $task->status }}</td>
            <td class="border px-4 py-2">{{ $task->tgl_mulai }}</td>
            <td class="border px-4 py-2">{{ $task->batas_penyelesaian }}</td>
            <td class="border px-4 py-2">{{ $task->tgl_selesai }}</td>
            <td class="border px-4 py-2">{{ $task->point }}</td>
            <td class="border px-4 py-2">{{ $task->status_approval }}</td>
            <td class="border px-4 py-2 space-x-2">
                <a href="{{ route('task.edit', $task->id_tugas) }}" class="text-yellow-500 hover:underline">Edit</a>
                <form action="{{ route('task.destroy', $task->id_tugas) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
