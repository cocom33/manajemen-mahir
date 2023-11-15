<?php

namespace App\Http\Controllers;

use App\Models\KeuanganPerusahaan;
use Illuminate\Http\Request;

class KeuanganPerusahaanController extends Controller
{
    public function index()
    {
        $data['data'] = KeuanganPerusahaan::where('tahun', Date('Y'))->first();
        return view('admin.keuangan-perusahaan.index', $data);
    }
}