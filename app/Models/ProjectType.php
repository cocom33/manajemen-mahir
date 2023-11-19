<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];

    public function project()
    {
        return $this->hasMany(Project::class);
    }
}