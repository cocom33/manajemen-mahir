<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeuanganPerusahaanController extends Controller
{
    public function index()
    {
        return view('admin.keuangan-perusahaan.index', $this->getMenuData());
    }
}