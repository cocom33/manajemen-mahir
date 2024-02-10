<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Invoice;
use App\Models\InvoiceSystem;
use App\Models\KeuanganDetail;
use App\Models\KeuanganPerusahaan;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KeuanganPerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $year = now();

        if ($request->has('year')) {
            $year = $request->input('year', now()->year);
        };

        $keuangan = KeuanganDetail::selectRaw('MONTH(created_at) as month, SUM(total) as total')->whereYear('created_at', date($year))->where('status', 'pengeluaran')->groupBy('month')->orderBy('month')->get();
        $pemasukan = KeuanganDetail::selectRaw('MONTH(created_at) as month, SUM(total) as total')->whereYear('created_at', date($year))->where('status', 'pemasukan')->groupBy('month')->orderBy('month')->get();

        $labels = [];
        $dataPengeluaran = [];
        $dataPemasukan = [];
        $dataKeuntungan = [];

        $month = [
        'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
        ];
        for ($i = 1; $i < 12; $i++) {
            $count = 0;

            foreach ($keuangan as $item) {
                if ($item->month == $i) {
                    $count = $item->total;
                    break;
                }
            }
            array_push($dataPengeluaran, $count);
        }
        $labels = $month;

        for ($i = 1; $i < 13; $i++) {
            $count = 0;

            foreach ($pemasukan as $item) {
                if ($item->month == $i) {
                    $count = $item->total;
                    break;
                }
            }

            array_push($dataPemasukan, $count);
        }


        for ($i = 0; $i < 12; $i++) {
            $income = isset($dataPemasukan[$i]) ? $dataPemasukan[$i] : 0;
            $expenses = isset($dataPengeluaran[$i]) ? $dataPengeluaran[$i] : 0;

            $profit = $income - $expenses;
            array_push($dataKeuntungan, $profit);
        }

        $datasets = [
            [
                'label' => 'Pemasukan',
                'data' => $dataPemasukan,
                'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                'borderColor' => 'rgb(54, 162, 235)',
                'borderWidth' => 1,
            ],
            [
                'label' => 'Pengeluaran',
                'data' => $dataPengeluaran,
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                'borderColor' => 'rgba(255,99,132,1)',
                'borderWidth' => 1
            ],
            [
                'label' => 'Keuntungan',
                'data' => $dataKeuntungan,
                'backgroundColor' => 'rgba(55, 230, 87, 0.2)',
                'borderColor' => 'rgb(55, 230, 87)',
                'borderWidth' => 1
            ]
        ];

        return view('admin.keuangan-umum.index', compact('datasets','labels' , 'keuangan'))->with('request');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['banks'] = Bank::get();
        $data['suppliers'] = Supplier::get();

        return view('admin.keuangan-umum.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
            'description' => 'required',
            'bank_id' => 'required',
            'supplier_id' => 'nullable',
            'total' => 'required',
        ]);

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
        $data['data'] = KeuanganDetail::findOrFail($id);

        return view('admin.keuangan-umum.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = KeuanganDetail::findOrFail($id);
        $banks = Bank::get();
        $suppliers = Supplier::get();
        $tanggal = $data->tanggal .'/'. $data->keuanganPerusahaan->bulan .'/'. $data->keuanganPerusahaan->tahun;

        return view('admin.keuangan-umum.edit', compact('bulans', 'data', 'tanggal', 'suppliers', 'banks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $model = KeuanganDetail::where('id', $id)->first();

        if ($request->tanggal) {
            $tahun = KeuanganPerusahaan::where([['tahun', Carbon::parse($request->tanggal)->format('Y')], ['bulan', Carbon::parse($request->tanggal)->format('m')]])->get();
            if(!$tahun) {
                $query = KeuanganPerusahaan::create([
                    'tahun' => Carbon::parse($request->tanggal)->format('Y'),
                    'bulan' => Carbon::parse($request->tanggal)->format('m'),
                ]);
            }

            $tanggal = Carbon::parse($request->tanggal)->format('d');
        }

        $data = $request->validate([
            'bank_id' => 'required',
            'supplier_id' => 'nullable',
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