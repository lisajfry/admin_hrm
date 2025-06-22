@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold text-blue-800 mb-6">Tambah Jabatan</h2>

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('jabatan.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label class="block text-sm font-medium text-gray-700">Nama Jabatan</label>
        <input type="text" name="jabatan" class="w-full border border-gray-300 rounded px-4 py-2" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Gaji Pokok</label>
        <input type="number" name="gaji_pokok" class="w-full border border-gray-300 rounded px-4 py-2" required>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Uang Kehadiran / Hari</label>
            <input type="number" name="uang_kehadiran_perhari" class="w-full border border-gray-300 rounded px-4 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Uang Makan</label>
            <input type="number" name="uang_makan" class="w-full border border-gray-300 rounded px-4 py-2">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Bonus</label>
            <input type="number" name="bonus" class="w-full border border-gray-300 rounded px-4 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Tunjangan</label>
            <input type="number" name="tunjangan" class="w-full border border-gray-300 rounded px-4 py-2">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Potongan</label>
        <input type="number" name="potongan" class="w-full border border-gray-300 rounded px-4 py-2">
    </div>

    <div class="flex justify-start gap-4 mt-4">
        <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-600">
            Simpan
        </button>
        <a href="{{ route('jabatan.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
            Batal
        </a>
    </div>
</form>
@endsection
