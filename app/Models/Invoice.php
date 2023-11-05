<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'no_invoice'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}