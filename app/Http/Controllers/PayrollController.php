<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izin;
use App\Models\DinasLuarKota;
use App\Models\Absensi; // Tambahkan model Absensi
use App\Models\Lembur; // Tambahkan model Absensi
use App\Models\Task; // Tambahkan model Task
use App\Models\Karyawan;
use Illuminate\Support\Facades\DB;
use App\Exports\PayrollExport;
use Maatwebsite\Excel\Facades\Excel;


use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;

class PayrollController extends Controller
{
    // Fungsi untuk menghitung hari kerja dalam rentang tanggal (tidak termasuk Minggu dan hari libur nasional)
    protected function calculateWorkingDays($startDate, $endDate, $holidays = [])
    {
        $workingDays = 0;
        $currentDate = $startDate->copy();
        
        while ($currentDate->lte($endDate)) {
            // Hitung hanya jika bukan hari Minggu dan bukan hari libur nasional
            if (!$currentDate->isSunday() && !in_array($currentDate->format('Y-m-d'), $holidays)) {
                $workingDays++;
            }
            $currentDate->addDay();
        }
         
        return $workingDays;
    }

    // Mendapatkan rekap jumlah izin, cuti, dan dinas luar kota serta kehadiran selama satu bulan
  public function getPayrollSummary(Request $request)
{
    try {
        $currentMonth = $request->input('month', Carbon::now()->month);
        $currentYear = $request->input('year', Carbon::now()->year);

        $availableMonthsYears = Izin::query()
            ->selectRaw('YEAR(tgl_mulai) as year, MONTH(tgl_mulai) as month')
            ->union(DinasLuarKota::query()->selectRaw('YEAR(tgl_berangkat) as year, MONTH(tgl_berangkat) as month'))
            ->union(Absensi::query()->selectRaw('YEAR(tanggal) as year, MONTH(tanggal) as month'))
            ->union(Lembur::query()->selectRaw('YEAR(tanggal_lembur) as year, MONTH(tanggal_lembur) as month'))
            ->distinct()
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $isValidFilter = $availableMonthsYears->contains(fn($item) =>
            $item->month == $currentMonth && $item->year == $currentYear
        );

        if (!$isValidFilter) {
            return back()->with('error', 'Filter bulan/tahun tidak valid.');
        }

        // Buat daftar semua karyawan untuk ditampilkan
        $karyawans = \App\Models\Karyawan::with('jabatan')->get();

        $holidays = ['2024-01-01', '2024-03-11', '2024-05-01'];

        $rekap = [];

        foreach ($karyawans as $karyawan) {
            $id = $karyawan->id;

            $izin = Izin::where('id_karyawan', $id)
                ->where('alasan', 'IZIN')
                ->whereMonth('tgl_mulai', $currentMonth)
                ->whereYear('tgl_mulai', $currentYear)
                ->get()
                ->sum(fn($i) => $this->calculateWorkingDays(Carbon::parse($i->tgl_mulai), Carbon::parse($i->tgl_selesai), $holidays));

            $cuti = Izin::where('id_karyawan', $id)
                ->where('alasan', 'CUTI')
                ->whereMonth('tgl_mulai', $currentMonth)
                ->whereYear('tgl_mulai', $currentYear)
                ->get()
                ->sum(fn($c) => $this->calculateWorkingDays(Carbon::parse($c->tgl_mulai), Carbon::parse($c->tgl_selesai), $holidays));

            $dinas = DinasLuarKota::where('id_karyawan', $id)
                ->whereMonth('tgl_berangkat', $currentMonth)
                ->whereYear('tgl_berangkat', $currentYear)
                ->get()
                ->sum(fn($d) => $this->calculateWorkingDays(Carbon::parse($d->tgl_berangkat), Carbon::parse($d->tgl_kembali), $holidays));

            $kehadiran = Absensi::where('id_karyawan', $id)
                ->whereMonth('tanggal', $currentMonth)
                ->whereYear('tanggal', $currentYear)
                ->distinct('tanggal')
                ->count('tanggal');

            $lembur = Lembur::where('id_karyawan', $id)
                ->whereMonth('tanggal_lembur', $currentMonth)
                ->whereYear('tanggal_lembur', $currentYear)
                ->sum('durasi_lembur');

            $point = Task::where('id_karyawan', $id)
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('point');

            $terlambat = Absensi::where('id_karyawan', $id)
                ->whereMonth('tanggal', $currentMonth)
                ->whereYear('tanggal', $currentYear)
                ->where('jam_masuk', '>', '08:00:00')
                ->count();

            $rekap[] = [
                'karyawan' => $karyawan,
                'izin' => $izin,
                'cuti' => $cuti,
                'dinas' => $dinas,
                'kehadiran' => $kehadiran,
                'lembur' => $lembur,
                'point' => $point,
                'terlambat' => $terlambat,
            ];
        }

        return view('payroll.index', [
            'bulan' => $currentMonth,
            'tahun' => $currentYear,
            'filters' => $availableMonthsYears,
            'rekap' => $rekap,
        ]);
    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

public function generateSlipGaji(Request $request)
{
    try {
        $id_karyawan = $request->input('id_karyawan');

        // Ambil data karyawan manual (bukan Auth::user)
        $user = \App\Models\Karyawan::with('jabatan')->findOrFail($id_karyawan);

        $jabatan = $user->jabatan;
        if (!$jabatan) {
            return response()->json(['error' => 'Jabatan tidak ditemukan untuk karyawan ini'], 404);
        }

        // Ambil bulan dan tahun dari request
        $bulan = $request->input('month', now()->month);
        $tahun = $request->input('year', now()->year);

        // Replikasi proses seperti getPayrollSummary untuk satu karyawan
        $holidays = ['2024-01-01', '2024-03-11', '2024-05-01'];
        $controller = new self(); // atau gunakan $this kalau semua logicnya dalam class ini

        $izin = \App\Models\Izin::where('id_karyawan', $user->id)
            ->where('alasan', 'IZIN')
            ->whereMonth('tgl_mulai', $bulan)
            ->whereYear('tgl_mulai', $tahun)
            ->get()
            ->sum(fn($item) => $controller->calculateWorkingDays(\Carbon\Carbon::parse($item->tgl_mulai), \Carbon\Carbon::parse($item->tgl_selesai), $holidays));

        $cuti = \App\Models\Izin::where('id_karyawan', $user->id)
            ->where('alasan', 'CUTI')
            ->whereMonth('tgl_mulai', $bulan)
            ->whereYear('tgl_mulai', $tahun)
            ->get()
            ->sum(fn($item) => $controller->calculateWorkingDays(\Carbon\Carbon::parse($item->tgl_mulai), \Carbon\Carbon::parse($item->tgl_selesai), $holidays));

        $dinas = \App\Models\DinasLuarKota::where('id_karyawan', $user->id)
            ->whereMonth('tgl_berangkat', $bulan)
            ->whereYear('tgl_berangkat', $tahun)
            ->get()
            ->sum(fn($item) => $controller->calculateWorkingDays(\Carbon\Carbon::parse($item->tgl_berangkat), \Carbon\Carbon::parse($item->tgl_kembali), $holidays));

        $kehadiran = \App\Models\Absensi::where('id_karyawan', $user->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->distinct('tanggal')
            ->count('tanggal');

        $lembur = \App\Models\Lembur::where('id_karyawan', $user->id)
            ->whereMonth('tanggal_lembur', $bulan)
            ->whereYear('tanggal_lembur', $tahun)
            ->sum('durasi_lembur');

        $point = \App\Models\Task::where('id_karyawan', $user->id)
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->sum('point');

        $terlambat = \App\Models\Absensi::where('id_karyawan', $user->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('jam_masuk', '>', '08:00:00')
            ->count();

        $total_kehadiran = $kehadiran + $dinas;
        $uang_kehadiran = $total_kehadiran * ($jabatan->uang_kehadiran_perhari ?? 0);
        $uang_makan = $total_kehadiran * ($jabatan->uang_makan ?? 0);
        $total_bonus = $lembur * ($jabatan->bonus ?? 0) + $point * ($jabatan->bonus ?? 0);
        $total_potongan = $terlambat * ($jabatan->potongan ?? 0);

        $data = [
            'nama_karyawan' => $user->nama_karyawan,
            'nama_jabatan' => $jabatan->jabatan ?? '-',
            'bulan' => \Carbon\Carbon::create()->month($bulan)->format('F'),
            'tahun' => $tahun,
            'izin' => $izin,
            'cuti' => $cuti,
            'dinas_luar_kota' => $dinas,
            'kehadiran' => $kehadiran,
            'total_kehadiran' => $total_kehadiran,
            'lembur' => $lembur,
            'point' => $point,
            'uang_kehadiran' => $uang_kehadiran,
            'uang_kehadiran_perhari' => $jabatan->uang_kehadiran_perhari ?? 0,
            'uang_makan' => $uang_makan,
            'uang_makan_perhari' => $jabatan->uang_makan ?? 0,
            'gaji_pokok' => $jabatan->gaji_pokok ?? 0,
            'tunjangan' => $jabatan->tunjangan ?? 0,
            'bonus' => $jabatan->bonus ?? 0,
            'total_bonus' => $total_bonus,
            'terlambat' => $terlambat,
            'uang_potongan' => $jabatan->potongan ?? 0,
            'total_potongan' => $total_potongan,
        ];

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.slip_gaji', $data);
        return $pdf->stream("slip_gaji_{$user->nama_karyawan}_{$data['bulan']}_{$data['tahun']}.pdf");

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function exportExcel(Request $request)
{
    $bulan = $request->input('month', now()->month);
    $tahun = $request->input('year', now()->year);

    $rekap = $this->getAllRekapData($bulan, $tahun); // Kamu perlu buat method ini juga

    return Excel::download(new PayrollExport($rekap, $bulan, $tahun), "rekap_payroll_{$bulan}_{$tahun}.xlsx");
}


private function getAllRekapData($bulan, $tahun)
{
    $rekap = [];
    $karyawans = \App\Models\Karyawan::with('jabatan')->get();

    foreach ($karyawans as $karyawan) {
        $rekap[] = [
            'karyawan' => $karyawan,
            'izin' => Izin::where('id_karyawan', $karyawan->id)->where('alasan', 'IZIN')->whereMonth('tgl_mulai', $bulan)->whereYear('tgl_mulai', $tahun)->count(),
            'cuti' => Izin::where('id_karyawan', $karyawan->id)->where('alasan', 'CUTI')->whereMonth('tgl_mulai', $bulan)->whereYear('tgl_mulai', $tahun)->count(),
            'dinas' => DinasLuarKota::where('id_karyawan', $karyawan->id)->whereMonth('tgl_berangkat', $bulan)->whereYear('tgl_berangkat', $tahun)->count(),
            'kehadiran' => Absensi::where('id_karyawan', $karyawan->id)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->count(),
            'lembur' => Lembur::where('id_karyawan', $karyawan->id)->whereMonth('tanggal_lembur', $bulan)->whereYear('tanggal_lembur', $tahun)->sum('durasi_lembur'),
            'point' => Task::where('id_karyawan', $karyawan->id)->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->sum('point'),
            'terlambat' => Absensi::where('id_karyawan', $karyawan->id)->where('jam_masuk', '>', '08:00:00')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->count(),
        ];
    }

    return $rekap;
}



}