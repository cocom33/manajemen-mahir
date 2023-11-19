<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectFee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['project_team_id', 'fee'];

    public function team()
    {
        return $this->belongsTo(ProjectTeam::class);
    }
}