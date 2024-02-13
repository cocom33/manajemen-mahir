<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\KeuanganDetail;
use App\Models\KeuanganPerusahaan;
use App\Models\Pengeluaran;
use App\Models\Project;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['pengeluaran'] = Pengeluaran::where('project_id', $data['project']->id)->latest()->get();
        $data['banks'] = Bank::get();
        $data['suppliers'] = Supplier::get();

        $data['detail'] = $this->gaji($data['project']);

        return view('admin.project.pengeluaran.index', $data);
    }

    public function laporan($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['pengeluaran'] = Pengeluaran::where('project_id', $data['project']->id)->orderBy('id', 'desc')->get();

        $data['detail'] = $this->gaji($data['project']);

        return view('admin.project.laporan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id' => 'required',
            'title' => 'required',
            'date' => 'required',
            'price' => 'required',
            'bank_id' => 'required',
            'description' => 'nullable',
        ]);
        $price = str_replace("Rp. ", "", $request->price);
        $data['price'] = str_replace(".", "", $price);

        $data = Pengeluaran::create($data);

        $query = KeuanganPerusahaan::where([['tahun', date('Y')], ['bulan', date('m')]])->first();
        if (!$query) {
            $query = KeuanganPerusahaan::create([
                'tahun' => date('Y'),
                'bulan' => date('m'),
            ]);
        }

        KeuanganDetail::create([
            'keuangan_perusahaan_id' => $query->id,
            'pengeluaran_id' => $data->id,
            'description' => 'Pengeluaran Project',
            'status' => 'pengeluaran',
            'bank_id' => $data->bank_id,
            'tanggal' => Carbon::create($request->date)->format('d'),
            'total' => $data->price,
        ]);

        return redirect()->back()->with('success', 'Berhasil Menambahkan Pengeluaran Project');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug, $id)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['pengeluaran'] = Pengeluaran::find($id);

        $data['detail'] = $this->gaji($data['project']);

        return view('admin.project.pengeluaran.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug, $id)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['banks'] = Bank::get();
        $data['pengeluaran'] = Pengeluaran::find($id);

        $data['detail'] = $this->gaji($data['project']);

        return view('admin.project.pengeluaran.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug, $id)
    {
        $query = Pengeluaran::find($id);

        $data = $request->validate([
            'title' => 'required',
            'date' => 'required',
            'price' => 'required',
            'bank_id' => 'required',
            'description' => 'nullable',
        ]);
        $price = str_replace("Rp. ", "", $request->price);
        $data['price'] = str_replace(".", "", $price);

        $query->update($data);

        $KeuanganDetail = KeuanganDetail::where('pengeluaran_id', $query->id)->first();
        $keuperu = KeuanganPerusahaan::where([['tahun', Carbon::create($data['date'])->format('Y')], ['bulan', Carbon::create($data['date'])->format('m')]])->first();
        if (!$keuperu) {
            $keuperu = KeuanganPerusahaan::create([
                'tahun' => Carbon::create($data['date'])->format('Y'),
                'bulan' => Carbon::create($data['date'])->format('m'),
            ]);
        }

        $KeuanganDetail->update([
            'keuangan_perusahaan_id' => $keuperu->id,
            'description' => 'Pengeluaran Project',
            'bank_id' => $data['bank_id'],
            'tanggal' => Carbon::create($data['date'])->format('d'),
            'total' => $data['price'],
        ]);
        // dd($KeuanganDetail);

        return redirect()->route('project.pengeluaran', $slug)->with('success', 'Berhasil Merubah Pengeluaran Project');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($slug, $id)
    {
        $query = Pengeluaran::find($id);
        $uang = KeuanganDetail::where('pengeluaran_id', $query->id)->first();

        $query->delete();
        $uang->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus Pengeluaran Project');
    }
}
