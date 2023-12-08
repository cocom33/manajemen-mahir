<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Models\InvoiceOther;
use App\Models\InvoiceSystem;
use App\Models\KeuanganBulanan;
use App\Models\KeuanganPerusahaan;
use Livewire\Component;

class Keuangan extends Component
{
    public $tahun;
    public $bulan;

    public function mount()
    {
        $this->tahun = date('Y');
        $this->bulan = date('m');
    }

    public function render()
    {
        $data['now'] = KeuanganPerusahaan::where('tahun', $this->tahun)->first();
        $data['all'] = KeuanganPerusahaan::get();

        $data['detail'] = KeuanganBulanan::where([['keuangan_perusahaan_id', $data['now']->id], ['bulan', $this->bulan]])->first();
        $data['invoiceSystem'] = InvoiceSystem::with('invoice')->get();
        $data['invoiceOther'] = InvoiceOther::with('invoice')->get();
        $data['invoice'] = Invoice::with('project')->first();
        return view('livewire.keuangan', $data);
    }

    public function changeb($bulan)
    {
        $this->bulan = $bulan;
    }

    public function changet($tahun)
    {
        $this->tahun = $tahun;
    }
}