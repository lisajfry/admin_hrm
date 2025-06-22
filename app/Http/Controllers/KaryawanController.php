<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::with('jabatan')->get();
        return view('karyawan', compact('karyawans'));
    }

    public function create()
    {
        $jabatan = Jabatan::all();
        return view('karyawan.create', compact('jabatan'));
    }

    public function store(Request $request)
{
    try {
        $request->validate([
            'nama_karyawan' => 'required|string|max:100',
            'nip'           => 'required|string|unique:karyawans,nip',
            'nik'           => 'required|string|unique:karyawans,nik',
            'email'         => 'required|email|unique:karyawans,email',
            'no_handphone'  => 'required|string',
            'alamat'        => 'required|string',
            'jabatan_id'    => 'nullable|exists:jabatan,id',
            'password'      => 'required|string|min:6',
        ]);

        Karyawan::create([
            'nama_karyawan' => $request->nama_karyawan,
            'nip'           => $request->nip,
            'nik'           => $request->nik,
            'email'         => $request->email,
            'no_handphone'  => $request->no_handphone,
            'alamat'        => $request->alamat,
            'jabatan_id'    => $request->jabatan_id,
            'password'      => Hash::make($request->password),
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');

    } catch (\Exception $e) {
        return back()->with('error', 'Gagal menambahkan karyawan: ' . $e->getMessage());
    }
}


    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $jabatan = Jabatan::all();
        return view('karyawan.edit', compact('karyawan', 'jabatan'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $request->validate([
            'nama_karyawan' => 'required|string|max:100',
            'nip'           => 'required|string|unique:karyawans,nip,' . $id,
            'nik'           => 'required|string|unique:karyawans,nik,' . $id,
            'email'         => 'required|email|unique:karyawans,email,' . $id,
            'no_handphone'  => 'required|string',
            'alamat'        => 'required|string',
            'jabatan_id'    => 'nullable|exists:jabatan,id',
        ]);

        $karyawan->update([
            'nama_karyawan' => $request->nama_karyawan,
            'nip'           => $request->nip,
            'nik'           => $request->nik,
            'email'         => $request->email,
            'no_handphone'  => $request->no_handphone,
            'alamat'        => $request->alamat,
            'jabatan_id'    => $request->jabatan_id,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan diperbarui.');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
