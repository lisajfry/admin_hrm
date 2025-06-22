<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PayrollExport implements FromView
{
    public $rekap;
    public $bulan;
    public $tahun;

    public function __construct($rekap, $bulan, $tahun)
    {
        $this->rekap = $rekap;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        return view('exports.payroll', [
            'rekap' => $this->rekap,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun
        ]);
    }
}

