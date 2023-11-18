<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status', 'wa', 'email', 'alamat'];

    public function projectTeam(){
        return $this->belongsTo(ProjectTeam::class);
    }
}
