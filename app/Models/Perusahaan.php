<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $fillable = ['pemilik', 'nama_perusahaan', 'email', 'alamat', 'list_client'];

    public function clients() 
    {
        return $this->hasMany(Client::class);
    }
}
