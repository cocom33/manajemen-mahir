<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'wa',
        'email',
        'alamat',
        'sumber',
        'nomor_rekening',
        'nama_rekening',
        'nasabah_bank',
        'nama_perusahaan',
    ];

    public function project()
    {
        return $this->hasMany(Project::class);
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function perusahaan()
    {
        return $this->BelongsTo(Perusahaan::class, 'nama_perusahaan', 'id');
    }
}