@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold text-blue-800 mb-6">Edit Data Lembur</h2>

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form action="{{ route('lembur.update', $lembur->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    {{-- Nama karyawan hanya ditampilkan, tidak bisa diubah --}}
    <div>
        <label class="block font-medium text-gray-700">Nama Karyawan</label>
        <input type="text" class="w-full border px-4 py-2 rounded bg-gray-100" value="{{ $lembur->karyawan->nama_karyawan }}" readonly>
        <input type="hidden" name="id_karyawan" value="{{ $lembur->id_karyawan }}">
    </div>

    <div>
        <label class="block font-medium text-gray-700">Tanggal Lembur</label>
        <input type="date" name="tanggal_lembur" class="w-full border px-4 py-2 rounded" value="{{ $lembur->tanggal_lembur }}" required>
    </div>

    <div>
        <label class="block font-medium text-gray-700">Jam Mulai</label>
        <input type="time" name="jam_mulai" class="w-full border px-4 py-2 rounded" value="{{ $lembur->jam_mulai }}" required>
    </div>

    <div>
        <label class="block font-medium text-gray-700">Jam Selesai</label>
        <input type="time" name="jam_selesai" class="w-full border px-4 py-2 rounded" value="{{ $lembur->jam_selesai }}" required>
    </div>

    <div>
        <label class="block font-medium text-gray-700">Alasan Lembur</label>
        <textarea name="alasan_lembur" rows="3" class="w-full border px-4 py-2 rounded">{{ $lembur->alasan_lembur }}</textarea>
    </div>

    <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
</form>
@endsection
