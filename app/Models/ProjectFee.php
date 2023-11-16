<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectFee extends Model
{
    use HasFactory;

    protected $fillable = ['project_team_id', 'fee'];

    public function team()
    {
        return $this->belongsTo(ProjectTeam::class);
    }
}
