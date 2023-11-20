<?php

namespace App\Livewire;

use App\Models\KeuanganBulanan;
use App\Models\KeuanganDetail;
use App\Models\KeuanganPerusahaan;
use Livewire\Component;

class KeuanganPerusahaans extends Component
{
    public $byBulans = null;
    public $perPage = 10;
    public $search;


    public function render()
    {

        return view('livewire.keuangan-perusahaans',[
            'tahuns' => KeuanganPerusahaan::get(),
            'bulans' => KeuanganBulanan::orderBy('bulan', 'asc')->get(),
            'keuanganDetails' => KeuanganDetail::when($this->byBulans, function($query){
                                                        $query->where('keuangan_bulanan_id', $this->byBulans);
                                                    })
                                                    ->search(trim($this->search))
                                                    ->paginate($this->perPage)
        ]);
    }
}
