<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Models\InvoiceSystem;
use App\Models\KeuanganBulanan;
use App\Models\KeuanganDetail;
use App\Models\KeuanganPerusahaan;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class KeuanganPerusahaans extends Component
{
    public $byBulans = null;
    public $perPage = 10;
    public $search;


    public function render()
    {

        return view('livewire.keuangan-perusahaans',[
            'tahuns' => KeuanganPerusahaan::get(),
            'bulans' => KeuanganBulanan::get(),

            'keuanganDetails' => KeuanganDetail::when($this->byBulans, function($query){
                        $query->where('keuangan_bulanan_id', $this->byBulans);
                    })
                    ->search(trim($this->search))
                    ->orderBy('id', 'asc')
                    ->paginate($this->perPage)
                ]);
                Log::info();
    }
}
