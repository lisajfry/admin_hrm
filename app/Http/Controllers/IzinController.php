<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Izin;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class IzinController extends Controller
{
    // Mengambil semua izin untuk user yang sedang login
    public function index()
{
    $izins = Izin::with('karyawan')->orderBy('tgl_mulai', 'desc')->get();
    return view('izin.index', compact('izins'));



    // Ambil parameter bulan dan tahun dari query string
    $bulan = $request->query('bulan');
    $tahun = $request->query('tahun');

    // Query izin dengan filter bulan dan tahun jika ada
    $izins = Izin::where('id_karyawan', $userId)
        ->when($bulan, function ($query) use ($bulan) {
            $query->whereMonth('tgl_mulai', $bulan);
        })
        ->when($tahun, function ($query) use ($tahun) {
            $query->whereYear('tgl_mulai', $tahun);
        })
        ->get();

    return response()->json($izins);
}

public function create()
{
    $karyawans = Karyawan::all();
    return view('izin.create', compact('karyawans'));
}

public function edit($id)
{
    $izin = Izin::findOrFail($id);
    $karyawans = Karyawan::all();

    return view('izin.edit', compact('izin', 'karyawans'));
}


public function store(Request $request)
{
    $request->validate([
        'id_karyawan' => 'required|exists:karyawans,id',
        'tgl_mulai' => 'required|date',
        'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        'alasan' => 'required|string',
        'keterangan' => 'required|string',
    ]);

    // Hitung durasi
    $tglMulai = Carbon::parse($request->tgl_mulai);
    $tglSelesai = Carbon::parse($request->tgl_selesai);
    $durasi = $tglSelesai->diffInDays($tglMulai) + 1;

    Izin::create([
        'id_karyawan' => $request->id_karyawan,
        'tgl_mulai' => $request->tgl_mulai,
        'tgl_selesai' => $request->tgl_selesai,
        'alasan' => $request->alasan,
        'keterangan' => $request->keterangan,
        'durasi' => $durasi,
    ]);

    return redirect()->route('izin.index')->with('success', 'Izin berhasil ditambahkan.');
}


    // Menampilkan izin berdasarkan ID
    public function show($id)
    {
        $izin = Izin::where('id', $id)->where('id_karyawan', Auth::id())->firstOrFail();
        return response()->json($izin);
    }

    // Mengupdate izin
    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'id_karyawan' => 'required|exists:karyawans,id',
        'tgl_mulai' => 'required|date',
        'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        'keterangan' => 'required|string|max:255',
    ]);

    $izin = Izin::findOrFail($id);
    $izin->update($validated);

    return redirect()->route('izin.index')->with('success', 'Data izin berhasil diperbarui.');
}



    // Menghapus izin
    public function destroy($id)
{
    $izin = Izin::findOrFail($id);
    $izin->delete();

    return redirect()->route('izin.index')->with('success', 'Data izin berhasil dihapus.');
}

}