<?php

namespace App\Http\Controllers;

use App\Mail\IncomingWireRopeLotNotification;
use App\Mail\WireRopeMechanicalLotNotification;
use App\Models\IncomingWireRope;
use App\Models\IncomingWireRopeInspeksi;
use App\Models\Supplier;
use App\Models\User;
use App\Services\SybaseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class IncomingWireRopeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = IncomingWireRope::with('supplier')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nomor_inspeksi', 'like', "%{$search}%")
                        ->orWhere('no_po', 'like', "%{$search}%")
                        ->orWhere('no_sj', 'like', "%{$search}%")
                        ->orWhereHas('supplier', function ($sub) use ($search) {
                            $sub->where('nama', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status, function ($query, $status) {
                if ($status === 'approved') {
                    return $query->where('approval_status', 'APPROVED');
                } elseif ($status === 'pending') {
                    return $query->where(function ($q) {
                        $q->where('approval_status', 'PENDING')
                            ->orWhereNull('approval_status');
                    });
                }
            })
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('tanggal', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('tanggal', '<=', $endDate);
            })
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('incomingwirerope.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SybaseService $sybaseService)
    {
        $nextNomor = $this->generateNomorInspeksi();
        $suppliers = Supplier::orderBy('supplier_code')->get();
        $receivingData = $sybaseService->getReceivingBIData();

        return view('incomingwirerope.create', compact('nextNomor', 'suppliers', 'receivingData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->parentRules(), $this->parentMessages());

        $validated['nomor_inspeksi'] = $this->generateNomorInspeksi();
        $validated['certificate'] = $validated['certificate'] ?? null;

        $item = IncomingWireRope::create($validated);

        if ($request->hasFile('files')) {
            $item->update([
                'files' => $this->uploadFiles($request, 'files', 'uploads/incomingwirerope'),
            ]);
        }

        return redirect()
            ->route('incomingwirerope.index')
            ->with('success', "Data incoming {$item->nomor_inspeksi} berhasil disimpan");
    }

    /**
     * Display the specified resource.
     */
    public function show(IncomingWireRope $incomingwirerope)
    {
        $incomingwirerope->load([
            'supplier',
            'approver',
            'inspeksis.user',
            'inspeksis.mechanicalUser',
        ]);

        return view('incomingwirerope.show', compact('incomingwirerope'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, SybaseService $sybaseService)
    {
        $data = IncomingWireRope::findOrFail($id);
        $suppliers = Supplier::all();
        $receivingData = $sybaseService->getReceivingBIData();

        return view('incomingwirerope.edit', compact('data', 'suppliers', 'receivingData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate($this->parentRules(), $this->parentMessages());

        $item = IncomingWireRope::findOrFail($id);
        $item->update($validated);

        if ($request->hasFile('files')) {
            $this->deleteFiles($item->files);

            $item->update([
                'files' => $this->uploadFiles($request, 'files', 'uploads/incomingwirerope'),
            ]);
        }

        return redirect()
            ->route('incomingwirerope.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = IncomingWireRope::findOrFail($id);

        $this->deleteFiles($item->files);

        foreach ($item->inspeksis as $inspeksi) {
            $this->deleteFiles($inspeksi->files);
            $this->deleteFiles($inspeksi->mechanical_files);
        }

        $item->delete();

        return redirect()
            ->route('incomingwirerope.index')
            ->with('success', 'Data berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | Inspeksi Wire Rope
    |--------------------------------------------------------------------------
    */

    public function createInspeksi($id)
    {
        $incomingwirerope = IncomingWireRope::findOrFail($id);

        return view('incomingwirerope.inspeksi_create', compact('incomingwirerope'));
    }

    public function storeInspeksi(Request $request, $id)
    {
        $incomingwirerope = IncomingWireRope::findOrFail($id);

        $validated = $request->validate($this->inspeksiRules(), $this->inspeksiMessages());

        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }

        $inspeksi = $incomingwirerope->inspeksis()->create([
            'user_id' => Auth::id(),
            'no_koil' => $validated['no_koil'],
            'd1_wire_rope' => $validated['d1_wire_rope'] ?? null,
            'd2_wire_rope' => $validated['d2_wire_rope'] ?? null,
            'd3_wire_rope' => $validated['d3_wire_rope'] ?? null,
            'd1_kawat_inti' => $validated['d1_kawat_inti'] ?? null,
            'd2_kawat_inti' => $validated['d2_kawat_inti'] ?? null,
            'd3_kawat_inti' => $validated['d3_kawat_inti'] ?? null,
            'jml_kawat_inti' => $validated['jml_kawat_inti'] ?? null,
            'dimensi' => $validated['dimensi'],
            'visual' => $validated['visual'],
            'description1' => $validated['description1'] ?? null,
            'description2' => $validated['description2'] ?? null,
        ]);

        if ($request->hasFile('files')) {
            $inspeksi->update([
                'files' => $this->uploadFiles($request, 'files', 'uploads/incoming_wire_rope_inspeksi'),
            ]);
        }

        if (in_array($inspeksi->dimensi, ['NG', 'REJECT']) || in_array($inspeksi->visual, ['NG', 'REJECT'])) {
            $this->handleLotNumberAndNotify($inspeksi);
        }

        return redirect()
            ->route('incomingwirerope.show', $incomingwirerope->id)
            ->with('success', 'Data inspeksi Wire Rope berhasil ditambahkan');
    }

    public function editInspeksi(IncomingWireRope $incomingwirerope, IncomingWireRopeInspeksi $inspeksi)
    {
        return view('incomingwirerope.inspeksi.edit', compact('incomingwirerope', 'inspeksi'));
    }

    public function updateInspeksi(
        Request $request,
        IncomingWireRope $incomingwirerope,
        IncomingWireRopeInspeksi $inspeksi
    ) {
        $validated = $request->validate($this->inspeksiRules(), $this->inspeksiMessages());

        $inspeksi->update([
            'no_koil' => $validated['no_koil'],
            'd1_wire_rope' => $validated['d1_wire_rope'] ?? null,
            'd2_wire_rope' => $validated['d2_wire_rope'] ?? null,
            'd3_wire_rope' => $validated['d3_wire_rope'] ?? null,
            'd1_kawat_inti' => $validated['d1_kawat_inti'] ?? null,
            'd2_kawat_inti' => $validated['d2_kawat_inti'] ?? null,
            'd3_kawat_inti' => $validated['d3_kawat_inti'] ?? null,
            'jml_kawat_inti' => $validated['jml_kawat_inti'] ?? null,
            'dimensi' => $validated['dimensi'],
            'visual' => $validated['visual'],
            'description1' => $validated['description1'] ?? null,
            'description2' => $validated['description2'] ?? null,
        ]);

        if ($request->hasFile('files')) {
            $this->deleteFiles($inspeksi->files);

            $inspeksi->update([
                'files' => $this->uploadFiles($request, 'files', 'uploads/incoming_wire_rope_inspeksi'),
            ]);
        }

        if (in_array($inspeksi->dimensi, ['NG', 'REJECT']) || in_array($inspeksi->visual, ['NG', 'REJECT'])) {
            $this->handleLotNumberAndNotify($inspeksi);
        }

        return redirect()
            ->route('incomingwirerope.show', $incomingwirerope->id)
            ->with('success', 'Data inspeksi Wire Rope berhasil diupdate');
    }

    public function destroyInspeksi(IncomingWireRopeInspeksi $inspeksi)
    {
        $incomingId = $inspeksi->incoming_wire_rope_id;

        $this->deleteFiles($inspeksi->files);
        $this->deleteFiles($inspeksi->mechanical_files);

        $inspeksi->delete();

        return redirect()
            ->route('incomingwirerope.show', $incomingId)
            ->with('success', 'Data inspeksi Wire Rope berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | Mechanical Test Wire Rope
    |--------------------------------------------------------------------------
    */

    public function createMechanicalTest($id)
    {
        $incomingwirerope = IncomingWireRope::findOrFail($id);

        $inspeksis = $incomingwirerope->inspeksis()
            ->whereNull('mechanical_status')
            ->orderBy('id')
            ->get();

        return view('incomingwirerope.mechanical_test_create', compact('incomingwirerope', 'inspeksis'));
    }

    public function storeMechanicalTest(Request $request, $id)
    {
        $incomingwirerope = IncomingWireRope::findOrFail($id);

        $validated = $request->validate($this->mechanicalRules(), $this->mechanicalMessages());

        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Sesi login berakhir. Silakan login kembali.');
        }

        $inspeksi = $incomingwirerope->inspeksis()
            ->whereKey($validated['inspeksi_id'])
            ->first();

        if (!$inspeksi) {
            return redirect()->back()->with('error', 'No Koil yang dipilih tidak ditemukan pada data inspeksi.');
        }

        if ($inspeksi->mechanical_status) {
            return redirect()->back()->with('error', 'No Koil ini sudah memiliki data Mechanical Test.');
        }

        $inspeksi->update([
            'mechanical_user_id' => Auth::id(),
            'mechanical_status' => $validated['mechanical_status'],
            'tensile_strength_kawat_inti' => $validated['tensile_strength_kawat_inti'],
        ]);

        if ($request->hasFile('files')) {
            $inspeksi->update([
                'mechanical_files' => $this->uploadFiles($request, 'files', 'uploads/incoming_wire_rope_mechanical'),
            ]);
        }

        if (in_array($inspeksi->mechanical_status, ['NG', 'REJECT'])) {
            $this->handleMechanicalLotNumberAndNotify($inspeksi);
        }

        return redirect()
            ->route('incomingwirerope.show', $incomingwirerope->id)
            ->with('success', 'Data Mechanical Test Wire Rope berhasil ditambahkan');
    }

    public function editMechanicalTest(IncomingWireRopeInspeksi $inspeksi)
    {
        $incomingwirerope = $inspeksi->incomingWireRope;

        return view('incomingwirerope.mechanicaltest.edit', compact('incomingwirerope', 'inspeksi'));
    }

    public function updateMechanicalTest(Request $request, IncomingWireRopeInspeksi $inspeksi)
    {
        $validated = $request->validate([
            'mechanical_status' => 'required|in:OK,NG,REJECT',
            'tensile_strength_kawat_inti' => 'required|numeric',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,webp,pdf|max:10240',
        ], $this->mechanicalMessages());

        $inspeksi->update([
            'mechanical_status' => $validated['mechanical_status'],
            'tensile_strength_kawat_inti' => $validated['tensile_strength_kawat_inti'],
        ]);

        if ($request->hasFile('files')) {
            $this->deleteFiles($inspeksi->mechanical_files);

            $inspeksi->update([
                'mechanical_files' => $this->uploadFiles($request, 'files', 'uploads/incoming_wire_rope_mechanical'),
            ]);
        }

        if (in_array($inspeksi->mechanical_status, ['NG', 'REJECT'])) {
            $this->handleMechanicalLotNumberAndNotify($inspeksi);
        }

        return redirect()
            ->route('incomingwirerope.show', $inspeksi->incoming_wire_rope_id)
            ->with('success', 'Data Mechanical Test Wire Rope berhasil diupdate');
    }

    public function destroyMechanicalTest(IncomingWireRopeInspeksi $inspeksi)
    {
        $incomingId = $inspeksi->incoming_wire_rope_id;

        $this->deleteFiles($inspeksi->mechanical_files);

        $inspeksi->update([
            'mechanical_user_id' => null,
            'mechanical_status' => null,
            'tensile_strength_kawat_inti' => null,
            'mechanical_lot_number' => null,
            'mechanical_files' => null,
        ]);

        return redirect()
            ->route('incomingwirerope.show', $incomingId)
            ->with('success', 'Data Mechanical Test Wire Rope berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | Approval
    |--------------------------------------------------------------------------
    */

    public function toggleApproval($id)
    {
        if (!in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        $item = IncomingWireRope::findOrFail($id);

        if ($item->isApproved()) {
            $item->update([
                'approval_status' => 'PENDING',
                'approved_by' => null,
                'approved_at' => null,
            ]);

            $message = 'Approval dibatalkan.';
        } else {
            $item->update([
                'approval_status' => 'APPROVED',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            $message = 'Data berhasil di-approve.';
        }

        return back()->with('success', $message);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function parentRules(): array
    {
        return [
            'jenis' => 'required|in:reguler,non_reguler',
            'tanggal' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'no_rcr' => 'nullable|string',
            'description' => 'nullable|string',
            'no_po' => 'required|string',
            'no_sj' => 'required|string',
            'jml_koil' => 'required|integer|min:0',
            'd_kawat' => 'nullable|numeric',
            'tol' => 'nullable|numeric',
            'jenis_kawat' => 'required|string',
            'certificate' => 'nullable|string',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,webp,pdf|max:20480',
        ];
    }

    private function parentMessages(): array
    {
        return [
            'jenis.required' => 'Jenis wajib dipilih.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'supplier_id.required' => 'Supplier wajib dipilih.',
            'no_po.required' => 'No PO wajib diisi.',
            'no_sj.required' => 'No SJ wajib diisi.',
            'jml_koil.required' => 'Jumlah koil wajib diisi.',
            'jenis_kawat.required' => 'Jenis kawat wajib dipilih.',
            'files.*.mimes' => 'File harus berupa gambar atau PDF.',
            'files.*.max' => 'Ukuran file maksimal 20 MB.',
        ];
    }

    private function inspeksiRules(): array
    {
        return [
            'no_koil' => 'required|string',
            'd1_wire_rope' => 'nullable|numeric',
            'd2_wire_rope' => 'nullable|numeric',
            'd3_wire_rope' => 'nullable|numeric',
            'd1_kawat_inti' => 'nullable|numeric',
            'd2_kawat_inti' => 'nullable|numeric',
            'd3_kawat_inti' => 'nullable|numeric',
            'jml_kawat_inti' => 'nullable|integer|min:0',
            'dimensi' => 'required|in:OK,NG,REJECT',
            'visual' => 'required|in:OK,NG,REJECT',
            'description1' => 'nullable|string',
            'description2' => 'nullable|string',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,webp,pdf|max:10240',
        ];
    }

    private function inspeksiMessages(): array
    {
        return [
            'no_koil.required' => 'No Koil wajib diisi.',
            'dimensi.required' => 'Dimensi wajib dipilih.',
            'visual.required' => 'Visual wajib dipilih.',
            'jml_kawat_inti.integer' => 'Jumlah Kawat Inti harus berupa angka.',
            'files.*.mimes' => 'File harus berupa gambar atau PDF.',
            'files.*.max' => 'Ukuran file maksimal 10 MB.',
        ];
    }

    private function mechanicalRules(): array
    {
        return [
            'inspeksi_id' => 'required|integer',
            'mechanical_status' => 'required|in:OK,NG,REJECT',
            'tensile_strength_kawat_inti' => 'required|numeric',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,webp,pdf|max:10240',
        ];
    }

    private function mechanicalMessages(): array
    {
        return [
            'inspeksi_id.required' => 'No Koil wajib dipilih.',
            'mechanical_status.required' => 'Status wajib dipilih.',
            'tensile_strength_kawat_inti.required' => 'Tensile Strength Kawat Inti wajib diisi.',
            'tensile_strength_kawat_inti.numeric' => 'Tensile Strength Kawat Inti harus berupa angka.',
            'files.*.mimes' => 'File harus berupa gambar atau PDF.',
            'files.*.max' => 'Ukuran file maksimal 10 MB.',
        ];
    }

    private function generateNomorInspeksi(): string
    {
        $tahunBulan = Carbon::now()->format('Ym');
        $prefix = "INWR{$tahunBulan}";

        $lastRecord = IncomingWireRope::where('nomor_inspeksi', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord) {
            $nextNumber = (int) str_replace($prefix, '', $lastRecord->nomor_inspeksi) + 1;
        }

        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    private function uploadFiles(Request $request, string $field, string $folder): array
    {
        $paths = [];

        foreach ($request->file($field, []) as $file) {
            $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $paths[] = $file->storeAs($folder, $name, 'public');
        }

        return $paths;
    }

    private function deleteFiles(?array $files): void
    {
        foreach ($files ?? [] as $file) {
            $actualPath = is_array($file) ? ($file[0] ?? '') : $file;

            if (is_string($actualPath) && $actualPath !== '' && Storage::disk('public')->exists($actualPath)) {
                Storage::disk('public')->delete($actualPath);
            }
        }
    }

    private function generateLotNumber(string $prefix, string $column): string
    {
        $tahunBulan = now()->format('Ym');
        $prefixWithDate = "{$prefix}-{$tahunBulan}-";

        return DB::transaction(function () use ($prefixWithDate, $column) {
            $maxSeq = DB::table('incoming_wire_rope_inspeksis')
                ->where($column, 'like', "{$prefixWithDate}%")
                ->whereNotNull($column)
                ->lockForUpdate()
                ->max(DB::raw("CAST(REPLACE({$column}, '{$prefixWithDate}', '') AS UNSIGNED)"));

            $nextNumber = ($maxSeq ?: 0) + 1;

            return $prefixWithDate . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        });
    }

    private function handleLotNumberAndNotify(IncomingWireRopeInspeksi $inspeksi): void
    {
        if ($inspeksi->lot_number) {
            return;
        }

        $isReject = $inspeksi->dimensi === 'REJECT' || $inspeksi->visual === 'REJECT';
        $prefix = $isReject ? 'REJ-WR' : 'NG-WR';
        $lotNumber = $this->generateLotNumber($prefix, 'lot_number');

        $inspeksi->updateQuietly(['lot_number' => $lotNumber]);

        $recipients = User::whereIn('role', [User::SUPERVISOR, User::MANAGER])->get();

        $inspeksi->load(['incomingWireRope.supplier', 'user']);
        Mail::to($recipients)->send(new IncomingWireRopeLotNotification($inspeksi));
    }

    private function handleMechanicalLotNumberAndNotify(IncomingWireRopeInspeksi $inspeksi): void
    {
        if ($inspeksi->mechanical_lot_number) {
            return;
        }

        $isReject = $inspeksi->mechanical_status === 'REJECT';
        $prefix = $isReject ? 'REJ-WRM' : 'NG-WRM';
        $lotNumber = $this->generateLotNumber($prefix, 'mechanical_lot_number');

        $inspeksi->updateQuietly(['mechanical_lot_number' => $lotNumber]);

        $recipients = User::whereIn('role', [User::SUPERVISOR, User::MANAGER])->get();

        $inspeksi->load(['incomingWireRope.supplier', 'mechanicalUser']);
        Mail::to($recipients)->send(new WireRopeMechanicalLotNotification($inspeksi));
    }
}
