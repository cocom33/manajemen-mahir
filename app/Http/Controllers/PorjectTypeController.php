<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PorjectTypeController extends Controller
{
    public function index()
    {
        return view('admin.project-type.index', $this->getMenuData());
    }
}
