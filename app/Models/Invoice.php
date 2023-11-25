<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['project_id', 'no_invoice', 'type'];

    public static function generateInvoiceNumber()
    {
        $lastInvoice = self::orderBy('created_at', 'desc')->first();

        if ($lastInvoice) {
            $lastIncrement = intval(substr($lastInvoice->no_invoice, 0, strpos($lastInvoice->no_invoice, '/')));
        } else {
            $lastIncrement = 0;
        }

        // Menambahkan 1 ke angka increment
        $newIncrement = $lastIncrement + 1;

        // Format nomor invoice
        $invoiceNumber = $newIncrement . '/INV/' . now()->format('m/Y');

        return $invoiceNumber;
    }

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
