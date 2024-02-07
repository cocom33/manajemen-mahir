<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeuanganPerusahaan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['tahun', 'bulan'];

    public function detail()
    {
        return $this->hasMany(KeuanganDetail::class);
    }

}
