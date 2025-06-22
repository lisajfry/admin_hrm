<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Task;
use App\Models\Izin;
use App\Models\Lembur;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKaryawan = Karyawan::count();
        $totalAbsensi = Absensi::count();
        $totalTask = Task::count();
        $totalIzin = Izin::count();
        $totalLembur = Lembur::count();

        // Ambil data kehadiran per bulan (dalam 1 tahun terakhir)
        $kehadiranPerBulan = Absensi::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Konversi angka bulan ke nama bulan
        $bulan = $kehadiranPerBulan->pluck('bulan')->map(function ($b) {
            return Carbon::create()->month($b)->translatedFormat('F');
        });

        $kehadiran = $kehadiranPerBulan->pluck('total');

        return view('admin.dashboard', [
            'totalKaryawan' => $totalKaryawan,
            'totalAbsensi' => $totalAbsensi,
            'totalTask' => $totalTask,
            'totalIzin' => $totalIzin,
            'totalLembur' => $totalLembur,
            'bulan' => $bulan,
            'kehadiran' => $kehadiran,
        ]);
    }
}
