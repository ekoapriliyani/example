<?php

namespace App\Http\Controllers;

use App\Models\InspeksiWm;
use App\Models\Mesin;
use App\Models\Pro;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InspeksiWmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Menangkap semua request filter
        $search = $request->input('search');
        $status = $request->input('status'); // nilainya 'pending' atau 'approved' dari form
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = InspeksiWm::with(['pro', 'mesin'])
            // Filter Pencarian (Search)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nomor_inspeksi', 'like', "%{$search}%")
                        ->orWhereHas('pro', function ($proQuery) use ($search) {
                            $proQuery->where('description', 'like', "%{$search}%");
                        });
                });
            })
            // Filter Status menggunakan kolom 'approval_status'
            ->when($status, function ($query, $status) {
                if ($status === 'approved') {
                    return $query->where('approval_status', 'APPROVED');
                } elseif ($status === 'pending') {
                    // Bisa menggunakan orWhereNull untuk berjaga-jaga jika ada data lama yang masih kosong
                    return $query->where(function ($q) {
                        $q->where('approval_status', 'PENDING')
                            ->orWhereNull('approval_status');
                    });
                }
            })
            // Filter Range Tanggal (Start Date)
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('tanggal', '>=', $startDate);
            })
            // Filter Range Tanggal (End Date)
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('tanggal', '<=', $endDate);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi_wm.index', compact('data'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mesins = Mesin::orderBy('nama_mesin')->get();
        $pros = Pro::orderByDesc('pro_id')->get();

        return view('inspeksi_wm.create', [
            'nextNomor' => $this->generateNomorInspeksi(),
            'pros' => $pros,
            'mesins' => $mesins,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'grade' => 'required',
            'type_coating' => 'required',
            'mesin_id' => 'nullable|exists:mesins,id',
            'total_prod' => 'nullable|numeric',
            'satuan' => 'required',
        ]);

        $nomorInspeksi = $this->generateNomorInspeksi();

        $validated['nomor_inspeksi'] = $nomorInspeksi;

        InspeksiWm::create($validated);

        return redirect()
            ->route('inspeksi_wm.index')
            ->with('success', "Inspeksi {$nomorInspeksi} berhasil disimpan");
    }

    /**
     * Display the specified resource.
     */
    public function show(InspeksiWm $inspeksi_wm)
    {
        $inspeksi_wm->load(['pro', 'mesin', 'inspeksiWmWip', 'inspeksiWmFg']);
        return view('inspeksi_wm.show', ['inspeksi_wm' => $inspeksi_wm]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspeksiWm $inspeksi_wm)
    {
        $pros = Pro::orderByDesc('pro_id')->get();
        $mesins = Mesin::orderBy('nama_mesin')->get();

        return view('inspeksi_wm.edit', compact('inspeksi_wm', 'pros', 'mesins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspeksiWm $inspeksi_wm)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'pro_id' => 'required|exists:pros,id',
            'shift' => 'required',
            'grade' => 'required',
            'type_coating' => 'required',
            'shear_strength' => 'nullable|numeric',
            'total_prod' => 'nullable|numeric',
            'satuan' => 'required',
            'mesin_id' => 'nullable|exists:mesins,id',
        ]);

        $inspeksi_wm->update($validated);

        return redirect()
            ->route('inspeksi_wm.index')
            ->with('success', 'Data inspeksi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspeksiWm $inspeksi_wm)
    {
        $this->authorizeRole(['supervisor', 'manager', 'administrator']);

        if ($inspeksi_wm->isApproved()) {
            return back()->with('error', 'Data sudah di-approve, tidak bisa dihapus.');
        }

        $inspeksi_wm->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }

    /**
     * Get PRO detail for AJAX.
     */
    public function getProDetail($id)
    {
        $pro = Pro::find($id);

        if (! $pro) {
            return response()->json([
                'message' => 'PRO tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'id' => $pro->id,
            'pro_id' => $pro->pro_id, // kode PRO dari Sybase
            'description' => $pro->description,
            'qty' => $pro->qty,
        ]);
    }


    public function toggleApproval($id)
    {
        $this->authorizeRole(['supervisor', 'manager', 'administrator']);

        $inspeksi = InspeksiWm::findOrFail($id);

        if ($inspeksi->isApproved()) {
            // UNAPPROVE
            $inspeksi->update([
                'approval_status' => 'PENDING',
                'approved_by' => null,
                'approved_at' => null,
            ]);

            $message = 'Approval dibatalkan.';
        } else {
            // APPROVE
            $inspeksi->update([
                'approval_status' => 'APPROVED',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            $message = 'Data berhasil di-approve.';
        }

        return back()->with('success', $message);
    }

    private function generateNomorInspeksi(): string
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INSWM{$tahunBulan}";

        $lastRecord = InspeksiWm::where('nomor_inspeksi', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $lastNumberStr = str_replace($prefix, '', $lastRecord->nomor_inspeksi);
            $nextNumber = (int) $lastNumberStr + 1;
        }

        return "{$prefix}" . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    private function authorizeRole(array $roles): void
    {
        if (! in_array(auth()->user()->role, $roles)) {
            abort(403, 'Tidak punya akses.');
        }
    }
}
