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
        'project_type_id',
        'description',
        'status',
        'project_type',
        'start_date',
        'deadline_date',
        'harga_penawaran',
        'harga_deal',
        'pajak',
        'type_pajak',
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

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function keuangan_project()
    {
        return $this->hasOne(KeuanganProject::class, 'project_id', 'id');
    }

    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}