<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function(){
    $nama = "Eko";
    $umur = 28;
    // return view('about', ['nama' => $nama, 'umur' => 28]);
    // return view('about', compact('nama', 'umur'));
    return view('about')
                ->with('nama', 'Eko Apriliyani')
                ->with('umur', 36);
});

Route::get('/contact', function(){
    return view('contact');
});

Route::get('/siswa', function(){
    $data = [
        ['nama' => 'Budi', 'nilai' => 80, 'id' => '001'],
        ['nama' => 'Intan', 'nilai' => 84, 'id' => '002'],
        ['nama' => 'Citra', 'nilai' => 82, 'id' => '003'],
    ];
    return view('siswa.index', ['data' => $data]);
});

Route::get('/siswa/{id}', function($id){
    return view('siswa.show', ['id' => $id]);
});