<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Langsung extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['keuangan_project_id', 'project_team_id', 'fee'];

    public function keuangan_project()
    {
        return $this->belongsTo(KeuanganProject::class);
    }

    public function projectTeam()
    {
        return $this->belongsTo(ProjectTeam::class);
    }
}