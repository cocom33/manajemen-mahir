<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganBulanan extends Model
{
    use HasFactory;

    protected $fillable = ['bulan', 'keuangan_perusahaan_id'];

    public function tahun()
    {
        return $this->belongsTo(KeuanganPerusahaan::class);
    }

    public function keuanganDetail()
    {
        return $this->hasMany(KeuanganDetail::class);
    }
}
