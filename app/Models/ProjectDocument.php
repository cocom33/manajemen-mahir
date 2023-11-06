<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDocument extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'name', 'link'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}