<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectTeam extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['project_id', 'team_id', 'fee', 'status'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function project_fee()
    {
        return $this->hasMany(ProjectFee::class);
    }
}