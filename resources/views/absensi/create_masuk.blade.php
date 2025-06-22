@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold text-blue-800 mb-6">Form Absen Masuk</h2>

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('absensi.masuk.store') }}" method="POST" class="space-y-4">
    @csrf
    
    <div>
    <label for="id_karyawan" class="block font-medium text-gray-700">Nama Karyawan</label>
    <select name="id_karyawan" class="w-full border px-4 py-2 rounded" required>
        <option value="">-- Pilih Karyawan --</option>
        @foreach ($karyawans as $karyawan)
            <option value="{{ $karyawan->id }}">{{ $karyawan->nama_karyawan }}</option>
        @endforeach
    </select>
</div>

    <div>
        <label class="block font-medium text-gray-700">Tanggal</label>
        <input type="date" name="tanggal" class="w-full border px-4 py-2 rounded" required>
    </div>

    <div>
        <label class="block font-medium text-gray-700">Jam Masuk</label>
        <input type="time" name="jam_masuk" class="w-full border px-4 py-2 rounded" required>

    </div>

    <div>
        <label class="block font-medium text-gray-700">Foto Masuk (path)</label>
        <input type="text" name="foto_masuk" class="w-full border px-4 py-2 rounded" required>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700">Latitude</label>
            <input type="text" name="latitude_masuk" class="w-full border px-4 py-2 rounded">
        </div>
        <div>
            <label class="block text-gray-700">Longitude</label>
            <input type="text" name="longitude_masuk" class="w-full border px-4 py-2 rounded">
        </div>
    </div>

    <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan Absen Masuk</button>
</form>
@endsection
