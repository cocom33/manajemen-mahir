<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceSystem;
use App\Models\KeuanganBulanan;
use App\Models\KeuanganDetail;
use App\Models\KeuanganPerusahaan;
use Illuminate\Http\Request;

class KeuanganPerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['tahun'] = KeuanganPerusahaan::where('tahun', Date('Y'))->first();
        $data['invoiceSystem'] = InvoiceSystem::with('invoice')->get();
        $data['invoice'] = Invoice::with('project')->get();
        return view('admin.keuangan-perusahaan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bulans = KeuanganBulanan::all();

        return view('admin.keuangan-perusahaan.create', compact('bulans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tahun = KeuanganPerusahaan::where('tahun', date('Y'))->first();
        $bulan = KeuanganBulanan::where('bulan', date('m'))->first();

        $data = $request->validate([
            // 'bulan' => 'required',
            'description' => 'required',
            'total' => 'required|numeric',
        ]);

        if(!$tahun) {
            $tahun = KeuanganPerusahaan::create(['tahun' => date('Y')]);
        }
        if(!$bulan) {
            $bulan = KeuanganBulanan::create([
                'keuangan_perusahaan_id' => $tahun->id,
                'bulan' => date('m'), 'tahun_id',
            ]);
        }

        $data['keuangan_bulanan_id'] = $bulan->id;

        $model = KeuanganDetail::create($data);

        return redirect()->route('keuangan-perusahaan.index')->with('success', 'Pengeluaran Perusahaan berhasil dibuat!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = KeuanganDetail::findOrFail($id);
        $bulans = KeuanganBulanan::get();
        // dd($bulans);

        return view('admin.keuangan-perusahaan.edit', compact('bulans', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $model = KeuanganDetail::where('id', $id)->first();

        $data = $request->validate([
            'bulan' => 'required',
            'description' => 'required',
            'total' => 'required|numeric',
        ]);

        $data['keuangan_bulanan_id'] = $request->bulan;

        $model->update($data);

        return redirect()->route('keuangan-perusahaan.index')->with('success', $model->description . ' berhasil diedit!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = KeuanganDetail::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('error', 'Berhasil menghapus detail pengeluaran perusahaan!');
    }
}