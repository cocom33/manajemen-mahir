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

    protected $fillable = ['keuangan_perusahaan_id', 'description', 'total', 'status', 'tanggal'];

    /**
     * Get the bulan that owns the KeuanganDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function keuanganPerusahaan(): BelongsTo
    {
        return $this->belongsTo(KeuanganPerusahaan::class);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('description', 'like', $term);
        });
    }
}