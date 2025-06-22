@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold text-blue-800 mb-6">Edit Tugas</h2>

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('task.update', $task->id_tugas) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block font-medium text-gray-700">Nama Karyawan</label>
        <input type="text" class="w-full border px-4 py-2 rounded bg-gray-100" value="{{ $task->karyawan->nama_karyawan }}" readonly>
        <input type="hidden" name="id_karyawan" value="{{ $task->id_karyawan }}">
    </div>
    <div>
        <label class="block">Judul Proyek</label>
        <input type="text" name="judul_proyek" class="w-full border rounded px-4 py-2" value="{{ $task->judul_proyek }}" required>
    </div>

    <div>
        <label class="block">Kegiatan</label>
        <textarea name="kegiatan" rows="3" class="w-full border rounded px-4 py-2" required>{{ $task->kegiatan }}</textarea>
    </div>

    <div>
        <label class="block">Status</label>
        <select name="status" class="w-full border rounded px-4 py-2" required>
            <option value="belum dimulai">Belum Mulai</option>
            <option value="dalam progres">Dalam Proses</option>
            <option value="selesai">Selesai</option>
        </select>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block">Tanggal Mulai</label>
            <input type="date" name="tgl_mulai" class="w-full border rounded px-4 py-2" value="{{ $task->tgl_mulai }}">
        </div>
        <div>
            <label class="block">Batas Penyelesaian</label>
            <input type="date" name="batas_penyelesaian" class="w-full border rounded px-4 py-2" value="{{ $task->batas_penyelesaian }}">
        </div>
    </div>

    <div>
        <label class="block">Tanggal Selesai</label>
        <input type="date" name="tgl_selesai" class="w-full border rounded px-4 py-2" value="{{ $task->tgl_selesai }}">
    </div>

    <div>
        <label class="block">Point</label>
        <input type="number" name="point" class="w-full border rounded px-4 py-2" value="{{ $task->point }}">
    </div>

    <div>
        <label class="block">Status Approval</label>
        <select name="status_approval" class="w-full border rounded px-4 py-2">
            <option value="pending">Menunggu</option>
            <option value="disetujui">Disetujui</option>
            <option value="ditolak">Ditolak</option>
        </select>
    </div>

    <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded">Update</button>
</form>
@endsection
