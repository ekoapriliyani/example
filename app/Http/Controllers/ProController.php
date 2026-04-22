<?php

namespace App\Http\Controllers;

use App\Models\Pro;
use Illuminate\Http\Request;

class ProController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pro::all();
        return view('pro.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pro.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pro_id' => 'required',
            'description' => 'required',
            'qty' => 'required',
        ]);
        Pro::create([
            'pro_id' => $validated['pro_id'],
            'description' => $validated['description'],
            'qty' => $validated['qty'],
        ]);
        return redirect()->route('pro.index')->with('success', 'Data PRO berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pro $pro)
    {

        return view('pro.show', ['pro' => $pro]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pro $pro)
    {
        $pro->delete();
        return redirect()->route('pro.index')->with('success', 'PRO berhasil dihapus');
    }
}
