<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Termin extends Model
{
    use HasFactory;

    protected $fillable = ['keuangan_project_id', 'name'];

    public function keuangan_project()
    {
        return $this->belongsTo(KeuanganProject::class);
    }

    public function termin_fee()
    {
        return $this->hasMany(TerminFee::class);
    }
}