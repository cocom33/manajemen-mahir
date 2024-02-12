<?php

namespace App\Livewire;

use App\Models\Bank;
use App\Models\KeuanganDetail;
use App\Models\KeuanganPerusahaan;
use Livewire\Component;

class Keuangan extends Component
{
    public $tahun = 'semua';
    public $bulan = 'semua';
    public $bank = 'semua';

    public function render()
    {
        $data['all'] = KeuanganPerusahaan::groupBy('tahun')->pluck('tahun');
        $filtertahun = KeuanganPerusahaan::groupBy('tahun')->pluck('tahun');
        $filterbulan = [1,2,3,4,5,6,7,8,9,10,11,12];

        $data['banks'] = Bank::get();
        $filterbank = Bank::pluck('id');

        if($this->tahun != 'semua') {
            $filtertahun = [$this->tahun];
        }

        if($this->bulan != 'semua') {
            $filterbulan = [$this->bulan];
        } else {
            $filterbulan = [1,2,3,4,5,6,7,8,9,10,11,12];
        }

        if($this->bank != 'semua') {
            $filterbank = [$this->bank];
        }

        $bapak = KeuanganPerusahaan::get();
        $master = $bapak->whereIn('tahun', $filtertahun)->whereIn('bulan', $filterbulan)->pluck('id');

        $tes = KeuanganDetail::orderBy('created_at', 'desc')->get();
        $data['detail'] = $tes->whereIn('keuangan_perusahaan_id', $master)->whereIn('bank_id', $filterbank);
        $data['kas'] = KeuanganDetail::get();

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

    public function changebank($bank)
    {
        // dd($bank);
        $this->bank = $bank;
    }
}