<?php

namespace App\Livewire;

use App\Models\KeuanganPerusahaan;
use Livewire\Component;

class ShowKeuanganPerusahaans extends Component
{
    public $keuanganPerusahaans;

    public function mount()
    {
        $this->keuanganPerusahaans = KeuanganPerusahaan::get();
    }

    public function render()
    {
        return view('livewire.show-keuangan-perusahaans');
    }
}
