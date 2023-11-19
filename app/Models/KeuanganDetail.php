<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeuanganDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['keuangan_bulanan_id', 'description', 'total'];

    /**
     * Get the bulan that owns the KeuanganDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function keuanganBulanan(): BelongsTo
    {
        return $this->belongsTo(KeuanganBulanan::class);
    }
}