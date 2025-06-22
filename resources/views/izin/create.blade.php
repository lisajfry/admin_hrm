@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold text-blue-800 mb-6">Tambah Izin</h2>

<form action="{{ route('izin.store') }}" method="POST" class="space-y-4">
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
        <label class="block font-medium text-gray-700">Tanggal Mulai</label>
        <input type="date" name="tgl_mulai" class="w-full border px-4 py-2 rounded" required>
    </div>

    <div>
        <label class="block font-medium text-gray-700">Tanggal Selesai</label>
        <input type="date" name="tgl_selesai" class="w-full border px-4 py-2 rounded" required>
    </div>
    <div>
    <label class="block font-medium text-gray-700">Alasan</label>
    <select name="alasan" class="w-full border px-4 py-2 rounded" required>
        <option value="">-- Pilih Alasan --</option>
        <option value="cuti">Cuti</option>
        <option value="izin">Izin</option>
    </select>
</div>

<div>
    <label class="block font-medium text-gray-700">Keterangan</label>
    <textarea name="keterangan" rows="3" class="w-full border px-4 py-2 rounded" required></textarea>
</div>


    <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
</form>
@endsection
