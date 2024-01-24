<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeuanganProject extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['project_id', 'type'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function langsung()
    {
        return $this->hasOne(Langsung::class);
    }

    public function termin()
    {
        return $this->hasMany(Termin::class);
    }
}