<?php

namespace App\Http\Controllers;

use App\Models\Outgoing;
use Illuminate\Http\Request;

class OutgoingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $data = Outgoing::with('shipment') // Eager loading relasi shipment
            ->when($search, function ($query, $search) {
                return $query->where('nomor_inspeksi', 'like', "%{$search}%")
                    ->orWhere('tanggal', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc') // Lebih aman menggunakan parameter waktu pembuatan data
            ->paginate(10)
            ->withQueryString();

        return view('outgoing.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
