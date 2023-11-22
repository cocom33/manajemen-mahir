<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'no_invoice', 'type'];

    public static function generateInvoiceNumber()
    {
        // Mendapatkan angka increment dari nomor invoice sebelumnya
        $lastInvoice = self::orderBy('created_at', 'desc')->first();

        if ($lastInvoice) {
            // Mendapatkan angka increment dari nomor invoice sebelumnya
            $lastIncrement = intval(substr($lastInvoice->no_invoice, 0, strpos($lastInvoice->no_invoice, '/')));
        } else {
            // Jika ini invoice pertama, mulai dari 1
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
