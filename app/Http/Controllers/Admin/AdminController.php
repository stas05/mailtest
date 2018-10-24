<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends  Controller
{
    /**
     *  view main Admin page
     */
    public function main()
    {
        return view('admin.main');
    }


}
