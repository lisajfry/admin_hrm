<?php

namespace App\Http\Controllers;


use App\Models\Lembur;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class LemburController extends Controller
{
   public function index()
{
    $lemburs = Lembur::with('karyawan')->get();
    return view('lembur.index', compact('lemburs'));
}

public function create()
{
    $karyawans = Karyawan::all();
    return view('lembur.create', compact('karyawans'));
}




public function store(Request $request)
{
    

    $validated = $request->validate([
        'id_karyawan' => 'required|exists:karyawans,id',
        'tanggal_lembur' => 'required|date',
        'jam_mulai' => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        'alasan_lembur' => 'nullable|string',
    ]);

    

    $start = \Carbon\Carbon::createFromFormat('H:i', $validated['jam_mulai']);
    $end = \Carbon\Carbon::createFromFormat('H:i', $validated['jam_selesai']);
    $validated['durasi_lembur'] = $start->diffInMinutes($end) / 60;

    Lembur::create($validated);

    return redirect()->route('lembur.index')->with('success', 'Lembur berhasil ditambahkan');
}




 public function edit($id)
    {
        $lembur = Lembur::findOrFail($id);
        $karyawans = Karyawan::all();
        return view('lembur.edit', compact('lembur', 'karyawans'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'id_karyawan' => 'required|exists:karyawans,id',
        'tanggal_lembur' => 'required|date',
        'jam_mulai' => 'required|date_format:H:i:s',
        'jam_selesai' => 'required|date_format:H:i:s|after:jam_mulai',
        'alasan_lembur' => 'nullable|string',
    ]);

    $start = \Carbon\Carbon::createFromFormat('H:i:s', $request->jam_mulai);
    $end = \Carbon\Carbon::createFromFormat('H:i:s', $request->jam_selesai);
    $durasi = $start->diffInMinutes($end) / 60;

    $lembur = Lembur::findOrFail($id);

    $lembur->update([
        'id_karyawan' => $request->id_karyawan,
        'tanggal_lembur' => $request->tanggal_lembur,
        'jam_mulai' => $request->jam_mulai,
        'jam_selesai' => $request->jam_selesai,
        'alasan_lembur' => $request->alasan_lembur,
        'durasi_lembur' => $durasi,
    ]);

    return redirect()->route('lembur.index')->with('success', 'Data berhasil diperbarui.');
}



public function destroy($id)
{
    $lembur = Lembur::findOrFail($id);
    $lembur->delete();

    return redirect()->route('lembur.index')->with('success', 'Lembur berhasil dihapus');
}


}