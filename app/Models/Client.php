<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'wa',
        'email',
        'alamat',
        'sumber',
        'nama_perusahaan',
    ];

    public function project()
    {
        return $this->hasMany(Project::class);
    }

    public function perusahaan(): BelongsToMany
    {
        return $this->belongsToMany(Perusahaan::class);
    }
}
