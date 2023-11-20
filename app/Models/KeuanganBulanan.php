<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeuanganBulanan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['bulan', 'keuangan_perusahaan_id'];

    public function tahun()
    {
        return $this->belongsTo(KeuanganPerusahaan::class);
    }

    public function keuanganDetail()
    {
        return $this->hasMany(KeuanganDetail::class);
    }

    public function getMonthNames($value)
    {
       return \Carbon\Carbon::create()->month($value)->format('F');
    }
}
