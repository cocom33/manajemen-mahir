<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectDocument extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['project_id', 'name', 'link'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}