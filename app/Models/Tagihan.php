<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'client_id', 'supplier_id', 'bank_id',
        'title', 'description',
        'harga_jual', 'harga_beli',
        'total', 'date_start',
        'date_end', 'is_with_project',
        'is_active', 'is_lunas', 'is_finish'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}