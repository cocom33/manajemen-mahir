<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'status', 'wa', 'email', 'alamat'];

    public function projectTeam(){
        return $this->belongsTo(ProjectTeam::class);
    }
}
