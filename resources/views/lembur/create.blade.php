@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold text-blue-800 mb-6">Tambah Data Lembur</h2>

<form action="{{ route('lembur.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label class="block font-medium text-gray-700">Nama Karyawan</label>
        <select name="id_karyawan" class="w-full border px-4 py-2 rounded" required>
            <option value="">-- Pilih Karyawan --</option>
            @foreach ($karyawans as $karyawan)
                <option value="{{ $karyawan->id }}">{{ $karyawan->nama_karyawan }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-medium text-gray-700">Tanggal Lembur</label>
        <input type="date" name="tanggal_lembur" class="w-full border px-4 py-2 rounded" required>
    </div>

    <div>
        <label class="block font-medium text-gray-700">Jam Mulai</label>
        <input type="time" name="jam_mulai" class="w-full border px-4 py-2 rounded" required>
    </div>

    <div>
        <label class="block font-medium text-gray-700">Jam Selesai</label>
        <input type="time" name="jam_selesai" class="w-full border px-4 py-2 rounded" required>
    </div>

    <div>
        <label class="block font-medium text-gray-700">Alasan Lembur</label>
        <textarea name="alasan_lembur" rows="3" class="w-full border px-4 py-2 rounded"></textarea>
    </div>

    <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
</form>
@endsection
