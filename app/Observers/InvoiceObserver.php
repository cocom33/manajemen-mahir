<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\KeuanganPerusahaan;

class InvoiceObserver
{
  /**
 * Register any events for your application.
 *
 * @return void
 */
    public function boot()
{
    Invoice::observe(InvoiceObserver::class);
}   
    public function created(Invoice $invoice)
    {
        // Mencatat transaksi ke dalam tabel keuangan perusahaan setiap kali invoice baru dibuat
        KeuanganPerusahaan::create([
            'invoice_id' => $invoice->id,
            'description' => $invoice->description,
            'total' => $invoice->total,
            // tambahkan field lainnya jika diperlukan
        ]);
    }

    public function updated(Invoice $invoice)
    {
        // Memperbarui catatan transaksi di tabel keuangan perusahaan setiap kali invoice diperbarui
        $keuanganPerusahaan = KeuanganPerusahaan::where('invoice_id', $invoice->id)->first();
        if ($keuanganPerusahaan) {
            $keuanganPerusahaan->update([
                'description' => $invoice->description,
                'total' => $invoice->total,
                // perbarui field lainnya jika diperlukan
            ]);
        }
    }
}
