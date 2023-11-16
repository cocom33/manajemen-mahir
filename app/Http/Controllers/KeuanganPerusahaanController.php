<?php

namespace App\Http\Controllers;

use App\Models\KeuanganDetail;
use App\Models\KeuanganPerusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class KeuanganPerusahaanController extends Controller
{
    public function index()
    {
        $data['data'] = KeuanganPerusahaan::where('tahun', Date('Y'))->first();
        $data['all'] = KeuanganDetail::all();
        // dd($data['all']);

        return view('admin.keuangan-perusahaan.index', $data);
    }
}
