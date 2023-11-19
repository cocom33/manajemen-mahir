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
    public $selectedMonth;
    protected $listeners = ['monthUpdated' => 'updateMonth'];

    public function mount()
    {
        $this->updateMonth(null);
    }

    public function updateMonth($month)
    {
        $this->selectedMonth = $month;
        $this->keuanganDetails = KeuanganDetail::with('keuanganBulanan')->latest();

        if ($this->selectedMonth) {
            $this->keuanganDetails = $this->keuanganDetails->whereMonth('tanggal', $this->selectedMonth);
        }

        $this->keuanganDetails = $this->keuanganDetails->get();
    }

    public function render()
    {
        return view('livewire.show-keuangan-perusahaans');
    }
}
