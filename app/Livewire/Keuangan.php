<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Models\InvoiceOther;
use App\Models\InvoiceSystem;
use App\Models\KeuanganBulanan;
use App\Models\KeuanganDetail;
use App\Models\KeuanganPerusahaan;
use Livewire\Component;

class Keuangan extends Component
{
    public $tahun;
    public $bulan;

    public function mount()
    {
        $this->tahun = 'semua';
        $this->bulan = 'semua';
    }

    public function render()
    {
        $data['all'] = KeuanganPerusahaan::groupBy('tahun')->pluck('tahun');
        $data['filtertahun'] = KeuanganPerusahaan::groupBy('tahun')->pluck('tahun');
        $data['filterbulan'] = [1,2,3,4,5,6,7,8,9,10,11,12];

        if($this->tahun != 'semua') {
            $data['filtertahun'] = [$this->tahun];
        }

        if($this->bulan != 'semua') {
            $data['filterbulan'] = [$this->bulan];
        }

        $master = KeuanganPerusahaan::whereIn('tahun', $data['filtertahun'])->whereIn('bulan', $data['filterbulan'])->pluck('id');

        $data['detail'] = KeuanganDetail::whereIn('keuangan_perusahaan_id', $master)->get();

        return view('livewire.keuangan', $data);
    }

    public function changeb($bulan)
    {
        $this->bulan = $bulan;
    }

    public function changet($tahun)
    {
        $this->tahun = $tahun;
    }
}