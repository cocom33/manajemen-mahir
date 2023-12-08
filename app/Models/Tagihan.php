<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'title', 'description', 'harga_awal', 'harga_asli', 'total', 'date_start', 'date', 'date_type', 'is_active', 'is_lunas'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}