<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TerminFee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['termin_id', 'project_team_id', 'fee'];

    public function termin()
    {
        return $this->belongsTo(Termin::class);
    }

    public function project_team()
    {
        return $this->belongsTo(ProjectTeam::class);
    }
}