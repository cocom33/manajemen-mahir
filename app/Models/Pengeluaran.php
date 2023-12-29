<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'title', 'description', 'date', 'price', 'tagihan_id', 'project_team_fee_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}