<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Detail Inspeksi Outgoing') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('outgoing.index') }}"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                    Kembali
                </a>
                <button type="button" onclick="printInspeksi()"
                    class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 002 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak
                </button>

                @php
                    $isApproved = $outgoing->approval_status === 'APPROVED';
                @endphp

                {{-- Tambah Inspeksi --}}
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
                    <a href="{{ route('outgoing.inspeksi', $outgoing->id) }}"
                        class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Inspeksi
                    </a>
                @endif

                {{-- Defect --}}
                @if ($isApproved)
                    <button type="button" disabled
                        class="inline-flex cursor-not-allowed items-center gap-2 rounded-md bg-gray-400 px-4 py-2 text-sm font-semibold text-white opacity-60 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        Defect
                    </button>
                @else
                    <button type="button" onclick="openDefectModal()"
                        class="inline-flex items-center gap-2 rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        Defect
                    </button>
                @endif
            </div>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">

            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    <div class="flex items-start justify-between">
                        <dl class="grid grid-cols-3 gap-x-8 gap-y-4 sm:grid-cols-4">
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Nomor Inspeksi</dt>
                                <dd class="text-lg font-bold text-indigo-600">{{ $outgoing->nomor_inspeksi }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Tanggal</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->tanggal }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Shipment ID</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->shipment_id ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Sales Order</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->so ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Nomor DO</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->no_do }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Produk</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->produk }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Qty</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->qty ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Lokasi</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->lokasi }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">No Kendaraan</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->no_kendaraan }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Keterangan</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->keterangan }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <div class="rounded-lg bg-blue-100 p-2 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Hasil Inspeksi Outgoing</h3>
                    </div>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-900">Aksi</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Inspektor</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Label</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Karat</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Penyok</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Kotor</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Galvanized</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Lasan</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Mesh</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">PVC</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Packing</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">QTY</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Gambar</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-900">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($outgoing->outgoinginspeksi as $inc)
                                    <tr class="transition-colors hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('outgoing.inspeksi.edit', ['outgoing' => $outgoing->id, 'inspeksi' => $inc->id]) }}"
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
                                                <form action="{{ route('outgoing.inspeksi.destroy', $inc->id) }}"
                                                    method="POST" class="form-delete inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="flex items-center justify-center rounded bg-red-50 p-2 text-red-700 transition hover:bg-red-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">{{ $inc->user->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $inc->label }}</td>
                                        <td class="px-4 py-3">{{ $inc->karat }}</td>
                                        <td class="px-4 py-3">{{ $inc->penyok }}</td>
                                        <td class="px-4 py-3">{{ $inc->kotor }}</td>
                                        <td class="px-4 py-3">{{ $inc->galvanized }}</td>
                                        <td class="px-4 py-3">{{ $inc->lasan }}</td>
                                        <td class="px-4 py-3">{{ $inc->mesh }}</td>
                                        <td class="px-4 py-3">{{ $inc->pvc }}</td>
                                        <td class="px-4 py-3">{{ $inc->packing }}</td>
                                        <td class="px-4 py-3">{{ $inc->qty }}</td>
                                        <td class="px-4 py-3">
                                            <button type="button"
                                                class="text-sm font-semibold text-indigo-600 hover:underline"
                                                onclick="toggleImage({{ $inc->id }})">
                                                Lihat Gambar
                                            </button>
                                        </td>
                                        <td class="px-4 py-3 text-center text-xs text-gray-500">{{ $inc->created_at }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="14" class="px-4 py-8 text-center italic text-gray-400">Belum
                                            ada data Inspeksi Outgoing</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Daftar Defect --}}
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <div class="rounded-lg bg-red-100 p-2 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Daftar Defect</h3>
                    </div>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Problem 1</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Problem 2</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-900">Qty</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-900">Status</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Foto</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Inspektor</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-900">Created At</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-900">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($outgoing->defects as $defect)
                                    <tr class="transition-colors hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">{{ $defect->problem1 ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $defect->problem2 ?? '-' }}</td>
                                        <td class="px-4 py-3 text-center font-semibold">{{ $defect->qty }}</td>
                                        <td class="px-4 py-3 text-center">
                                            @if ($defect->status === 'REJECT')
                                                <span
                                                    class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-700">REJECT</span>
                                            @else
                                                <span
                                                    class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">NG</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @if (!empty($defect->foto))
                                                <button type="button"
                                                    class="text-sm font-semibold text-indigo-600 hover:underline"
                                                    onclick="toggleDefectImage({{ $defect->id }})">
                                                    Lihat Foto ({{ count($defect->foto) }})
                                                </button>
                                            @else
                                                <span class="italic text-gray-400">Tidak ada</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">{{ $defect->user->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-center text-xs text-gray-500">{{ $defect->created_at }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-center">
                                                <form action="{{ route('outgoing.defect.destroy', $defect->id) }}"
                                                    method="POST" class="form-delete inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="flex items-center justify-center rounded bg-red-50 p-2 text-red-700 transition hover:bg-red-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-4 py-8 text-center italic text-gray-400">Belum
                                            ada data Defect</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($outgoing->outgoinginspeksi as $inc)
        <div id="image-{{ $inc->id }}"
            class="fixed inset-0 z-50 flex hidden items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="max-h-[80vh] w-3/4 overflow-y-auto rounded-lg bg-white p-6 shadow-lg">
                <h3 class="mb-4 text-lg font-semibold text-gray-800">Gambar Incoming No Koil: <span
                        class="text-indigo-600">{{ $inc->no_koil }}</span></h3>
                @if ($inc->files)
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @foreach ($inc->files as $file)
                            @php $ext = pathinfo($file, PATHINFO_EXTENSION); @endphp
                            @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                                <img src="{{ asset('storage/' . $file) }}" alt="Incoming Image"
                                    class="h-64 w-full rounded border object-contain shadow-sm" />
                            @else
                                <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                    class="flex items-center justify-center rounded border bg-gray-50 p-4 font-medium text-indigo-600 hover:underline">
                                    Lihat File ({{ strtoupper($ext) }})
                                </a>
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="italic text-gray-400">Tidak ada file yang diupload.</p>
                @endif
                <div class="mt-6 text-right">
                    <button onclick="toggleImage({{ $inc->id }})"
                        class="rounded-md bg-gray-200 px-4 py-2 font-medium text-gray-700 transition hover:bg-gray-300">Tutup</button>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal foto defect --}}
    @foreach ($outgoing->defects as $defect)
        <div id="defect-image-{{ $defect->id }}"
            class="fixed inset-0 z-50 flex hidden items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="max-h-[80vh] w-3/4 overflow-y-auto rounded-lg bg-white p-6 shadow-lg">
                <h3 class="mb-4 text-lg font-semibold text-gray-800">Foto Defect: <span
                        class="text-indigo-600">{{ $defect->problem1 ?? '-' }}</span></h3>
                @if (!empty($defect->foto))
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @foreach ($defect->foto as $file)
                            @php $ext = pathinfo($file, PATHINFO_EXTENSION); @endphp
                            @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                                <img src="{{ asset('storage/' . $file) }}" alt="Foto Defect"
                                    class="h-64 w-full rounded border object-contain shadow-sm" />
                            @else
                                <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                    class="flex items-center justify-center rounded border bg-gray-50 p-4 font-medium text-indigo-600 hover:underline">
                                    Lihat File ({{ strtoupper($ext) }})
                                </a>
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="italic text-gray-400">Tidak ada foto yang diupload.</p>
                @endif
                <div class="mt-6 text-right">
                    <button onclick="toggleDefectImage({{ $defect->id }})"
                        class="rounded-md bg-gray-200 px-4 py-2 font-medium text-gray-700 transition hover:bg-gray-300">Tutup</button>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Input Defect --}}
    <div id="defect-modal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-gray-900 bg-opacity-50 p-4">
        <div class="max-h-[90vh] w-full max-w-5xl overflow-y-auto rounded-lg bg-white p-6 shadow-lg">
            <div class="mb-4 flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Input Defect</h3>
                    <p class="text-sm text-gray-500">Tambahkan satu atau lebih baris defect.</p>
                </div>
                <button type="button" onclick="closeDefectModal()"
                    class="rounded-md p-1 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            @if (isset($errors) && $errors->any())
                <div class="mb-4 rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('outgoing.defect.store', $outgoing->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-3 font-semibold text-gray-900">Problem 1</th>
                                <th class="px-3 py-3 font-semibold text-gray-900">Problem 2</th>
                                <th class="w-28 px-3 py-3 font-semibold text-gray-900">Qty</th>
                                <th class="w-32 px-3 py-3 font-semibold text-gray-900">Status</th>
                                <th class="px-3 py-3 font-semibold text-gray-900">Foto</th>
                                <th class="w-16 px-3 py-3 text-center font-semibold text-gray-900">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="defect-rows" class="divide-y divide-gray-200"></tbody>
                    </table>
                </div>

                <template id="defect-row-template">
                    <tr class="defect-row">
                        <td class="px-3 py-3">
                            <select name="defects[__INDEX__][problem1]" required
                                class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500">
                                <option value="">Pilih Defect</option>
                                @foreach (\App\Models\OutgoingDefect::PROBLEM_OPTIONS as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-3 py-3">
                            <select name="defects[__INDEX__][problem2]"
                                class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500">
                                <option value="">-</option>
                                @foreach (\App\Models\OutgoingDefect::PROBLEM_OPTIONS as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-3 py-3">
                            <input type="number" name="defects[__INDEX__][qty]" min="1" required
                                class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500"
                                placeholder="0">
                        </td>
                        <td class="px-3 py-3">
                            <select name="defects[__INDEX__][status]" required
                                class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500">
                                @foreach (\App\Models\OutgoingDefect::STATUS_OPTIONS as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-3 py-3">
                            <input type="file" name="defects[__INDEX__][foto][]" accept="image/*" multiple
                                class="block w-full rounded-md border border-gray-300 p-2 text-xs shadow-sm">
                        </td>
                        <td class="px-3 py-3 text-center">
                            <button type="button" onclick="removeDefectRow(this)"
                                class="defect-remove-btn inline-flex items-center justify-center rounded bg-red-50 p-2 text-red-700 transition hover:bg-red-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </template>

                <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <button type="button" onclick="addDefectRow()"
                        class="inline-flex items-center gap-2 rounded-md border border-red-300 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Baris
                    </button>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeDefectModal()"
                            class="rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-200">
                            Batal
                        </button>
                        <button type="submit"
                            class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-red-700">
                            Simpan Defect
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    {{-- section approval --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="p-6">
            <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                <!-- Left -->
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
                            Approval Incoming Bahan Baku
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Review data inspeksi sebelum melakukan approval.
                        </p>
                    </div>
                </div>
                <!-- Middle + Right -->
                <div class="flex items-center gap-4">
                    <!-- Status -->
                    @if ($outgoing->isApproved())
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
                    <!-- Button -->
                    @if (in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator']))
                        <form id="approval-form-{{ $outgoing->id }}"
                            action="{{ route('outgoing.toggle', $outgoing->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('PATCH')
                        </form>
                        <button type="button"
                            onclick="confirmApproval({{ $outgoing->id }}, '{{ $outgoing->isApproved() ? 'unapprove' : 'approve' }}')"
                            class="{{ $outgoing->isApproved()
                                ? 'bg-orange-500 text-white hover:bg-orange-600'
                                : 'bg-green-600 text-white hover:bg-green-700' }} inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold shadow-sm transition">
                            @if ($outgoing->isApproved())
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
        function toggleImage(id) {
            const modal = document.getElementById('image-' + id);
            if (modal) modal.classList.toggle('hidden');
        }

        function toggleImage2(id) {
            const modal = document.getElementById('image2-' + id);
            if (modal) modal.classList.toggle('hidden');
        }

        function toggleDefectImage(id) {
            const modal = document.getElementById('defect-image-' + id);
            if (modal) modal.classList.toggle('hidden');
        }

        let defectRowIndex = 0;

        function addDefectRow() {
            const template = document.getElementById('defect-row-template');
            const tbody = document.getElementById('defect-rows');

            if (!template || !tbody) return;

            const markup = template.innerHTML.split('__INDEX__').join(defectRowIndex++);
            tbody.insertAdjacentHTML('beforeend', markup);
            updateDefectRemoveButtons();
        }

        function removeDefectRow(button) {
            const row = button.closest('tr');
            const rows = document.querySelectorAll('#defect-rows .defect-row');

            if (!row || rows.length <= 1) return;

            row.remove();
            updateDefectRemoveButtons();
        }

        function updateDefectRemoveButtons() {
            const rows = document.querySelectorAll('#defect-rows .defect-row');

            rows.forEach((row) => {
                const button = row.querySelector('.defect-remove-btn');
                if (!button) return;

                const disabled = rows.length <= 1;
                button.disabled = disabled;
                button.classList.toggle('opacity-40', disabled);
                button.classList.toggle('cursor-not-allowed', disabled);
            });
        }

        function resetDefectRows() {
            const tbody = document.getElementById('defect-rows');
            if (!tbody) return;

            tbody.innerHTML = '';
            defectRowIndex = 0;
            addDefectRow();
        }

        function openDefectModal() {
            const modal = document.getElementById('defect-modal');
            if (!modal) return;

            resetDefectRows();
            modal.classList.remove('hidden');
        }

        function closeDefectModal() {
            const modal = document.getElementById('defect-modal');
            if (modal) modal.classList.add('hidden');
        }

        @if (isset($errors) && $errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                openDefectModal();
            });
        @endif
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
                    title: 'Yakin hapus data?',
                    text: "Data pemeriksaan item ini tidak bisa dikembalikan!",
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

        function printInspeksi() {
            window.print();
        }
    </script>

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
                        INSPEKSI OUTGOING</h1>
                </td>
                <td
                    style="width: 20%; vertical-align: top; text-align: right; font-family: Arial, sans-serif; font-size: 11pt;">
                    <table cellpadding="3" cellspacing="0" style="border: 1px solid #000; margin-left: auto;">
                        <tr>
                            <td style="font-weight: bold; font-size: 10pt;">BM-F-QC-25 R00</td>
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
                <td style="width: 30%;">: {{ $outgoing->nomor_inspeksi }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Shipment ID</td>
                <td>: {{ $outgoing->shipment_id ?? '-' }}</td>
                <td style="font-weight: bold;">Sales Order</td>
                <td>: {{ $outgoing->so ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Nomor DO</td>
                <td>: {{ $outgoing->no_do }}</td>
                <td style="font-weight: bold;">Produk</td>
                <td>: {{ $outgoing->produk }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Qty</td>
                <td>: {{ $outgoing->qty ?? '-' }}</td>
                <td style="font-weight: bold;">Lokasi</td>
                <td>: {{ $outgoing->lokasi }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">No Kendaraan</td>
                <td>: {{ $outgoing->no_kendaraan }}</td>
                <td style="font-weight: bold;">Keterangan</td>
                <td>: {{ $outgoing->keterangan }}</td>
            </tr>
        </table>

        {{-- Tabel Hasil Inspeksi Outgoing --}}
        <div style="margin-bottom: 20px;">
            <h3 style="font-family: Arial, sans-serif; font-size: 12pt; font-weight: bold; margin-bottom: 8px;">Hasil
                Inspeksi Outgoing</h3>
            <table width="100%" cellpadding="4" cellspacing="0"
                style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 9pt; border: 1px solid #000;">
                <thead>
                    <tr style="background-color: #f0f0f0;">
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 3%;">No</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 10%;">Inspektor
                        </th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">Label</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">Karat</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">Penyok</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">Kotor</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 10%;">Galvanized
                        </th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">Lasan</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">Mesh</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">PVC</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 10%;">Packing</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">QTY</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 10%;">Created At
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($outgoing->outgoinginspeksi as $inc)
                        <tr>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ $loop->iteration }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->user->name ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->label }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->karat }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->penyok }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->kotor }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->galvanized }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->lasan }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->mesh }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->pvc }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->packing }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $inc->qty }}
                            </td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ \Carbon\Carbon::parse($inc->created_at)->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13"
                                style="border: 1px solid #000; padding: 8px; text-align: center; font-style: italic;">
                                Belum ada data Inspeksi Outgoing</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tabel Daftar Defect --}}
        <div style="margin-bottom: 20px;">
            <h3 style="font-family: Arial, sans-serif; font-size: 12pt; font-weight: bold; margin-bottom: 8px;">Daftar
                Defect</h3>
            <table width="100%" cellpadding="4" cellspacing="0"
                style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 9pt; border: 1px solid #000;">
                <thead>
                    <tr style="background-color: #f0f0f0;">
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 4%;">No</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 22%;">Problem 1
                        </th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 22%;">Problem 2
                        </th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">Qty</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 10%;">Status</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 20%;">Inspektor
                        </th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 14%;">Tanggal
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($outgoing->defects as $defect)
                        <tr>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ $loop->iteration }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $defect->problem1 ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $defect->problem2 ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ $defect->qty }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ $defect->status }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $defect->user->name ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ \Carbon\Carbon::parse($defect->created_at)->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7"
                                style="border: 1px solid #000; padding: 8px; text-align: center; font-style: italic;">
                                Belum ada data Defect</td>
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
                        {{ $outgoing->outgoinginspeksi->first()->user->name ?? '.................' }}</p>
                    <p style="margin: 2px 0 0 0; font-style: italic;">Inspektor</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="margin: 0 0 5px 0; font-weight: bold;">Disetujui Oleh:</p>
                    <br><br><br>
                    <p style="margin: 0; border-top: 1px solid #000; width: 200px; padding-top: 5px;">
                        {{ $outgoing->approver->name ?? '.................' }}</p>
                    <p style="margin: 2px 0 0 0; font-style: italic;">Supervisor / Manager</p>
                </td>
            </tr>
        </table>
    </div>
    {{-- ==================== END PRINT SECTION ==================== --}}
</x-app-layout>
