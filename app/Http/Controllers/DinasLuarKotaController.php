<?php

namespace App\Http\Controllers;

use App\Models\DinasLuarKota;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DinasLuarKotaController extends Controller
{
    public function index()
    {
        $dinass = DinasLuarKota::with('karyawan')->get();
        return view('dinas.index', compact('dinass'));
    }

    public function create()
    {
        $karyawans = Karyawan::all();
        return view('dinas.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawans,id',
            'tgl_berangkat' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_berangkat',
            'kota_tujuan' => 'required|string',
            'keperluan' => 'required|string',
            'biaya_transport' => 'required|numeric',
            'biaya_penginapan' => 'required|numeric',
            'uang_harian' => 'required|numeric',
        ]);

        $totalBiaya = $request->biaya_transport + $request->biaya_penginapan + 
                      ($request->uang_harian * $this->calculateDays($request->tgl_berangkat, $request->tgl_kembali));

        DinasLuarKota::create([
            'id_karyawan' => $request->id_karyawan,
            'tgl_berangkat' => $request->tgl_berangkat,
            'tgl_kembali' => $request->tgl_kembali,
            'kota_tujuan' => $request->kota_tujuan,
            'keperluan' => $request->keperluan,
            'biaya_transport' => $request->biaya_transport,
            'biaya_penginapan' => $request->biaya_penginapan,
            'uang_harian' => $request->uang_harian,
            'total_biaya' => $totalBiaya,
        ]);

        return redirect()->route('dinas.index')->with('success', 'Data dinas luar kota berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dinas = DinasLuarKota::findOrFail($id);
        $karyawans = Karyawan::all();
        return view('dinas.edit', compact('dinas', 'karyawans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawans,id',
            'tgl_berangkat' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_berangkat',
            'kota_tujuan' => 'required|string',
            'keperluan' => 'required|string',
            'biaya_transport' => 'required|numeric',
            'biaya_penginapan' => 'required|numeric',
            'uang_harian' => 'required|numeric',
        ]);

        $dinas = DinasLuarKota::findOrFail($id);

        $totalBiaya = $request->biaya_transport + $request->biaya_penginapan + 
                      ($request->uang_harian * $this->calculateDays($request->tgl_berangkat, $request->tgl_kembali));

        $dinas->update([
            'id_karyawan' => $request->id_karyawan,
            'tgl_berangkat' => $request->tgl_berangkat,
            'tgl_kembali' => $request->tgl_kembali,
            'kota_tujuan' => $request->kota_tujuan,
            'keperluan' => $request->keperluan,
            'biaya_transport' => $request->biaya_transport,
            'biaya_penginapan' => $request->biaya_penginapan,
            'uang_harian' => $request->uang_harian,
            'total_biaya' => $totalBiaya,
        ]);

        return redirect()->route('dinas.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dinas = DinasLuarKota::findOrFail($id);
        $dinas->delete();

        return redirect()->route('dinas.index')->with('success', 'Data berhasil dihapus.');
    }

    private function calculateDays($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        return $end->diffInDays($start) + 1;
    }
}
