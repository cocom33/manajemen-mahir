<?php

namespace App\Livewire;

use Livewire\Component;

class KeuanganPerusahaan extends Component
{
    public function render()
    {
        $data['data'] = KeuanganPerusahaan::where('tahun', Date('Y'))->first();

        return view('livewire.keuangan-perusahaan');
    }
}
