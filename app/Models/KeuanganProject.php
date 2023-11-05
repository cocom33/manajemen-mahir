<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganProject extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'harga_type'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}