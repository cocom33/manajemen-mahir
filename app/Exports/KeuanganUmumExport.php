<?php

namespace App\Exports;

use App\Models\KeuanganPerusahaan;
use Maatwebsite\Excel\Concerns\FromCollection;

class KeuanganUmumExport implements FromCollection
{

  private $tahun;
  private $bulan;

  public function __construct(int $tahun, int $bulan)
  {
    $this->tahun = $tahun;
    $this->bulan = $bulan;
  }

  public function collection()
  {
    return KeuanganPerusahaan::whereYear('tanggal', $this->tahun)
                              ->whereMonth('tanggal', $this->bulan)
                              ->get();
  }


}
