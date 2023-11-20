<?php

namespace App\Livewire;

use App\Models\KeuanganBulanan;
use App\Models\KeuanganDetail;
use App\Models\KeuanganPerusahaan;
use Livewire\Component;

class ShowKeuanganPerusahaans extends Component
{
    public $keuanganDetails;

    protected $listeners = ['reloadDatas' => 'reloadDatas'];

    public function mount()
    {
        $this->keuanganDetails = KeuanganDetail::with('keuanganBulanan')->latest()->get();
    }

    public function render()
    {
        return view('livewire.show-keuangan-perusahaans');
    }


    public function reloadDatas($bulan_id, $query)
    {
        $this->keuanganDetails = KeuanganDetail::query();

        if ($bulan_id) {
            $this->keuanganDetails = $this->keuanganDetails->where('bulan_id', $bulan_id);
        }

        if ($query) {
            $this->keuanganDetails = $this->keuanganDetails->where('description', 'like', '%' . $query . '%');
        }

        $this->keuanganDetails = $this->keuanganDetails->get();
    }
}
