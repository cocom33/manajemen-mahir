<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceSystem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['invoice_id', 'description', 'price', 'date', 'date_type', 'total'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}