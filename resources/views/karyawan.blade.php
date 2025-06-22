@extends('layouts.admin')

@section('content')
<div class="px-6 py-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-blue-800">Kelola Karyawan</h2>
        <a href="{{ route('karyawan.create') }}"
           class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-medium">
            + Tambah Karyawan
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full table-auto border-collapse">
            <thead class="bg-blue-50">
                <tr class="text-left text-sm text-blue-900">
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">NIP</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">No HP</th>
                    <th class="px-4 py-3">Jabatan</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($karyawans as $karyawan)
                <tr class="border-b hover:bg-gray-50 text-sm">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">{{ $karyawan->nama_karyawan }}</td>
                    <td class="px-4 py-3">{{ $karyawan->nip }}</td>
                    <td class="px-4 py-3">{{ $karyawan->email }}</td>
                    <td class="px-4 py-3">{{ $karyawan->no_handphone }}</td>
                    <td class="px-4 py-3">{{ $karyawan->jabatan->jabatan ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('karyawan.edit', $karyawan->id) }}"
                           class="text-blue-600 hover:underline mr-2">Edit</a>
                        <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST"
                              class="inline-block" onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">Belum ada data karyawan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
