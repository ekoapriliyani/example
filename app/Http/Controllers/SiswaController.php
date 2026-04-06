<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Siswa::with('mentor')->orderBy('nilai', 'desc')->paginate(10);
        return view('siswa.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ambil dari mode mentor
        $mentors = Mentor::all();
        return view('siswa.create', ['mentors' => $mentors]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|min:3',
            'tanggal_lahir' => 'required|date',
            'jurusan' => 'required|string|min:3',
            'nilai' => 'required|numeric|min:0|max:100',
            'mentor_id' => 'required|exists:mentors,id',
        ]);

        Siswa::create([
            'nama' => $validated['nama'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jurusan' => $validated['jurusan'],
            'nilai' => $validated['nilai'],
            'mentor_id' => $validated['mentor_id']
        ]);

        return redirect()->route('siswa.index')->with('success', 'data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        $siswa->load('mentor');
        return view('siswa.show', ['siswa' => $siswa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {   
        $mentors = Mentor::all();
        return view('siswa.edit', compact('siswa', 'mentors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        // validasi data
        $validated = $request->validate([
            'nama' => 'required|string|min:3',
            'tanggal_lahir' => 'required|date',
            'jurusan' => 'required|string|min:3',
            'nilai' => 'required|numeric|min:0|max:100',
            'mentor_id' => 'required|exists:mentors,id',
        ]);
        // update data secara langsung dari intance model
        $siswa->update($validated);
        return redirect()->route('siswa.index')->with('success', 'data siswa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'data siswa berhasil dihapus');
    }
}
