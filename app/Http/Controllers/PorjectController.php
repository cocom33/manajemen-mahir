<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PorjectController extends Controller
{
    public function index()
    {
        return view('project.index', $this->getMenuData());
    }
}
