<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceOther;
use App\Models\InvoiceSystem;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['invoice'] = Invoice::where('project_id', $data['project']->id)->first();

        return view('admin.project.invoice.index', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'no_invoice' => 'required',
            'type' => 'required',
        ]);

        $data['project_id'] = $request->project_id;
        Invoice::create($data);
        return redirect()->back()->with('success', 'berhasil membuat invoice');
    }

    public function detail($slug, $id)
    {
        $data['project']     = Project::with('invoice')->where('slug', $slug)->first();

        if ($data['project']->invoice->type == 'system') {
            $data['invoice'] = InvoiceSystem::find($id);
        } else {
            $data['invoice'] = InvoiceOther::find($id);
        }

        return view('admin.project.invoice.detail', $data);
    }

    public function invoiceSystemStore(Request $request)
    {
        $invoice = InvoiceSystem::find($request->id);

        $data = $request->validate([
            'invoice_id' => 'required',
            'description' => 'required',
            'price' => 'required',
            'date' => 'required',
            'date_type' => 'required',
            'total' => 'required',
        ]);

        if ($invoice) {
            $invoice->update($data);

            return redirect()->route('project.invoice', $invoice->invoice->project->slug)->with('success', 'berhasil update detail invoice');
        }

        InvoiceSystem::create($data);
        return redirect()->back()->with('success', 'berhasil menambah detail invoice');
    }

    public function invoiceOtherStore(Request $request)
    {
        $invoice = InvoiceOther::find($request->id);

        $data = $request->validate([
            'invoice_id' => 'required',
            'description' => 'required',
            'price' => 'required',
            'total' => 'required',
        ]);

        if ($invoice) {
            $invoice->update($data);

            return redirect()->route('project.invoice', $invoice->invoice->project->slug)->with('success', 'berhasil update detail invoice');
        }

        InvoiceOther::create($data);
        return redirect()->back()->with('success', 'berhasil menambah detail invoice');
    }

    public function invoiceSystemDestroy($slug, $id)
    {
        $data = InvoiceSystem::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'berhasil menghapus data invoice');
    }

    public function invoiceOtherDestroy($slug, $id)
    {
        $data = InvoiceOther::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'berhasil menghapus data invoice');
    }
}