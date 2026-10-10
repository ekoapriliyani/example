<?php

namespace App\Http\Controllers;

use App\Models\IncomingBahanBaku;
use App\Models\IncomingBahanBakuInspeksi;
use App\Models\Lks;
use App\Models\LksDetail;
use App\Models\MechanicalTest;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LksController extends Controller
{
    private const ROMAN_MONTHS = [
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV',
        5 => 'V',
        6 => 'VI',
        7 => 'VII',
        8 => 'VIII',
        9 => 'IX',
        10 => 'X',
        11 => 'XI',
        12 => 'XII',
    ];

    public function index(Request $request)
    {
        $query = Lks::with('supplier', 'approver');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nomor_lks', 'like', "%{$search}%")
                ->orWhereHas('supplier', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('bulan')) {
            $bulan = $request->input('bulan'); // format: YYYY-MM
            $query->whereYear('tanggal', substr($bulan, 0, 4))
                ->whereMonth('tanggal', substr($bulan, 5, 2));
        }

        $data = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('lks.index', compact('data'));
    }

    public function create(Request $request)
    {
        $suppliers = Supplier::orderBy('nama')->get();

        $availableLots = collect();
        $selectedSupplier = null;
        $selectedBulan = $request->input('bulan', Carbon::now()->format('Y-m'));

        if ($request->filled('supplier_id')) {
            $selectedSupplier = Supplier::find($request->input('supplier_id'));
            $availableLots = $this->getAvailableLots($request->input('supplier_id'), $selectedBulan);
        }

        return view('lks.create', compact('suppliers', 'availableLots', 'selectedSupplier', 'selectedBulan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'bulan' => 'required|date_format:Y-m',
            'keterangan' => 'nullable|string',
            'lots' => 'required|array|min:1',
            'lots.*' => 'string',
        ]);

        $nomorLks = $this->generateNomorLks($validated['bulan']);
        $tanggal = Carbon::parse($validated['bulan'] . '-01');

        DB::beginTransaction();

        try {
            $lks = Lks::create([
                'nomor_lks' => $nomorLks,
                'supplier_id' => $validated['supplier_id'],
                'tanggal' => $tanggal,
                'keterangan' => $validated['keterangan'],
                'status' => 'DRAFT',
            ]);

            // Simpan detail lot numbers
            foreach ($validated['lots'] as $lotPayload) {
                $lotData = json_decode($lotPayload, true);

                LksDetail::create([
                    'lks_id' => $lks->id,
                    'lot_number' => $lotData['lot_number'],
                    'sumber' => $lotData['sumber'],
                    'sumber_id' => $lotData['sumber_id'],
                    'no_koil' => $lotData['no_koil'] ?? null,
                    'status' => $lotData['status'],
                    'description1' => $lotData['description1'] ?? null,
                    'description2' => $lotData['description2'] ?? null,
                    'tanggal_inspeksi' => $lotData['tanggal_inspeksi'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('lks.show', $lks->id)
                ->with('success', "LKS {$nomorLks} berhasil dibuat");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat LKS: ' . $e->getMessage());
        }
    }

    public function show(Lks $lks)
    {
        $lks->load([
            'supplier',
            'approver',
            'details.sumberInspeksi.incomingbahanbaku',
            'details.sumberMechanical.incomingBahanBaku',
        ]);

        return view('lks.show', compact('lks'));
    }

    public function edit(Lks $lks)
    {
        if (!$lks->isDraft()) {
            return redirect()->route('lks.show', $lks->id)
                ->with('error', 'Hanya LKS dengan status DRAFT yang bisa diedit');
        }

        $lks->load(['supplier', 'details']);

        return view('lks.edit', compact('lks'));
    }

    public function update(Request $request, Lks $lks)
    {
        if (!$lks->isDraft()) {
            return redirect()->route('lks.show', $lks->id)
                ->with('error', 'Hanya LKS dengan status DRAFT yang bisa diedit');
        }

        $validated = $request->validate([
            'keterangan' => 'nullable|string',
        ]);

        $lks->update($validated);

        return redirect()->route('lks.show', $lks->id)
            ->with('success', 'LKS berhasil diupdate');
    }

    public function destroy(Lks $lks)
    {
        if (!$lks->isDraft()) {
            return redirect()->route('lks.show', $lks->id)
                ->with('error', 'Hanya LKS dengan status DRAFT yang bisa dihapus');
        }

        $lks->delete();

        return redirect()->route('lks.index')
            ->with('success', 'LKS berhasil dihapus');
    }

    public function approve(Lks $lks)
    {
        if (!in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        if ($lks->isApproved() || $lks->isOpen()) {
            // Unapprove → kembali ke DRAFT
            $lks->update([
                'status' => 'DRAFT',
                'approved_by' => null,
                'approved_at' => null,
            ]);

            $message = 'Approval LKS dibatalkan.';
        } else {
            // Approve: tandai APPROVED + approver, lalu otomatis dibuka menjadi OPEN
            $lks->update([
                'status' => 'APPROVED',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            $lks->update(['status' => 'OPEN']);

            $message = "LKS {$lks->nomor_lks} berhasil di-approve dan dibuka (OPEN)";
        }

        return back()->with('success', $message);
    }

    public function close(Lks $lks)
    {
        if (!in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        if (!in_array($lks->status, ['APPROVED', 'OPEN', 'SPECIAL ACCEPT'])) {
            return redirect()->route('lks.show', $lks->id)
                ->with('error', 'LKS harus berstatus APPROVED, OPEN, atau SPECIAL ACCEPT sebelum di-close');
        }

        $lks->update(['status' => 'CLOSED']);

        return back()->with('success', "LKS {$lks->nomor_lks} berhasil di-close");
    }

    public function open(Lks $lks)
    {
        if (!in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        if (!$lks->isClosed()) {
            return redirect()->route('lks.show', $lks->id)
                ->with('error', 'Hanya LKS dengan status CLOSED yang bisa di-open');
        }

        $lks->update(['status' => 'OPEN']);

        return back()->with('success', "LKS {$lks->nomor_lks} berhasil di-open kembali (OPEN)");
    }

    public function specialAccept(Lks $lks)
    {
        if (!in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        if (!$lks->isApproved() && !$lks->isOpen()) {
            return redirect()->route('lks.show', $lks->id)
                ->with('error', 'Hanya LKS dengan status APPROVED atau OPEN yang bisa di-special accept');
        }

        $lks->update(['status' => 'SPECIAL ACCEPT']);

        return back()->with('success', "LKS {$lks->nomor_lks} di-set SPECIAL ACCEPT");
    }

    public function unSpecialAccept(Lks $lks)
    {
        if (!in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator'])) {
            abort(403, 'Tidak punya akses.');
        }

        if (!$lks->isSpecialAccept()) {
            return redirect()->route('lks.show', $lks->id)
                ->with('error', 'Hanya LKS dengan status SPECIAL ACCEPT yang bisa dikembalikan');
        }

        $lks->update(['status' => 'OPEN']);

        return back()->with('success', "Status LKS {$lks->nomor_lks} kembali ke OPEN");
    }

    public function getLotsApi(Request $request)
    {
        try {
            $request->validate([
                'supplier_id' => 'required|exists:suppliers,id',
                'bulan' => 'required|date_format:Y-m',
            ]);

            $lots = $this->getAvailableLots($request->input('supplier_id'), $request->input('bulan'));

            return response()->json($lots);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Parameter tidak valid', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data lot', 'message' => $e->getMessage()], 500);
        }
    }

    private function generateNomorLks(string $bulan): string
    {
        $tahun = substr($bulan, 0, 4);
        $bulanNum = (int) substr($bulan, 5, 2);
        $roman = self::ROMAN_MONTHS[$bulanNum] ?? (string) $bulanNum;

        // Nomor urut 3 digit, direset setiap tahun, diambil dari tahun pada $bulan
        $maxSeq = Lks::whereYear('tanggal', $tahun)
            ->pluck('nomor_lks')
            ->map(fn($nomor) => preg_match('/^(\d{3})\/LKS-QC\/PB\//', $nomor, $matches)
                ? (int) $matches[1]
                : null)
            ->filter()
            ->max() ?? 0;

        return sprintf('%03d/LKS-QC/PB/%s/%s', $maxSeq + 1, $roman, $tahun);
    }

    private function getAvailableLots($supplierId, $bulan): \Illuminate\Support\Collection
    {
        $startDate = Carbon::parse($bulan . '-01')->startOfMonth();
        $endDate = Carbon::parse($bulan . '-01')->endOfMonth();

        // Ambil ID inspeksi yang sudah ada di LKS lain
        $usedInspeksiIds = LksDetail::where('sumber', 'inspeksi')
            ->pluck('sumber_id')
            ->toArray();

        // Ambil ID mechanical test yang sudah ada di LKS lain
        $usedMechanicalIds = LksDetail::where('sumber', 'mechanical')
            ->pluck('sumber_id')
            ->toArray();

        // Fetch lot dari inspeksi - filter berdasarkan tanggal inspeksi itu sendiri
        $inspeksiLots = IncomingBahanBakuInspeksi::where('lot_number', '!=', null)
            ->whereNotIn('id', $usedInspeksiIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('incomingbahanbaku', function ($q) use ($supplierId) {
                $q->where('supplier_id', $supplierId);
            })
            ->get()
            ->map(function ($item) {
                return [
                    'lot_number' => $item->lot_number,
                    'sumber' => 'inspeksi',
                    'sumber_id' => $item->id,
                    'no_koil' => $item->no_koil,
                    'status' => $item->dimensi === 'REJECT' || $item->visual === 'REJECT' ? 'REJECT' : 'NG',
                    'description1' => $item->description1,
                    'description2' => $item->description2,
                    'tanggal_inspeksi' => $item->created_at->format('Y-m-d'),
                    // Hasil inspeksi (dimensi)
                    'd1' => $item->d1,
                    'd2' => $item->d2,
                    'd3' => $item->d3,
                    'rata_rata' => $item->rata_rata,
                    'dimensi' => $item->dimensi,
                    'visual' => $item->visual,
                    'files' => $item->files ?? [],
                ];
            });

        // Fetch lot dari mechanical test - filter berdasarkan tanggal test itu sendiri
        $mechanicalLots = MechanicalTest::where('lot_number', '!=', null)
            ->whereNotIn('id', $usedMechanicalIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('incomingBahanBaku', function ($q) use ($supplierId) {
                $q->where('supplier_id', $supplierId);
            })
            ->get()
            ->map(function ($item) {
                return [
                    'lot_number' => $item->lot_number,
                    'sumber' => 'mechanical',
                    'sumber_id' => $item->id,
                    'no_koil' => $item->nomor_koil,
                    'status' => $item->status === 'REJECT' ? 'REJECT' : 'NG',
                    'description1' => $item->description1,
                    'description2' => $item->description2,
                    'tanggal_inspeksi' => $item->created_at->format('Y-m-d'),
                    // Hasil mechanical test
                    'hasil_tensile' => $item->hasil_tensile,
                    'hasil_coatingweight' => $item->hasil_coatingweight,
                    'hasil_lilit' => $item->hasil_lilit,
                    'hasil_puntir' => $item->hasil_puntir,
                    'files' => $item->files ?? [],
                ];
            });

        return $inspeksiLots->concat($mechanicalLots);
    }
}
