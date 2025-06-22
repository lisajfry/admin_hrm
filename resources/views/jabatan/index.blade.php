@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold text-blue-800 mb-6">Kelola Jabatan</h2>

@if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="mb-4">
    <a href="{{ route('jabatan.create') }}"
       class="inline-block bg-blue-800 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
        + Tambah Jabatan
    </a>
</div>

<div class="bg-white shadow rounded-lg overflow-auto">
    <table class="min-w-full table-auto border-collapse text-sm">
        <thead class="bg-blue-100 text-blue-800">
            <tr>
                <th class="px-4 py-3 border">No</th>
                <th class="px-4 py-3 border">Nama Jabatan</th>
                <th class="px-4 py-3 border">Gaji Pokok</th>
                <th class="px-4 py-3 border">Uang Kehadiran / Hari</th>
                <th class="px-4 py-3 border">Uang Makan</th>
                <th class="px-4 py-3 border">Bonus</th>
                <th class="px-4 py-3 border">Tunjangan</th>
                <th class="px-4 py-3 border">Potongan</th>
                <th class="px-4 py-3 border">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 divide-y divide-gray-200">
            @forelse ($jabatans as $jabatan)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 border">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 border">{{ $jabatan->jabatan ?? $jabatan->nama_jabatan }}</td>
                    <td class="px-4 py-3 border">Rp {{ number_format($jabatan->gaji_pokok, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 border">Rp {{ number_format($jabatan->uang_kehadiran_perhari, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 border">Rp {{ number_format($jabatan->uang_makan, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 border">Rp {{ number_format($jabatan->bonus, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 border">Rp {{ number_format($jabatan->tunjangan, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 border">Rp {{ number_format($jabatan->potongan, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 border flex gap-3">
                        <a href="{{ route('jabatan.edit', $jabatan->id) }}"
                           class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('jabatan.destroy', $jabatan->id) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus jabatan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="px-4 py-3 text-center text-gray-500">Belum ada data jabatan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
