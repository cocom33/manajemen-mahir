<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loadPage($pageName = 'dashboard')
    {
        return view('pages/' . $pageName, $this->getMenuData());
    }
}
