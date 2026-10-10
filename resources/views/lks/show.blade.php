<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Detail LKS') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('lks.index') }}"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                    Kembali
                </a>
                <button type="button" onclick="printLks()"
                    class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak
                </button>
                @php $canManage = in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator']); @endphp
                @if ($canManage && $lks->isDraft())
                    <form action="{{ route('lks.approve', $lks->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700">
                            <span class="text-base">✓</span> Approve
                        </button>
                    </form>
                @endif
                @if ($canManage && ($lks->isApproved() || $lks->isOpen()))
                    <form action="{{ route('lks.approve', $lks->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-md bg-orange-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600">
                            <span class="text-base">↺</span> Unapprove
                        </button>
                    </form>
                    <form action="{{ route('lks.special-accept', $lks->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-md bg-purple-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700">
                            <span class="text-base">★</span> Special Accept
                        </button>
                    </form>
                @endif
                @if ($canManage && $lks->isApproved())
                    <form action="{{ route('lks.open', $lks->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                            <span class="text-base">🔓</span> Open LKS
                        </button>
                    </form>
                @endif
                @if ($canManage && in_array($lks->status, ['APPROVED', 'OPEN', 'SPECIAL ACCEPT']))
                    <form action="{{ route('lks.close', $lks->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700">
                            Close LKS
                        </button>
                    </form>
                @endif
                @if ($canManage && $lks->isSpecialAccept())
                    <form action="{{ route('lks.unspecial-accept', $lks->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                            <span class="text-base">↩</span> Kembali (OPEN)
                        </button>
                    </form>
                @endif
                @if ($canManage && $lks->isClosed())
                    <form action="{{ route('lks.open', $lks->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                            <span class="text-base">🔓</span> Open LKS
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">

            {{-- Info LKS --}}
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    <div class="flex items-start justify-between">
                        <dl class="grid grid-cols-3 gap-x-8 gap-y-4 sm:grid-cols-4">
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Nomor LKS</dt>
                                <dd class="text-lg font-bold text-indigo-600">{{ $lks->nomor_lks }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Supplier</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $lks->supplier->nama ?? 'N/A' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Tanggal</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($lks->tanggal)->format('d/m/Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Status LKS</dt>
                                <dd>
                                    @if ($lks->isDraft())
                                        <span
                                            class="inline-block rounded bg-yellow-100 px-3 py-1 text-sm font-semibold text-yellow-700">DRAFT</span>
                                    @elseif ($lks->isApproved())
                                        <span
                                            class="inline-block rounded bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">APPROVED</span>
                                    @elseif ($lks->isOpen())
                                        <span
                                            class="inline-block rounded bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-700">OPEN</span>
                                    @elseif ($lks->isSpecialAccept())
                                        <span
                                            class="inline-block rounded bg-purple-100 px-3 py-1 text-sm font-semibold text-purple-700">SPECIAL
                                            ACCEPT</span>
                                    @else
                                        <span
                                            class="inline-block rounded bg-gray-100 px-3 py-1 text-sm font-semibold text-gray-700">CLOSED</span>
                                    @endif
                                </dd>
                            </div>
                            <div class="col-span-3 sm:col-span-4">
                                <dt class="text-sm font-medium italic text-gray-500">Keterangan</dt>
                                <dd class="text-gray-900">{{ $lks->keterangan ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Tabel Detail Lot --}}
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <div class="rounded-lg bg-red-100 p-2 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Detail Lot Number NG / REJECT</h3>
                    </div>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No PO</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No RCR</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Description / Barang</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No Koil</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Status LKS</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Description 1</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Description 2</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Tanggal Inspeksi</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Hasil Inspeksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200" id="lks-details-body">
                                @forelse ($lks->details as $detail)
                                    @php
                                        // sumberInspeksi & sumberMechanical sama-sama memakai kolom sumber_id,
                                        // jadi wajib difilter berdasarkan kolom sumber agar tidak salah baca.
                                        $inspeksi = $detail->sumber === 'inspeksi' ? $detail->sumberInspeksi : null;
                                        $mechanical =
                                            $detail->sumber === 'mechanical' ? $detail->sumberMechanical : null;
                                        $lampiran = $inspeksi?->files ?? ($mechanical?->files ?? []);
                                        $jumlahGambar = is_array($lampiran) ? count($lampiran) : 0;
                                    @endphp
                                    <tr class="transition-colors hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 font-semibold text-indigo-600">
                                            {{ $detail->no_po ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3">
                                            {{ $detail->no_rcr ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">
                                            {{ $detail->description_barang ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 font-medium">{{ $detail->no_koil ?? '-' }}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="{{ $detail->status === 'REJECT' ? 'text-red-800 bg-red-200' : 'text-yellow-800 bg-yellow-200' }} inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold">
                                                {{ $detail->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">{{ $detail->description1 ?? '-' }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $detail->description2 ?? '-' }}</td>
                                        <td class="px-4 py-3 text-xs text-gray-500">
                                            {{ $detail->tanggal_inspeksi ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-center">
                                            <button type="button"
                                                class="btn-detail text-xs font-semibold text-indigo-600 hover:underline"
                                                data-target="lks-detail-{{ $loop->index }}">
                                                Lihat Hasil ▾
                                            </button>
                                            @if ($jumlahGambar > 0)
                                                <button type="button"
                                                    class="btn-gambar ml-2 inline-flex items-center rounded-lg bg-indigo-50 px-2 py-1 text-xs font-semibold text-indigo-700 transition hover:bg-indigo-100"
                                                    data-title="{{ $detail->lot_number }}"
                                                    data-files="{{ json_encode($lampiran) }}">
                                                    Gambar ({{ $jumlahGambar }})
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr id="lks-detail-{{ $loop->index }}" class="detail-row hidden bg-gray-50">
                                        <td colspan="10" class="px-4 py-3">
                                            @if ($inspeksi)
                                                <div
                                                    class="flex flex-wrap items-start justify-between gap-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                                                    <div>
                                                        <span
                                                            class="mb-2 block text-xs font-bold uppercase tracking-wide text-gray-500">Hasil
                                                            Inspeksi Incoming</span>
                                                        <div class="flex flex-wrap items-end gap-x-8 gap-y-3">
                                                            <div>
                                                                <span class="block text-xs text-gray-500">D1</span>
                                                                <span
                                                                    class="font-semibold text-gray-800">{{ $inspeksi->d1 ?? '-' }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="block text-xs text-gray-500">D2</span>
                                                                <span
                                                                    class="font-semibold text-gray-800">{{ $inspeksi->d2 ?? '-' }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="block text-xs text-gray-500">D3</span>
                                                                <span
                                                                    class="font-semibold text-gray-800">{{ $inspeksi->d3 ?? '-' }}</span>
                                                            </div>
                                                            <div>
                                                                <span
                                                                    class="block text-xs text-gray-500">Rata-rata</span>
                                                                <span
                                                                    class="font-semibold text-indigo-600">{{ $inspeksi->rata_rata ?? '-' }}</span>
                                                            </div>
                                                            <div>
                                                                <span
                                                                    class="block text-xs text-gray-500">Dimensi</span>
                                                                <span
                                                                    class="{{ ($inspeksi->dimensi ?? '') === 'OK' ? 'text-green-800 bg-green-200' : 'text-yellow-800 bg-yellow-200' }} inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold">
                                                                    {{ $inspeksi->dimensi ?? '-' }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <span class="block text-xs text-gray-500">Visual</span>
                                                                <span
                                                                    class="{{ ($inspeksi->visual ?? '') === 'OK' ? 'text-green-800 bg-green-200' : 'text-yellow-800 bg-yellow-200' }} inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold">
                                                                    {{ $inspeksi->visual ?? '-' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($mechanical)
                                                <div
                                                    class="flex flex-wrap items-start justify-between gap-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                                                    <div>
                                                        <span
                                                            class="mb-2 block text-xs font-bold uppercase tracking-wide text-gray-500">Hasil
                                                            Mechanical Test</span>
                                                        <div class="flex flex-wrap items-end gap-x-8 gap-y-3">
                                                            <div>
                                                                <span class="block text-xs text-gray-500">Hasil
                                                                    Tensile</span>
                                                                <span
                                                                    class="font-semibold text-gray-800">{{ $mechanical->hasil_tensile ?? '-' }}
                                                                    Mpa</span>
                                                            </div>
                                                            <div>
                                                                <span class="block text-xs text-gray-500">Coating
                                                                    Weight</span>
                                                                <span
                                                                    class="font-semibold text-gray-800">{{ $mechanical->hasil_coatingweight ?? '-' }}
                                                                    g/m²</span>
                                                            </div>
                                                            <div>
                                                                <span class="block text-xs text-gray-500">Hasil
                                                                    Lilit</span>
                                                                <span
                                                                    class="{{ ($mechanical->hasil_lilit ?? '') === 'OK' ? 'text-green-800 bg-green-200' : 'text-red-800 bg-red-200' }} inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold">
                                                                    {{ $mechanical->hasil_lilit ?? '-' }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <span class="block text-xs text-gray-500">Hasil
                                                                    Puntir</span>
                                                                <span
                                                                    class="font-semibold text-gray-800">{{ $mechanical->hasil_puntir ?? '-' }}
                                                                    kali</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-xs italic text-gray-400">Data hasil inspeksi tidak
                                                    ditemukan (sumber: {{ $detail->sumber ?? '-' }}).</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="px-4 py-8 text-center italic text-gray-400">
                                            Belum ada detail lot number.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Print Section --}}
    <style>
        @media print {
            @page {
                size: portrait;
                margin: 10mm;
            }

            body * {
                visibility: hidden;
            }

            #print-section,
            #print-section * {
                visibility: visible;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            #print-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            #print-section.hidden {
                display: block !important;
            }

            .print-section-title {
                page-break-inside: avoid;
                break-inside: avoid;
            }
        }
    </style>

    @php
        // Siapkan daftar lampiran per detail untuk halaman cetak ke-2.
        // File yang tidak ada di storage dilewati agar tidak mencetak ikon gambar rusak.
        $lampiranPrint = [];

        foreach ($lks->details as $detail) {
            $cetakSumber =
                $detail->sumber === 'inspeksi'
                    ? $detail->sumberInspeksi
                    : ($detail->sumber === 'mechanical'
                        ? $detail->sumberMechanical
                        : null);

            $cetakFiles = $cetakSumber?->files ?? [];
            if (!is_array($cetakFiles)) {
                continue;
            }

            $cetakImages = [];
            $cetakDokumens = [];

            foreach ($cetakFiles as $cetakFile) {
                $cetakPath = is_array($cetakFile) ? $cetakFile[0] ?? '' : $cetakFile;
                if (empty($cetakPath)) {
                    continue;
                }

                if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($cetakPath)) {
                    continue; // file hilang -> dilewati
                }

                $cetakExt = strtolower(pathinfo($cetakPath, PATHINFO_EXTENSION));
                if (in_array($cetakExt, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                    $cetakImages[] = $cetakPath;
                } else {
                    $cetakDokumens[] = $cetakPath; // PDF dll -> hanya teks
                }
            }

            if ($cetakImages || $cetakDokumens) {
                $lampiranPrint[] = [
                    'lot_number' => $detail->lot_number,
                    'no_koil' => $detail->no_koil,
                    'sumber' => $detail->sumber,
                    'images' => $cetakImages,
                    'dokumens' => $cetakDokumens,
                ];
            }
        }

        // Halaman lampiran hanya dibuat bila ada minimal 1 gambar yang bisa dicetak
        $adaGambarCetak = false;
        foreach ($lampiranPrint as $cetakItem) {
            if (!empty($cetakItem['images'])) {
                $adaGambarCetak = true;
                break;
            }
        }
    @endphp

    <div id="print-section" class="hidden">
        <table width="100%" cellpadding="5" cellspacing="0"
            style="border-collapse: collapse; margin-bottom: 10px;">
            <tr>
                <td style="width: 22%; vertical-align: middle;">
                    <img src="{{ asset('img/logobeva.png') }}" alt="Logo" style="height: 60px; width: auto;" />
                </td>
                <td style="width: 56%; vertical-align: middle; text-align: center;">
                    <h1 style="font-size: 18pt; font-weight: bold; margin: 0; font-family: Arial, sans-serif;">
                        LAPORAN KETIDAKSESUAIAN (LKS)</h1>
                </td>
                <td
                    style="width: 22%; vertical-align: top; text-align: right; font-family: Arial, sans-serif; font-size: 12pt;">
                    <table cellpadding="3" cellspacing="0" style="border: 1px solid #000; margin-left: auto;">
                        <tr>
                            <td style="font-weight: bold; font-size: 11pt;">BM-F-QC-32 R00</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <hr style="border: 1px solid #000; margin-bottom: 15px;">

        <table width="100%" cellpadding="5" cellspacing="0"
            style="border-collapse: collapse; margin-bottom: 20px; font-family: Arial, sans-serif; font-size: 12pt;">
            <tr>
                <td style="width: 20%; font-weight: bold;">Nomor LKS</td>
                <td style="width: 30%;">: {{ $lks->nomor_lks }}</td>
                <td style="width: 20%; font-weight: bold;">Tanggal</td>
                <td style="width: 30%;">: {{ \Carbon\Carbon::parse($lks->tanggal)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Supplier</td>
                <td>: {{ $lks->supplier->nama ?? 'N/A' }}</td>
                <td style="font-weight: bold;">Status LKS</td>
                <td>: {{ $lks->status }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="font-weight: bold;">Tanggal Batas Menjawab</td>
                <td>: {{ \Carbon\Carbon::parse($lks->tanggal)->addWeek()->format('d/m/Y') }}</td>
            </tr>
        </table>

        {{-- Section I. Temuan --}}
        <div style="border: 1px solid #000; margin-bottom: 12px; font-family: Arial, sans-serif;">
            <div class="print-section-title"
                style="background-color: #f0f0f0; border-bottom: 1px solid #000; padding: 5px 8px; font-size: 12pt; font-weight: bold;">
                I. Temuan</div>
            <div style="padding: 8px; font-size: 12pt; min-height: 20mm; white-space: pre-wrap;">
                {{ $lks->keterangan ?? '-' }}</div>
        </div>

        {{-- Section II. Rincian --}}
        <div style="border: 1px solid #000; margin-bottom: 12px; font-family: Arial, sans-serif;">
            <div class="print-section-title"
                style="background-color: #f0f0f0; border-bottom: 1px solid #000; padding: 5px 8px; font-size: 12pt; font-weight: bold;">
                II. Rincian</div>
            <div style="padding: 6px;">
                <table width="100%" cellpadding="4" cellspacing="0"
                    style="border-collapse: collapse; font-size: 10pt; border: 1px solid #000;">
                    <thead>
                        <tr style="background-color: #f7f7f7;">
                            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 4%;">No</th>
                            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 9%;">No PO
                            </th>
                            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 8%;">No RCR
                            </th>
                            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 13%;">
                                Description /
                                Barang</th>
                            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 8%;">No Koil
                            </th>
                            {{-- <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 8%;">Status
                            </th> --}}
                            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 10%;">Defect 1
                            </th>
                            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 10%;">Defect 2
                            </th>
                            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 8%;">Tgl
                                Inspeksi</th>
                            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 22%;">Hasil
                                Inspeksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lks->details as $detail)
                            @php
                                // Guard sumber: sumberInspeksi & sumberMechanical sama-sama memakai sumber_id
                                $printInspeksi = $detail->sumber === 'inspeksi' ? $detail->sumberInspeksi : null;
                                $printMechanical = $detail->sumber === 'mechanical' ? $detail->sumberMechanical : null;
                            @endphp
                            <tr>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                    {{ $loop->iteration }}</td>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                    {{ $detail->no_po ?? '-' }}</td>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                    {{ $detail->no_rcr ?? '-' }}</td>
                                <td style="border: 1px solid #000; padding: 4px;">
                                    {{ $detail->description_barang ?? '-' }}</td>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                    {{ $detail->no_koil ?? '-' }}</td>
                                {{-- <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                    {{ $detail->status }}</td> --}}
                                <td style="border: 1px solid #000; padding: 4px;">{{ $detail->description1 ?? '-' }}
                                </td>
                                <td style="border: 1px solid #000; padding: 4px;">{{ $detail->description2 ?? '-' }}
                                </td>
                                <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                    {{ $detail->tanggal_inspeksi ?? '-' }}</td>
                                <td style="border: 1px solid #000; padding: 4px; font-size: 9pt; line-height: 1.35;">
                                    @if ($printInspeksi)
                                        D1 {{ $printInspeksi->d1 ?? '-' }} |
                                        D2 {{ $printInspeksi->d2 ?? '-' }} |
                                        D3 {{ $printInspeksi->d3 ?? '-' }}<br>
                                        Avg {{ $printInspeksi->rata_rata ?? '-' }}
                                    @elseif ($printMechanical)
                                        Tensile {{ $printMechanical->hasil_tensile ?? '-' }} Mpa |
                                        Coating {{ $printMechanical->hasil_coatingweight ?? '-' }} g/m²<br>
                                        Lilit {{ $printMechanical->hasil_lilit ?? '-' }} |
                                        Puntir {{ $printMechanical->hasil_puntir ?? '-' }} kali
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10"
                                    style="border: 1px solid #000; padding: 8px; text-align: center; font-style: italic;">
                                    Belum ada detail lot number</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Section III. Analisa Penyebab --}}
        <div style="border: 1px solid #000; margin-bottom: 12px; font-family: Arial, sans-serif;">
            <div class="print-section-title"
                style="background-color: #f0f0f0; border-bottom: 1px solid #000; padding: 5px 8px; font-size: 12pt; font-weight: bold;">
                III. Analisa Penyebab</div>
            <div style="height: 24mm;"></div>
        </div>

        {{-- Section IV. Perbaikan --}}
        <div style="border: 1px solid #000; margin-bottom: 12px; font-family: Arial, sans-serif;">
            <div class="print-section-title"
                style="background-color: #f0f0f0; border-bottom: 1px solid #000; padding: 5px 8px; font-size: 12pt; font-weight: bold;">
                IV. Perbaikan</div>
            <div style="height: 24mm;"></div>
        </div>

        {{-- Section V. Preventive / Improvement --}}
        <div style="border: 1px solid #000; margin-bottom: 12px; font-family: Arial, sans-serif;">
            <div class="print-section-title"
                style="background-color: #f0f0f0; border-bottom: 1px solid #000; padding: 5px 8px; font-size: 12pt; font-weight: bold;">
                V. Preventive / Improvement</div>
            <div style="height: 24mm;"></div>
        </div>

        {{-- Tanda Tangan --}}
        <table width="100%" cellpadding="10" cellspacing="0"
            style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12pt; margin-top: 20px;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="margin: 0 0 5px 0; font-weight: bold;">Dibuat oleh:</p>
                    <br><br>
                    <p style="margin: 0; border-top: 1px solid #000; width: 200px; padding-top: 5px;">
                        {{ $lks->approver->name ?? '.................' }}</p>
                    <p style="margin: 2px 0 0 0; font-style: italic;">QC - PT Bevananda Mustika</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="margin: 0 0 5px 0; font-weight: bold;">Ditindak lanjuti oleh:</p>
                    <br><br>
                    <p style="margin: 0; border-top: 1px solid #000; width: 200px; padding-top: 5px;">
                        {{ $lks->supplier->nama ?? '.................' }}</p>
                    <p style="margin: 2px 0 0 0; font-style: italic;">Supplier</p>
                </td>
            </tr>
        </table>

        {{-- ==================== HALAMAN 2: LAMPIRAN GAMBAR ==================== --}}
        @if ($adaGambarCetak)
            <div style="page-break-before: always; break-before: page; font-family: Arial, sans-serif;">

                <table width="100%" cellpadding="5" cellspacing="0"
                    style="border-collapse: collapse; margin-bottom: 4px;">
                    <tr>
                        <td style="width: 22%; vertical-align: middle;">
                            <img src="{{ asset('img/logobeva.png') }}" alt="Logo"
                                style="height: 50px; width: auto;" />
                        </td>
                        <td style="width: 56%; text-align: center; vertical-align: middle;">
                            <h1 style="font-size: 16pt; font-weight: bold; margin: 0;">LAMPIRAN GAMBAR</h1>
                            <div style="font-size: 12pt; margin-top: 2px;">Laporan Ketidaksesuaian (LKS)</div>
                        </td>
                        <td style="width: 22%; vertical-align: top; text-align: right; font-size: 12pt;">
                            <table cellpadding="3" cellspacing="0"
                                style="border: 1px solid #000; margin-left: auto;">
                                <tr>
                                    <td style="font-weight: bold; font-size: 11pt;">BM-F-QC-32 R00</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <hr style="border: 1px solid #000; margin-bottom: 8px;">

                <table width="100%" cellpadding="4" cellspacing="0"
                    style="border-collapse: collapse; font-size: 12pt; margin-bottom: 10px;">
                    <tr>
                        <td style="width: 15%; font-weight: bold;">Nomor LKS</td>
                        <td style="width: 35%;">: {{ $lks->nomor_lks }}</td>
                        <td style="width: 15%; font-weight: bold;">Tanggal</td>
                        <td style="width: 35%;">: {{ \Carbon\Carbon::parse($lks->tanggal)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Supplier</td>
                        <td>: {{ $lks->supplier->nama ?? 'N/A' }}</td>
                        <td style="font-weight: bold;">Jumlah Lampiran</td>
                        <td>: {{ collect($lampiranPrint)->pluck('images')->flatten()->count() }} gambar</td>
                    </tr>
                </table>

                @foreach ($lampiranPrint as $lampiranIdx => $lampiran)
                    {{-- Label per lot: dijaga agar tidak pindah halaman sendirian --}}
                    <div
                        style="page-break-inside: avoid; break-inside: avoid; border: 1px solid #000; background-color: #f7f7f7; padding: 4px 6px; font-size: 12pt; font-weight: bold; margin-bottom: 4px;">
                        {{ $lampiranIdx + 1 }}. Lot: {{ $lampiran['lot_number'] ?? '-' }}
                        (No Koil: {{ $lampiran['no_koil'] ?? '-' }})
                        — Sumber: {{ $lampiran['sumber'] === 'mechanical' ? 'Mechanical Test' : 'Inspeksi Incoming' }}
                    </div>

                    @if (!empty($lampiran['images']))
                        <table width="100%" cellpadding="4" cellspacing="0"
                            style="border-collapse: collapse; margin-bottom: 4px;">
                            @foreach (array_chunk($lampiran['images'], 2) as $pair)
                                {{-- Tiap baris pasangan gambar tidak boleh terpotong --}}
                                <tr style="page-break-inside: avoid; break-inside: avoid;">
                                    @foreach ($pair as $imagePath)
                                        <td width="50%"
                                            style="text-align: center; vertical-align: top; padding: 4px;">
                                            <img src="{{ asset('storage/' . $imagePath) }}" alt="Lampiran"
                                                style="max-width: 100%; max-height: 55mm; height: auto; object-fit: contain; border: 1px solid #666;" />
                                            <div style="font-size: 9pt; margin-top: 2px; color: #333;">
                                                {{ basename($imagePath) }}
                                            </div>
                                        </td>
                                    @endforeach
                                    @if (count($pair) === 1)
                                        <td width="50%" style="padding: 4px;">&nbsp;</td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    @endif

                    @if (!empty($lampiran['dokumens']))
                        <div style="font-size: 11pt; margin: 0 0 10px 0; padding: 0 6px;">
                            File lampiran:
                            @foreach ($lampiran['dokumens'] as $docIdx => $docPath)
                                {{ $docIdx > 0 ? ', ' : '' }}{{ basename($docPath) }}
                            @endforeach
                        </div>
                    @else
                        <div style="margin-bottom: 10px;"></div>
                    @endif
                @endforeach

            </div>
        @endif
    </div>

    {{-- Modal Gambar Lampiran --}}
    <div id="lks-image-modal"
        class="fixed inset-0 z-50 flex hidden items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="max-h-[80vh] w-3/4 overflow-y-auto rounded-lg bg-white p-6 shadow-lg">
            <h3 class="mb-4 text-lg font-semibold text-gray-800">
                Gambar Lampiran: <span class="text-indigo-600" id="lks-modal-title">-</span>
            </h3>
            <div id="lks-modal-grid" class="grid grid-cols-1 gap-4 md:grid-cols-2"></div>
            <div class="mt-6 text-right">
                <button type="button" id="lks-modal-close"
                    class="rounded-md bg-gray-200 px-4 py-2 font-medium text-gray-700 transition hover:bg-gray-300">Tutup</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        @endif

        function printLks() {
            const printSection = document.getElementById('print-section');
            printSection.classList.remove('hidden');

            const restore = () => {
                setTimeout(() => printSection.classList.add('hidden'), 500);
            };

            // Pastikan semua gambar lampiran sudah termuat sebelum dialog cetak muncul,
            // agar tidak tercetak kotak kosong.
            const images = Array.from(printSection.querySelectorAll('img'));
            const pending = images
                .filter(img => !img.complete)
                .map(img => new Promise(resolve => {
                    img.addEventListener('load', resolve, {
                        once: true
                    });
                    img.addEventListener('error', resolve, {
                        once: true
                    });
                }));

            const allLoaded = pending.length ?
                Promise.race([
                    Promise.all(pending),
                    new Promise(resolve => setTimeout(resolve, 3000)), // batas tunggu
                ]) :
                Promise.resolve();

            allLoaded.then(() => {
                window.print();
                restore();
            });
        }

        // ==================== Hasil Inspeksi (expandable) ====================
        const STORAGE_BASE = '{{ asset('storage') }}';
        const IMAGE_EXT = ['jpg', 'jpeg', 'png', 'webp'];

        const detailsBody = document.getElementById('lks-details-body');
        const imageModal = document.getElementById('lks-image-modal');
        const modalTitle = document.getElementById('lks-modal-title');
        const modalGrid = document.getElementById('lks-modal-grid');

        function esc(value) {
            if (value === null || value === undefined || value === '') return '-';
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function storageUrl(path) {
            return STORAGE_BASE + '/' + String(path).replace(/^\/+/, '');
        }

        function openImageModal(files, title) {
            modalTitle.textContent = title || '-';

            if (!files || files.length === 0) {
                modalGrid.innerHTML = '<p class="text-gray-400 italic col-span-2">Tidak ada file yang diupload.</p>';
            } else {
                modalGrid.innerHTML = files.map(file => {
                    const path = Array.isArray(file) ? (file[0] ?? '') : file;
                    if (!path) return '';

                    const ext = (String(path).split('.').pop() || '').toLowerCase();
                    const url = esc(storageUrl(path));

                    if (IMAGE_EXT.includes(ext)) {
                        return `<img src="${url}" alt="Lampiran"
                            class="w-full h-64 object-contain rounded border shadow-sm" />`;
                    }

                    return `<a href="${url}" target="_blank"
                        class="flex items-center justify-center p-4 border rounded bg-gray-50 text-indigo-600 hover:underline font-medium">
                        Lihat File (${esc(ext.toUpperCase() || 'DOC')})
                    </a>`;
                }).join('');
            }

            imageModal.classList.remove('hidden');
        }

        function closeImageModal() {
            imageModal.classList.add('hidden');
            modalGrid.innerHTML = '';
        }

        if (detailsBody) {
            detailsBody.addEventListener('click', function(e) {
                const btnDetail = e.target.closest('.btn-detail');
                if (btnDetail) {
                    const row = document.getElementById(btnDetail.dataset.target);
                    if (row) {
                        const hidden = row.classList.toggle('hidden');
                        btnDetail.textContent = hidden ? 'Lihat Hasil ▾' : 'Sembunyikan ▴';
                    }
                    return;
                }

                const btnGambar = e.target.closest('.btn-gambar');
                if (btnGambar) {
                    let files = [];
                    try {
                        files = JSON.parse(btnGambar.dataset.files || '[]');
                    } catch (err) {
                        console.error('Gagal membaca daftar gambar:', err);
                    }
                    openImageModal(files, btnGambar.dataset.title);
                }
            });
        }

        document.getElementById('lks-modal-close').addEventListener('click', closeImageModal);
        imageModal.addEventListener('click', function(e) {
            if (e.target === imageModal) closeImageModal();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !imageModal.classList.contains('hidden')) closeImageModal();
        });
    </script>
</x-app-layout>
