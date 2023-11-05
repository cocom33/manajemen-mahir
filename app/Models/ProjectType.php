<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function project()
    {
        return $this->hasMany(Project::class);
    }
}