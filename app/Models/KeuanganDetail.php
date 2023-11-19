<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeuanganDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['keuangan_bulanan_id', 'description', 'total'];

    public function bulan()
    {
        return $this->belongsTo(KeuanganBulanan::class);
    }
}