<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'rekening', 'note'];

    public function keuanganDetail() {
        return $this->hasMany(KeuanganDetail::class);
    }
}
