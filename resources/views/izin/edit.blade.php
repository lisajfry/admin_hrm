@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold text-blue-800 mb-6">Edit Izin</h2>

<form action="{{ route('izin.update', $izin->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block font-medium text-gray-700">Nama Karyawan</label>
        <select name="id_karyawan" class="w-full border px-4 py-2 rounded" required>
            @foreach ($karyawans as $karyawan)
                <option value="{{ $karyawan->id }}" {{ $karyawan->id == $izin->id_karyawan ? 'selected' : '' }}>{{ $karyawan->nama_karyawan }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-medium text-gray-700">Tanggal Mulai</label>
        <input type="date" name="tgl_mulai" class="w-full border px-4 py-2 rounded" value="{{ $izin->tgl_mulai }}" required>
    </div>

    <div>
        <label class="block font-medium text-gray-700">Tanggal Selesai</label>
        <input type="date" name="tgl_selesai" class="w-full border px-4 py-2 rounded" value="{{ $izin->tgl_selesai }}" required>
    </div>

    <div>
        <label class="block font-medium text-gray-700">Keterangan</label>
        <textarea name="keterangan" rows="3" class="w-full border px-4 py-2 rounded" required>{{ $izin->keterangan }}</textarea>
    </div>

    <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
</form>
@endsection
