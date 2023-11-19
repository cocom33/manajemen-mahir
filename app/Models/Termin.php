<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Termin extends Model
{
    use HasFactory;
    use SoftDeletes;
    use sluggable;

    protected $fillable = ['keuangan_project_id', 'name', 'slug'];

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

    public function termin_fee()
    {
        return $this->hasMany(TerminFee::class);
    }
}