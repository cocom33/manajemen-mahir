<?php

namespace App\Livewire;

use App\Models\KeuanganPerusahaan;
use Livewire\Component;

class FilterKeuanganPerusahaans extends Component
{
    public function render()
    {
        $data['data'] = KeuanganPerusahaan::where('tahun', Date('Y'))->first();

        return view('livewire.filter-keuangan-perusahaans', $data);
    }
}
