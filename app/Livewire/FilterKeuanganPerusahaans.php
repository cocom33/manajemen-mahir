<?php

namespace App\Livewire;

use App\Models\KeuanganPerusahaan;
use Livewire\Component;

class FilterKeuanganPerusahaans extends Component
{

    public $bulan_id;
    public $query;

    public function render()
    {
        $data['data'] = KeuanganPerusahaan::where('tahun', Date('Y'))->first();
    }

    protected $listeners = ['updatedMonth' => 'updateMonth'];

    public function updateMonth($value)
    {
    }


    public function filter()
    {
        $this->dispatch('show-keuangan-perusahaans', 'reloadDatas', $this->bulan_id, $this->query);
    }

}