<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PorjectTypeController extends Controller
{
    public function index()
    {
        return view('project-type.index', $this->getMenuData());
    }
}