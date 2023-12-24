<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PorjectTeamFee extends Model
{
    use HasFactory;

    protected $fillable = ['fee', 'photo'];

    public function pengeluaran()
    {
        $this->belongsTo(Pengeluaran::class);
    }

    public function projectTeam() 
    {
    return $this->belongsTo(ProjectTeam::class);
    }
}
