<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganPerusahaan extends Model
{
    use HasFactory;

    protected $fillable = ['tahun'];

    public function bulan()
    {
        return $this->hasMany(KeuanganBulanan::class);
    }
}
