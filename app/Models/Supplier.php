<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'link', 'note', 'email', 'telephone', 'alamat'];

    public function tagihan() {
        return $this->hasMany(Tagihan::class);
    }

    public function keuanganDetail() {
        return $this->hasMany(KeuanganDetail::class);
    }
}