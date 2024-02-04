<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Langsung extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;

    protected $fillable = ['keuangan_project_id', 'bank_id', 'name', 'slug', 'status', 'tanggal', 'lampiran', 'price'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }


    public function keuangan_project()
    {
        return $this->belongsTo(KeuanganProject::class);
    }

    public function projectTeam()
    {
        return $this->belongsTo(ProjectTeam::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}