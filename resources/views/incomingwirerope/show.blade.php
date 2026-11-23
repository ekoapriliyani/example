<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Detail Inspeksi Incoming Wire Rope') }}
            </h2>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('incomingwirerope.index') }}"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                    Kembali
                </a>
                <button type="button" onclick="printInspeksi()"
                    class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak
                </button>

                @php
                    $isApproved = $incomingwirerope->isApproved();
                @endphp

                {{-- Tambah Inspeksi Wire Rope --}}
                @if ($isApproved)
                    <button type="button" disabled
                        class="inline-flex cursor-not-allowed items-center gap-2 rounded-md bg-gray-400 px-4 py-2 text-sm font-semibold text-white opacity-60 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Inspeksi
                    </button>
                @else
                    <a href="{{ route('incomingwirerope.inspeksi.create', $incomingwirerope->id) }}"
                        class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Inspeksi
                    </a>
                @endif

                {{-- Mechanical Test --}}
                @if ($isApproved)
                    <button type="button" disabled
                        class="inline-flex cursor-not-allowed items-center gap-2 rounded-md bg-gray-400 px-4 py-2 text-sm font-semibold text-white opacity-60 shadow-sm">
                        Mechanical Test
                    </button>
                @else
                    <a href="{{ route('incomingwirerope.mechanical_test.create', $incomingwirerope->id) }}"
                        class="inline-flex items-center gap-2 rounded-md bg-green-700 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-green-800">
                        Mechanical Test
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">

            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    <div class="flex items-start justify-between">
                        <dl class="grid grid-cols-2 gap-x-8 gap-y-4 sm:grid-cols-4">
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Nomor Inspeksi</dt>
                                <dd class="text-lg font-bold text-indigo-600">{{ $incomingwirerope->nomor_inspeksi }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Tanggal</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($incomingwirerope->tanggal)->format('d/m/Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Jenis</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $incomingwirerope->jenis == 'non_reguler' ? 'Non Reguler' : 'Reguler' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Supplier</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $incomingwirerope->supplier->nama ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">No RCR</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingwirerope->no_rcr ?? '-' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">No PO</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingwirerope->no_po }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">No SJ</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingwirerope->no_sj }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Jml Koil</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingwirerope->jml_koil }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">D Kawat</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingwirerope->d_kawat }} mm
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Toleransi</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingwirerope->tol }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Jenis Kawat</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingwirerope->jenis_kawat }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Certificate</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $incomingwirerope->certificate ?? '-' }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium italic text-gray-500">Description</dt>
                                <dd class="text-sm text-gray-900">{{ $incomingwirerope->description ?? '-' }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="mb-2 text-sm font-medium italic text-gray-500">File / Gambar</dt>
                                <dd>
                                    @if ($incomingwirerope->files && count($incomingwirerope->files))
                                        <button type="button" onclick="openFileModal(@json($incomingwirerope->files))"
                                            class="inline-flex items-center gap-2 rounded-lg bg-indigo-50 px-3 py-1.5 text-xs font-medium text-indigo-700 transition hover:bg-indigo-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12H9m12 0A9 9 0 1112 3a9 9 0 019 9z" />
                                            </svg>
                                            Lihat File ({{ count($incomingwirerope->files) }})
                                        </button>
                                    @else
                                        <span class="text-xs italic text-gray-400">Tidak ada file.</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <div class="rounded-lg bg-indigo-100 p-2 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Hasil Inspeksi &amp; Mechanical Test Wire Rope</h3>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th rowspan="2"
                                        class="border-r border-gray-200 px-4 py-3 text-center font-semibold text-gray-900">
                                        No</th>
                                    <th rowspan="2"
                                        class="border-r border-gray-200 px-4 py-3 text-center font-semibold text-gray-900">
                                        Aksi</th>
                                    <th colspan="15"
                                        class="border-r border-b border-gray-200 px-4 py-2 text-center text-xs font-bold uppercase tracking-wide text-blue-700">
                                        Inspeksi Wire Rope</th>
                                    <th colspan="5"
                                        class="border-b border-gray-200 px-4 py-2 text-center text-xs font-bold uppercase tracking-wide text-green-700">
                                        Mechanical Test</th>
                                </tr>
                                <tr>
                                    <th class="px-3 py-2 font-semibold text-gray-700">Inspektor</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">No Koil</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">D1 WR</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">D2 WR</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">D3 WR</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">D1 KI</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">D2 KI</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">D3 KI</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">Jml KI</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">Dimensi</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">Visual</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">Desc 1</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">Desc 2</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">Lot Number</th>
                                    <th class="border-r border-gray-200 px-3 py-2 font-semibold text-gray-700">Gambar
                                    </th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">Status</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">Inspektor</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">Tensile</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">Lot Number</th>
                                    <th class="px-3 py-2 font-semibold text-gray-700">Gambar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($incomingwirerope->inspeksis as $ins)
                                    <tr class="transition-colors hover:bg-gray-50">
                                        <td class="px-3 py-3 text-center">{{ $loop->iteration }}</td>
                                        <td class="px-3 py-3">
                                            <div class="flex items-center justify-center gap-1.5">
                                                @if ($isApproved)
                                                    <span
                                                        class="flex cursor-not-allowed items-center justify-center rounded bg-gray-100 p-2 text-gray-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                        </svg>
                                                    </span>
                                                    <span
                                                        class="flex cursor-not-allowed items-center justify-center rounded bg-gray-100 p-2 text-gray-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
                                                        </svg>
                                                    </span>
                                                @else
                                                    <a href="{{ route('incomingwirerope.inspeksi.edit', ['incomingwirerope' => $incomingwirerope->id, 'inspeksi' => $ins->id]) }}"
                                                        title="Edit Inspeksi"
                                                        class="flex items-center justify-center rounded bg-yellow-50 p-2 text-yellow-700 transition hover:bg-yellow-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                        </svg>
                                                    </a>
                                                    <form
                                                        action="{{ route('incomingwirerope.inspeksi.destroy', $ins->id) }}"
                                                        method="POST" class="form-delete inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Hapus Inspeksi"
                                                            class="flex items-center justify-center rounded bg-red-50 p-2 text-red-700 transition hover:bg-red-100">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    @if ($ins->mechanical_status)
                                                        <a href="{{ route('incomingwirerope.mechanical_test.edit', $ins->id) }}"
                                                            title="Edit Mechanical Test"
                                                            class="flex items-center justify-center rounded bg-green-50 p-2 text-green-700 transition hover:bg-green-100">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </a>
                                                        <form
                                                            action="{{ route('incomingwirerope.mechanical_test.destroy', $ins->id) }}"
                                                            method="POST" class="form-reset inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" title="Reset Mechanical Test"
                                                                class="flex items-center justify-center rounded bg-orange-50 p-2 text-orange-700 transition hover:bg-orange-100">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">{{ $ins->user->name ?? 'N/A' }}</td>
                                        <td class="px-3 py-3 font-semibold">{{ $ins->no_koil }}</td>
                                        <td class="px-3 py-3">{{ $ins->d1_wire_rope ?? '-' }}</td>
                                        <td class="px-3 py-3">{{ $ins->d2_wire_rope ?? '-' }}</td>
                                        <td class="px-3 py-3">{{ $ins->d3_wire_rope ?? '-' }}</td>
                                        <td class="px-3 py-3">{{ $ins->d1_kawat_inti ?? '-' }}</td>
                                        <td class="px-3 py-3">{{ $ins->d2_kawat_inti ?? '-' }}</td>
                                        <td class="px-3 py-3">{{ $ins->d3_kawat_inti ?? '-' }}</td>
                                        <td class="px-3 py-3">{{ $ins->jml_kawat_inti ?? '-' }}</td>
                                        <td class="px-3 py-3">
                                            <span
                                                class="{{ $ins->dimensi === 'OK' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }} inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold">
                                                {{ $ins->dimensi }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-3">
                                            <span
                                                class="{{ $ins->visual === 'OK' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }} inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold">
                                                {{ $ins->visual }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-3 text-gray-600">{{ $ins->description1 ?? '-' }}</td>
                                        <td class="px-3 py-3 text-gray-600">{{ $ins->description2 ?? '-' }}</td>
                                        <td class="px-3 py-3">
                                            @if ($ins->lot_number)
                                                <span
                                                    class="inline-flex items-center rounded-full bg-blue-200 px-2 py-1 text-xs font-semibold text-blue-800">
                                                    {{ $ins->lot_number }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="border-r border-gray-200 px-3 py-3">
                                            @if ($ins->files && count($ins->files))
                                                <button type="button"
                                                    class="text-sm font-semibold text-indigo-600 hover:underline"
                                                    onclick='openFileModal(@json($ins->files))'>
                                                    Lihat
                                                </button>
                                            @else
                                                <span class="text-xs italic text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3">
                                            @if ($ins->mechanical_status)
                                                <span
                                                    class="{{ $ins->mechanical_status === 'OK' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }} inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold">
                                                    {{ $ins->mechanical_status }}
                                                </span>
                                            @else
                                                <span class="text-xs italic text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            {{ $ins->mechanicalUser->name ?? '-' }}</td>
                                        <td class="px-3 py-3">
                                            {{ $ins->tensile_strength_kawat_inti ?? '-' }}
                                            @if ($ins->tensile_strength_kawat_inti)
                                                <span class="text-xs text-gray-500">MPa</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3">
                                            @if ($ins->mechanical_lot_number)
                                                <span
                                                    class="inline-flex items-center rounded-full bg-blue-200 px-2 py-1 text-xs font-semibold text-blue-800">
                                                    {{ $ins->mechanical_lot_number }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3">
                                            @if ($ins->mechanical_files && count($ins->mechanical_files))
                                                <button type="button"
                                                    class="text-sm font-semibold text-green-700 hover:underline"
                                                    onclick='openFileModal(@json($ins->mechanical_files))'>
                                                    Lihat
                                                </button>
                                            @else
                                                <span class="text-xs italic text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="22" class="px-4 py-8 text-center italic text-gray-400">
                                            Belum ada data Inspeksi Wire Rope.
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

    {{-- FILE PREVIEW MODAL --}}
    <div id="fileModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 p-6">
        <div class="relative max-h-[90vh] w-full max-w-5xl overflow-auto rounded-2xl bg-white shadow-xl">
            <div class="sticky top-0 z-10 flex items-center justify-between border-b bg-white px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800">Preview File</h3>
                <button onclick="closeFileModal()"
                    class="rounded-lg p-2 text-lg font-bold text-gray-500 hover:bg-gray-100">✕</button>
            </div>
            <div id="filePreviewContainer" class="space-y-6 p-6"></div>
        </div>
    </div>

    {{-- ==================== PRINT SECTION ==================== --}}
    <style>
        @media print {
            @page {
                size: landscape;
                margin: 10mm;
            }

            body * {
                visibility: hidden;
            }

            #print-section,
            #print-section * {
                visibility: visible;
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
        }
    </style>
    <div id="print-section" class="hidden">
        {{-- Header --}}
        <table width="100%" cellpadding="5" cellspacing="0"
            style="border-collapse: collapse; margin-bottom: 10px;">
            <tr>
                <td style="width: 20%; vertical-align: middle;">
                    <img src="{{ asset('img/logobeva.png') }}" alt="Logo" style="height: 60px; width: auto;" />
                </td>
                <td style="width: 60%; vertical-align: middle; text-align: center;">
                    <h1 style="font-size: 18pt; font-weight: bold; margin: 0; font-family: Arial, sans-serif;">LAPORAN
                        INSPEKSI INCOMING WIRE ROPE</h1>
                </td>
                <td style="width: 20%; vertical-align: top; text-align: right; font-family: Arial, sans-serif; font-size: 11pt;">
                    <table cellpadding="3" cellspacing="0" style="border: 1px solid #000; margin-left: auto;">
                        <tr>
                            <td style="font-weight: bold; font-size: 10pt;">BM-F-QC-17 R00</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <hr style="border: 1px solid #000; margin-bottom: 15px;">

        {{-- Data Header --}}
        <table width="100%" cellpadding="5" cellspacing="0"
            style="border-collapse: collapse; margin-bottom: 20px; font-family: Arial, sans-serif; font-size: 11pt;">
            <tr>
                <td style="width: 20%; font-weight: bold;">Tanggal</td>
                <td style="width: 30%;">: {{ now()->format('d/m/Y') }}</td>
                <td style="width: 20%; font-weight: bold;">No Inspeksi</td>
                <td style="width: 30%;">: {{ $incomingwirerope->nomor_inspeksi }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Supplier</td>
                <td>: {{ $incomingwirerope->supplier->nama ?? '-' }}</td>
                <td style="font-weight: bold;">No PO</td>
                <td>: {{ $incomingwirerope->no_po }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">No SJ</td>
                <td>: {{ $incomingwirerope->no_sj }}</td>
                <td style="font-weight: bold;">No RCR</td>
                <td>: {{ $incomingwirerope->no_rcr ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Jml Koil</td>
                <td>: {{ $incomingwirerope->jml_koil }}</td>
                <td style="font-weight: bold;">D Kawat / Toleransi</td>
                <td>: {{ $incomingwirerope->d_kawat }} mm / {{ $incomingwirerope->tol }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Jenis</td>
                <td>: {{ $incomingwirerope->jenis == 'non_reguler' ? 'Non Reguler' : 'Reguler' }}</td>
                <td style="font-weight: bold;">Jenis Kawat</td>
                <td>: {{ $incomingwirerope->jenis_kawat }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Certificate</td>
                <td>: {{ $incomingwirerope->certificate ?? '-' }}</td>
                <td style="font-weight: bold;">Description</td>
                <td>: {{ $incomingwirerope->description ?? '-' }}</td>
            </tr>
        </table>

        {{-- Tabel Gabungan --}}
        <div style="margin-bottom: 20px;">
            <table width="100%" cellpadding="3" cellspacing="0"
                style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 7.5pt; border: 1px solid #000;">
                <thead>
                    <tr style="background-color: #f0f0f0;">
                        <th rowspan="2" style="border: 1px solid #000; padding: 4px; text-align: center;">No</th>
                        <th colspan="15" style="border: 1px solid #000; padding: 4px; text-align: center;">Inspeksi Wire
                            Rope</th>
                        <th colspan="5" style="border: 1px solid #000; padding: 4px; text-align: center;">Mechanical
                            Test</th>
                    </tr>
                    <tr style="background-color: #f0f0f0;">
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">Inspektor</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">No Koil</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">D1 WR</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">D2 WR</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">D3 WR</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">D1 KI</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">D2 KI</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">D3 KI</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">Jml KI</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">Dimensi</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">Visual</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">Desc 1</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">Desc 2</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">Lot</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">Gambar</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">Status</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">Inspektor</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">Tensile</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">Lot</th>
                        <th style="border: 1px solid #000; padding: 4px; text-align: center;">Gambar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($incomingwirerope->inspeksis as $ins)
                        <tr>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">
                                {{ $loop->iteration }}</td>
                            <td style="border: 1px solid #000; padding: 3px;">{{ $ins->user->name ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000; padding: 3px;">{{ $ins->no_koil }}</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">
                                {{ $ins->d1_wire_rope ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">
                                {{ $ins->d2_wire_rope ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">
                                {{ $ins->d3_wire_rope ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">
                                {{ $ins->d1_kawat_inti ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">
                                {{ $ins->d2_kawat_inti ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">
                                {{ $ins->d3_kawat_inti ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">
                                {{ $ins->jml_kawat_inti ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">
                                {{ $ins->dimensi }}</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">
                                {{ $ins->visual }}</td>
                            <td style="border: 1px solid #000; padding: 3px;">{{ $ins->description1 ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 3px;">{{ $ins->description2 ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">
                                {{ $ins->lot_number ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">
                                {{ $ins->files && count($ins->files) ? count($ins->files) . ' file' : '-' }}</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">
                                {{ $ins->mechanical_status ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 3px;">
                                {{ $ins->mechanicalUser->name ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">
                                {{ $ins->tensile_strength_kawat_inti ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">
                                {{ $ins->mechanical_lot_number ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 3px; text-align: center;">
                                {{ $ins->mechanical_files && count($ins->mechanical_files) ? count($ins->mechanical_files) . ' file' : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="21"
                                style="border: 1px solid #000; padding: 8px; text-align: center; font-style: italic;">
                                Belum ada data Inspeksi Wire Rope</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tanda Tangan --}}
        <table width="100%" cellpadding="10" cellspacing="0"
            style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 11pt; margin-top: 40px;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="margin: 0 0 5px 0; font-weight: bold;">Dibuat oleh:</p>
                    <br><br><br>
                    <p style="margin: 0; border-top: 1px solid #000; width: 200px; padding-top: 5px;">
                        {{ $incomingwirerope->inspeksis->first()->user->name ?? '.................' }}
                    </p>
                    <p style="margin: 2px 0 0 0; font-style: italic;">Inspektor</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="margin: 0 0 5px 0; font-weight: bold;">Disetujui Oleh:</p>
                    <br><br><br>
                    <p style="margin: 0; border-top: 1px solid #000; width: 200px; padding-top: 5px;">
                        {{ $incomingwirerope->approver->name ?? '.................' }}
                    </p>
                    <p style="margin: 2px 0 0 0; font-style: italic;">Supervisor / Manager</p>
                </td>
            </tr>
        </table>
    </div>
    {{-- ==================== END PRINT SECTION ==================== --}}

    {{-- SECTION APPROVAL --}}
    <div class="mt-8 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="p-6">
            <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                <div class="flex items-start gap-4">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-green-100 to-emerald-50 text-green-600 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">
                            Approval Incoming Wire Rope
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Review data inspeksi sebelum melakukan approval.
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @if ($incomingwirerope->isApproved())
                        <span
                            class="inline-flex items-center gap-2 rounded-full border border-green-200 bg-green-50 px-4 py-2 text-sm font-semibold text-green-700">
                            <span class="h-2.5 w-2.5 rounded-full bg-green-500"></span>
                            Approved
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-2 rounded-full border border-yellow-200 bg-yellow-50 px-4 py-2 text-sm font-semibold text-yellow-700">
                            <span class="h-2.5 w-2.5 rounded-full bg-yellow-500"></span>
                            Waiting Approval
                        </span>
                    @endif

                    @if (in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator']))
                        <form id="approval-form-{{ $incomingwirerope->id }}"
                            action="{{ route('incomingwirerope.toggle', $incomingwirerope->id) }}" method="POST"
                            class="hidden">
                            @csrf
                            @method('PATCH')
                        </form>
                        <button type="button"
                            onclick="confirmApproval({{ $incomingwirerope->id }}, '{{ $incomingwirerope->isApproved() ? 'unapprove' : 'approve' }}')"
                            class="{{ $incomingwirerope->isApproved()
                                ? 'bg-orange-500 text-white hover:bg-orange-600'
                                : 'bg-green-600 text-white hover:bg-green-700' }} inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold shadow-sm transition">
                            @if ($incomingwirerope->isApproved())
                                <span class="text-base">↺</span>
                                Unapprove
                            @else
                                <span class="text-base">✓</span>
                                Approve
                            @endif
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function printInspeksi() {
            window.print();
        }

        function openFileModal(files) {
            let modal = document.getElementById('fileModal');
            let container = document.getElementById('filePreviewContainer');
            container.innerHTML = '';

            files.forEach(file => {
                let path = Array.isArray(file) ? (file[0] ?? '') : file;
                if (!path) return;

                let url = '/storage/' + path;
                let ext = path.split('.').pop().toLowerCase();

                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                    container.innerHTML += `
                        <div class="flex justify-center">
                            <img src="${url}" class="max-w-full rounded-xl border shadow-sm">
                        </div>`;
                } else if (ext === 'pdf') {
                    container.innerHTML += `
                        <iframe src="${url}" class="h-[650px] w-full rounded-xl border"></iframe>`;
                } else {
                    container.innerHTML += `
                        <div class="flex items-center justify-between rounded-lg border bg-gray-50 p-4">
                            <span class="text-sm font-medium text-gray-600">${path.split('/').pop()}</span>
                            <a href="${url}" target="_blank" class="text-sm font-semibold text-indigo-600 hover:underline">
                                Download File
                            </a>
                        </div>`;
                }
            });

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeFileModal() {
            let modal = document.getElementById('fileModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

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

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
            });
        @endif

        function confirmApproval(id, type) {
            let isUnapprove = type === 'unapprove';

            Swal.fire({
                title: isUnapprove ? 'Batalkan approval?' : 'Approve data?',
                text: isUnapprove ?
                    "Status akan kembali ke Pending." : "Data akan disetujui.",
                icon: isUnapprove ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonColor: isUnapprove ? '#f97316' : '#16a34a',
                cancelButtonColor: '#4f46e5',
                confirmButtonText: isUnapprove ? 'Ya, Unapprove!' : 'Ya, Approve!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('approval-form-' + id).submit();
                }
            })
        }

        document.querySelectorAll('.form-delete').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin hapus data inspeksi?',
                    text: "Data inspeksi beserta Mechanical Test-nya akan ikut terhapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        document.querySelectorAll('.form-reset').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Reset Mechanical Test?',
                    text: "Data Mechanical Test pada No Koil ini akan dihapus, namun data Inspeksi tetap tersimpan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ea580c',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Reset!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>
