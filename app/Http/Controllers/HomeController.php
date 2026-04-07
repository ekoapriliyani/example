<?php

namespace App\Http\Controllers;

use App\Models\Mesin;    // Import Model Mesin
use App\Models\Material; // Import Model Material
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil jumlah total data dari database
        $totalMesin = Mesin::count();
        $totalMaterial = Material::count();

        // Mengirim data ke view home
        return view('home', compact('totalMesin', 'totalMaterial'));
    }
}