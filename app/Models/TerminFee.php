<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminFee extends Model
{
    use HasFactory;

    protected $fillable = ['termin_id', 'project_team_id', 'fee'];

    public function termin()
    {
        return $this->belongsTo(Termin::class);
    }

    public function team()
    {
        return $this->belongsTo(ProjectTeam::class);
    }
}