<?php

namespace App\Livewire;

use App\Exports\ExportKeuanganDetail;
use App\Models\Bank;
use App\Models\KeuanganDetail;
use App\Models\KeuanganPerusahaan;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Keuangan extends Component
{
    public $tahun;
    public $bulan;
    public $bank;
    public Collection $selectedDatas;

    public function mount()
    {
        $this->tahun = 'semua';
        $this->bulan = 'semua';
        $this->bank = 'semua';
        $this->selectedDatas = collect();
    }

    public function render()
    {
        $data['all'] = KeuanganPerusahaan::groupBy('tahun')->pluck('tahun');
        $data['filtertahun'] = KeuanganPerusahaan::groupBy('tahun')->pluck('tahun');
        $data['filterbulan'] = [1,2,3,4,5,6,7,8,9,10,11,12];

        $data['banks'] = Bank::get();
        $data['filterbank'] = Bank::pluck('id');

        if($this->tahun != 'semua') {
            $data['filtertahun'] = [$this->tahun];
        }

        if($this->bulan != 'semua') {
            $data['filterbulan'] = [$this->bulan];
        }

        if($this->bank != 'semua') {
            $data['filterbank'] = [$this->bank];
        }

        $master = KeuanganPerusahaan::whereIn('tahun', $data['filtertahun'])->whereIn('bulan', $data['filterbulan'])->pluck('id');

        $data['detail'] = KeuanganDetail::whereIn('keuangan_perusahaan_id', $master)->whereIn('bank_id', $data['filterbank'])->orderBy('created_at', 'desc')->get();
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
        $this->bank = $bank;
    }

    public function getSelectedDatas()
    {
        return $this->selectedDatas->filter(fn($p) => $p)->keys();
    }


    public function export($ext)
    {
        abort_if(!in_array($ext, ['csv', 'xlsx', 'pdf']), Response::HTTP_NOT_FOUND);

        return Excel::download(new ExportKeuanganDetail($this->getSelectedDatas()), 'keuangan.'.$ext);
    }
}
