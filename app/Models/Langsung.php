<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langsung extends Model
{
    use HasFactory;

    protected $fillable = ['keuangan_project_id', 'name'];

    public function keuangan_project()
    {
        return $this->belongsTo(KeuanganProject::class);
    }
}