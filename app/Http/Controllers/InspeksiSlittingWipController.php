<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InspeksiSlittingWipController extends Controller
{
    public function create()
    {
        return view('inspeksi_slitting.create_wip');
    }
}
