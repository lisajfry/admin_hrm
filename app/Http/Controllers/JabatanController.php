<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    // Tampilkan semua jabatan
    public function index()
    {
        $jabatans = Jabatan::all();
        return view('jabatan.index', compact('jabatans'));
    }

    // Form tambah jabatan
    public function create()
    {
        return view('jabatan.create');
    }

    // Simpan data jabatan
    public function store(Request $request)
    {
        $request->validate([
            'jabatan' => 'required|string|max:100',
            'gaji_pokok' => 'required|numeric|min:0',
            'uang_kehadiran_perhari' => 'nullable|numeric|min:0',
            'uang_makan' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'tunjangan' => 'nullable|numeric|min:0',
            'potongan' => 'nullable|numeric|min:0',
        ]);

        Jabatan::create($request->all());

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    // Form edit jabatan
    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return view('jabatan.edit', compact('jabatan'));
    }

    // Update data jabatan
    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $request->validate([
            'jabatan' => 'required|string|max:100',
            'gaji_pokok' => 'required|numeric|min:0',
            'uang_kehadiran_perhari' => 'nullable|numeric|min:0',
            'uang_makan' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'tunjangan' => 'nullable|numeric|min:0',
            'potongan' => 'nullable|numeric|min:0',
        ]);

        $jabatan->update($request->all());

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diperbarui.');
    }

    // Hapus jabatan
    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus.');
    }
}
