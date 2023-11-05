<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    use sluggable;

    protected $fillable = [
        'name',
        'slug',
        'client_id',
        'description',
        'status',
        'project_type',
        'start_date',
        'deadline_date',
        'harga_penawaran',
        'harga_deal',
        'status_server',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function projectDocuments()
    {
        return $this->hasMany(ProjectDocument::class);
    }

    public function projectTeams()
    {
        return $this->hasMany(ProjectTeam::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function keuanganProject()
    {
        return $this->belongsTo(keuanganProject::class);
    }
}
