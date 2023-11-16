<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'no_invoice', 'type'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function system()
    {
        return $this->hasMany(InvoiceSystem::class);
    }

    public function other()
    {
        return $this->hasMany(InvoiceOther::class);
    }
}