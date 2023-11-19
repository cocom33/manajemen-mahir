<?php

namespace App\Livewire;

use App\Models\KeuanganPerusahaan;
use Livewire\Component;

class FilterKeuanganPerusahaans extends Component
{
    public $selectedMonth;

    protected $listeners = ['updatedMonth' => 'updateMonth'];

    public function updateMonth($value)
    {
        $this->selectedMonth = $value;
        // Update your data based on the selected month...
    }

    public function render()
{
    if ($this->selectedMonth) {
        $data['data'] = KeuanganPerusahaan::where('tahun', Date('Y'))
            ->whereMonth('tanggal', $this->selectedMonth)
            ->first();
    } else {
        $data['data'] = KeuanganPerusahaan::where('tahun', Date('Y'))->first();
    }

    return view('livewire.filter-keuangan-perusahaans', $data);
}

}
