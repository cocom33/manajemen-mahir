<?php

namespace App\Livewire;

use App\Models\KeuanganBulanan;
use App\Models\KeuanganPerusahaan;
use Livewire\Component;

class FilterKeuanganPerusahaans extends Component
{
    public $bulan_id;
    public $query;

    public function render()
    {
        $data['data'] = KeuanganPerusahaan::where('tahun', Date('Y'))->first();

        return view('livewire.filter-keuangan-perusahaans', $data);
    }

    public function filter()
    {
        $this->dispatch('show-keuangan-perusahaans', 'reloadDatas', $this->bulan_id, $this->query);
    }
}
