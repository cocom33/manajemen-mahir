<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceSystem;
use App\Models\KeuanganBulanan;
use App\Models\KeuanganDetail;
use App\Models\KeuanganPerusahaan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KeuanganPerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.keuangan-umum.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.keuangan-umum.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->tanggal) {
            $tahun = KeuanganPerusahaan::where('tahun', Carbon::parse($request->tanggal)->format('Y'))->get();
            if(!$tahun) {
                $query = KeuanganPerusahaan::create([
                    'tahun' => Carbon::parse($request->tanggal)->format('Y'),
                    'bulan' => Carbon::parse($request->tanggal)->format('m'),
                ]);
            } else {
                $query = $tahun->where('bulan', Carbon::parse($request->tanggal)->format('m'))->first();
                if(!$query) {
                    $query = KeuanganPerusahaan::create([
                        'tahun' => Carbon::parse($request->tanggal)->format('Y'),
                        'bulan' => Carbon::parse($request->tanggal)->format('m'),
                    ]);
                }
            }

            $tanggal = Carbon::parse($request->tanggal)->format('d');
        } else {
            $query = KeuanganPerusahaan::where([['tahun', date('Y')], ['bulan', date('m')]])->first();
            if (!$query) {
                $query = KeuanganPerusahaan::create([
                    'tahun' => date('Y'),
                    'bulan' => date('m'),
                ]);
            }
            $tanggal = date('d');
        }

        $data = $request->validate([
            'status' => 'required',
            'description' => 'required',
            'total' => 'required',
        ]);

        $total = str_replace("Rp. ", "", $request->total);
        $price = str_replace(".", "", $total);

        $data['tanggal'] = $tanggal;
        $data['keuangan_perusahaan_id'] = $query->id;
        $data['total'] = $price;

        $model = KeuanganDetail::create($data);

        return redirect()->route('keuangan-umum.index')->with('success', 'Pengeluaran Perusahaan berhasil dibuat!!');
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
        $tanggal = $data->tanggal .'/'. $data->keuanganPerusahaan->bulan .'/'. $data->keuanganPerusahaan->tahun;
        // dd($bulans);

        return view('admin.keuangan-umum.edit', compact('bulans', 'data', 'tanggal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $model = KeuanganDetail::where('id', $id)->first();

        if ($request->tanggal) {
            $tahun = KeuanganPerusahaan::where('tahun', Carbon::parse($request->tanggal)->format('Y'))->get();
            if(!$tahun) {
                $query = KeuanganPerusahaan::create([
                    'tahun' => Carbon::parse($request->tanggal)->format('Y'),
                    'bulan' => Carbon::parse($request->tanggal)->format('m'),
                ]);
            } else {
                $query = $tahun->where('bulan', Carbon::parse($request->tanggal)->format('m'))->first();
                if(!$query) {
                    $query = KeuanganPerusahaan::create([
                        'tahun' => Carbon::parse($request->tanggal)->format('Y'),
                        'bulan' => Carbon::parse($request->tanggal)->format('m'),
                    ]);
                }
            }

            $tanggal = Carbon::parse($request->tanggal)->format('d');
        }
        // dd($tahun, $query);

        $data = $request->validate([
            'description' => 'required',
            'total' => 'required',
        ]);

        $total = str_replace("Rp. ", "", $request->total);
        $price = str_replace(".", "", $total);
        $data['total'] = $price;

        if ($request->tanggal) {
            $data['keuangan_perusahaan_id'] = $query->id;
            $data['tanggal'] = $tanggal;
            $model->update($data);
        } else {
            $model->update($data);
        }


        return redirect()->route('keuangan-umum.index')->with('success', $model->description . ' berhasil diedit!!');
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