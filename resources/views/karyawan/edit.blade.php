@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold text-blue-800 mb-6">Edit Data Karyawan</h2>

<form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium text-gray-700">Nama Karyawan</label>
        <input type="text" name="nama_karyawan" value="{{ $karyawan->nama_karyawan }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">NIP</label>
            <input type="text" name="nip" value="{{ $karyawan->nip }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">NIK</label>
            <input type="text" name="nik" value="{{ $karyawan->nik }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ $karyawan->email }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">No. Handphone</label>
        <input type="text" name="no_handphone" value="{{ $karyawan->no_handphone }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Alamat</label>
        <textarea name="alamat" rows="3" class="w-full border border-gray-300 rounded px-4 py-2" required>{{ $karyawan->alamat }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Jabatan</label>
        <select name="jabatan_id" class="w-full border border-gray-300 rounded px-4 py-2">
            <option value="">-- Pilih Jabatan --</option>
            @foreach ($jabatan as $j)
                <option value="{{ $j->id }}" {{ $karyawan->jabatan_id == $j->id ? 'selected' : '' }}>
                    {{ $j->jabatan }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="bg-blue-800 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
</form>
@endsection
