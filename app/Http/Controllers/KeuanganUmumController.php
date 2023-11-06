<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeuanganUmumController extends Controller
{
    public function index()
    {
        return view('admin.keuangan-umum.index', $this->getMenuData());
    }
}
