<?php

namespace App\Exports;

use App\Models\KeuanganDetail;
use App\Models\KeuanganPerusahaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportKeuanganDetail implements FromCollection, WithMapping, ShouldAutoSize, WithHeadings
{
    private $dataIDs;

    public function __construct($dataIDs)
    {
        $this->dataIDs = $dataIDs;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $keuanganDetail = KeuanganDetail::select('keuangan_perusahaan_id', 'description', 'status', 'total', 'tanggal', 'bank_id')->with('keuanganPerusahaan', 'bank')
        ->find($this->dataIDs);

        return $keuanganDetail;
    }


    public function map($keuanganDetail): array
    {
        return [
            $keuanganDetail->tanggal . ' / ' . $keuanganDetail->keuanganPerusahaan->bulan . ' / ' .  $keuanganDetail->keuanganPerusahaan->tahun,
            $keuanganDetail->description,
            $keuanganDetail->bank->name,
            $keuanganDetail->status,
            'Rp ' . number_format($keuanganDetail->total, 0, ',', '.'),
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Title',
            'Bank',
            'Status',
            'Total (Rp)'
        ];
    }
}