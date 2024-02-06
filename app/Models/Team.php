<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'status', 'skill', 'wa', 'email', 'alamat','nasabah','no_rekening', 'nama_rekening', 'foto_ktp', 'pas_foto', 'cv'];

    public function skill(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }

    public function projectTeam(){
        return $this->hasMany(ProjectTeam::class);
    }

}
