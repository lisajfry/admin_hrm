@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold text-blue-800 mb-6">Edit Dinas Luar Kota</h2>

<form action="{{ route('dinas.update', $dinas->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-gray-700">Nama Karyawan</label>
        <select name="id_karyawan" class="w-full border px-4 py-2 rounded" required>
            @foreach ($karyawans as $karyawan)
                <option value="{{ $karyawan->id }}" {{ $karyawan->id == $dinas->id_karyawan ? 'selected' : '' }}>
                    {{ $karyawan->nama_karyawan }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700">Tanggal Berangkat</label>
            <input type="date" name="tgl_berangkat" class="w-full border px-4 py-2 rounded" value="{{ $dinas->tgl_berangkat }}" required>
        </div>
        <div>
            <label class="block text-gray-700">Tanggal Kembali</label>
            <input type="date" name="tgl_kembali" class="w-full border px-4 py-2 rounded" value="{{ $dinas->tgl_kembali }}" required>
        </div>
    </div>

    <div>
        <label class="block text-gray-700">Kota Tujuan</label>
        <input type="text" name="kota_tujuan" class="w-full border px-4 py-2 rounded" value="{{ $dinas->kota_tujuan }}" required>
    </div>

    <div>
        <label class="block text-gray-700">Keperluan</label>
        <textarea name="keperluan" class="w-full border px-4 py-2 rounded" required>{{ $dinas->keperluan }}</textarea>
    </div>

    <div class="grid grid-cols-3 gap-4">
        <div>
            <label class="block text-gray-700">Biaya Transport</label>
            <input type="number" name="biaya_transport" class="w-full border px-4 py-2 rounded" value="{{ $dinas->biaya_transport }}" required>
        </div>
        <div>
            <label class="block text-gray-700">Biaya Penginapan</label>
            <input type="number" name="biaya_penginapan" class="w-full border px-4 py-2 rounded" value="{{ $dinas->biaya_penginapan }}" required>
        </div>
        <div>
            <label class="block text-gray-700">Uang Harian</label>
            <input type="number" name="uang_harian" class="w-full border px-4 py-2 rounded" value="{{ $dinas->uang_harian }}" required>
        </div>
    </div>

    <div>
        <label class="block text-gray-700">Status</label>
        <select name="status" class="w-full border px-4 py-2 rounded" required>
            <option value="diajukan" {{ $dinas->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
            <option value="disetujui" {{ $dinas->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
            <option value="ditolak" {{ $dinas->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
    </div>

    <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-600">
        Update
    </button>
</form>
@endsection
