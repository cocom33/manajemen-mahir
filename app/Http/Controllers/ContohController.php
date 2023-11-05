<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ContohController extends Controller
{
    public function index($pageName = 'contoh')
    {
        return view('pages/' . $pageName, $this->getMenuData());

    }
}
