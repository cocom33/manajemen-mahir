<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceOther extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_id', 'description', 'harga', 'total'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}