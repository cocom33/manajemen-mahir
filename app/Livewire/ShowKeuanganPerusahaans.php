<?php

namespace App\Livewire;

use App\Models\KeuanganBulanan;
use App\Models\KeuanganDetail;
use App\Models\KeuanganPerusahaan;
use Livewire\Component;

class ShowKeuanganPerusahaans extends Component
{
    public $keuanganDetails;
    public $keuanganBulanans;

    public function mount()
    {
        $this->keuanganDetails = KeuanganDetail::with('keuanganBulanan')->latest()->get();
        // $this->keuanganBulanans = KeuanganBulanan::with('keuanganDetail')->get();
    }
    public function render()
    {
        return view('livewire.show-keuangan-perusahaans');
    }
}
