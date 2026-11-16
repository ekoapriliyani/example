<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Detail Inspeksi Gabionanyam') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('inspeksi_gabionanyam.index') }}"
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
                    $isApproved = $inspeksiGabionanyam->approval_status === 'APPROVED';
                @endphp
                <div class="flex items-center gap-2">
                    {{-- Tambah WIP --}}
                    @if ($isApproved)
                        <button type="button" disabled
                            class="inline-flex cursor-not-allowed items-center gap-2 rounded-md bg-gray-400 px-4 py-2 text-sm font-semibold text-white opacity-60 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah WIP
                        </button>
                    @else
                        <a href="{{ route('inspeksi_gabionanyam.wip', $inspeksiGabionanyam->id) }}"
                            class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah WIP
                        </a>
                    @endif

                    {{-- Tambah FG --}}
                    @if ($isApproved)
                        <button type="button" disabled
                            class="inline-flex cursor-not-allowed items-center gap-2 rounded-md bg-gray-400 px-4 py-2 text-sm font-semibold text-white opacity-60 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah FG
                        </button>
                    @else
                        <a href="{{ route('inspeksi_gabionanyam.fg', $inspeksiGabionanyam->id) }}"
                            class="inline-flex items-center gap-2 rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah FG
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-green-100 shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    <div class="flex items-start justify-between">
                        <dl class="grid grid-cols-1 gap-x-8 gap-y-4 sm:grid-cols-4">
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Nomor Inspeksi</dt>
                                <dd class="text-lg font-bold text-indigo-600">
                                    {{ $inspeksiGabionanyam->nomor_inspeksi }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">PRO Number</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksiGabionanyam->pro->pro_id }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Description</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksiGabionanyam->pro->description }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">QTY Ordered</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksiGabionanyam->pro->qty }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Total Produksi per shift</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksiGabionanyam->total_prod }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Shift</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksiGabionanyam->shift }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Mesin</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksiGabionanyam->mesin->nama_mesin }}
                                </dd>
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
                        <h3 class="text-lg font-bold text-gray-800">Hasil Inspeksi WIP Gabionanyam</h3>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Aksi</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Inspektor</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No. Material</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Operator</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Type</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">L Act</th>
                                    {{-- <th class="px-4 py-3 font-semibold text-gray-900">L2 Act</th> --}}
                                    <th class="px-4 py-3 font-semibold text-gray-900">D Anyam</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">D Frame</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">D Anyam PVC/HDPE</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">D Frame PVC/HDPE</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Mesh 1</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Mesh 2</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">P Lilitan</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Jml Lilitan</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Visual</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Status</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Detail</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Gambar</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-900">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($inspeksiGabionanyam->inspeksiGabionanyamWip as $wip)
                                    <tr class="transition-colors hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                {{-- Edit --}}
                                                @if ($isApproved)
                                                    <button type="button" disabled
                                                        class="inline-flex cursor-not-allowed items-center rounded-md bg-gray-200 p-2 text-gray-400 opacity-70"
                                                        title="Data sudah approved">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5h2m-1-1v2m-6 9l-1 4 4-1 9-9a2.121 2.121 0 00-3-3l-9 9z" />
                                                        </svg>
                                                    </button>
                                                @else
                                                    <a href="{{ route('inspeksi_gabionanyam_wip.edit', $wip->id) }}"
                                                        class="inline-flex items-center rounded-md bg-yellow-100 p-2 text-yellow-600 transition hover:bg-yellow-200"
                                                        title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5h2m-1-1v2m-6 9l-1 4 4-1 9-9a2.121 2.121 0 00-3-3l-9 9z" />
                                                        </svg>
                                                    </a>
                                                @endif
                                                {{-- Delete --}}
                                                @if ($isApproved)
                                                    <button type="button" disabled
                                                        class="inline-flex cursor-not-allowed items-center rounded-md bg-gray-200 p-2 text-gray-400 opacity-70"
                                                        title="Data sudah approved">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8" />
                                                        </svg>
                                                    </button>
                                                @else
                                                    <form id="delete-form-{{ $wip->id }}"
                                                        action="{{ route('inspeksi_gabionanyam_wip.destroy', $wip->id) }}"
                                                        method="POST" class="delete-form inline-block">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="button"
                                                            onclick="confirmDelete('{{ $wip->id }}', '{{ $wip->id_project ?? $wip->id }}')"
                                                            class="inline-flex items-center rounded-md bg-red-100 p-2 text-red-600 transition hover:bg-red-200"
                                                            title="Hapus">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">{{ $wip->user->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 font-medium">{{ $wip->no_material }}</td>
                                        <td class="px-4 py-3">{{ $wip->nama_operator }}</td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->type }}</td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->l1_act }}</td>
                                        {{-- <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->l2_act }}</td> --}}
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->d_anyam }}</td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->d_frame }}</td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->d_anyam_pvc }}</td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->d_frame_pvc }}</td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->mesh1 }}</td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->mesh2 }}</td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->p_lilitan }}</td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->jml_lilitan }}</td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->visual }}</td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->status }}</td>
                                        <td class="px-4 py-3">
                                            <button type="button" class="text-sm text-indigo-600 hover:underline"
                                                onclick="toggleDetail2({{ $wip->id }})">
                                                Lihat Detail
                                            </button>
                                        </td>
                                        <td class="px-4 py-3">
                                            <button type="button" class="text-sm text-indigo-600 hover:underline"
                                                onclick="toggleImage2({{ $wip->id }})">
                                                Lihat Gambar
                                            </button>
                                        </td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->created_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center italic text-gray-400">Belum
                                            ada
                                            data WIP untuk inspeksi ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <div class="rounded-lg bg-indigo-100 p-2 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Data Finished Goods (FG)</h3>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Aksi</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Lot Number</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Inspektor</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Status</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Quantity</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Weight</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Packing</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Label</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Detail</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Gambar</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($inspeksiGabionanyam->inspeksiGabionanyamFg as $fg)
                                    <tr class="transition-colors hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                @if ($isApproved)
                                                    <button type="button" disabled
                                                        class="inline-flex cursor-not-allowed items-center rounded-md bg-gray-200 p-2 text-gray-400 opacity-70"
                                                        title="Data sudah approved">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5h2m-1-1v2m-6 9l-1 4 4-1 9-9a2.121 2.121 0 00-3-3l-9 9z" />
                                                        </svg>
                                                    </button>
                                                @else
                                                    <a href="{{ route('inspeksi_gabionanyam_fg.edit', $fg->id) }}"
                                                        class="inline-flex items-center rounded-md bg-yellow-100 p-2 text-yellow-600 transition hover:bg-yellow-200"
                                                        title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5h2m-1-1v2m-6 9l-1 4 4-1 9-9a2.121 2.121 0 00-3-3l-9 9z" />
                                                        </svg>
                                                    </a>
                                                @endif

                                                @if ($isApproved)
                                                    <button type="button" disabled
                                                        class="inline-flex cursor-not-allowed items-center rounded-md bg-gray-200 p-2 text-gray-400 opacity-70"
                                                        title="Data sudah approved">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8" />
                                                        </svg>
                                                    </button>
                                                @else
                                                    <form id="delete-fg-form-{{ $fg->id }}"
                                                        action="{{ route('inspeksi_gabionanyam_fg.destroy', $fg->id) }}"
                                                        method="POST" class="delete-form inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="confirmDeleteFg('{{ $fg->id }}', '{{ $fg->lot_number ?? $fg->id }}')"
                                                            class="inline-flex items-center rounded-md bg-red-100 p-2 text-red-600 transition hover:bg-red-200"
                                                            title="Hapus">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if ($fg->lot_number)
                                                    <a href="{{ route('inspeksi_gabionanyam_fg.qrcode', $fg->id) }}"
                                                        target="_blank"
                                                        class="inline-flex items-center rounded-md bg-blue-100 p-2 text-blue-600 transition hover:bg-blue-200"
                                                        title="Print QR">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                                        </svg>
                                                    </a>
                                                @endif

                                                @if (in_array($fg->status, ['NG', 'REJECT']))
                                                    <button type="button"
                                                        onclick="toggleHandling({{ $fg->id }})"
                                                        class="inline-flex items-center rounded-md bg-orange-100 p-2 text-orange-600 transition hover:bg-orange-200"
                                                        title="Handling NG/REJECT">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 font-mono text-xs">{{ $fg->lot_number ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $fg->user->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">
                                            @if ($fg->status === 'OK')
                                                <span
                                                    class="rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-700">OK</span>
                                            @elseif ($fg->status === 'NG')
                                                <span
                                                    class="rounded-full bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-700">NG</span>
                                            @elseif ($fg->status === 'REJECT')
                                                <span
                                                    class="rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-700">REJECT</span>
                                            @else
                                                <span
                                                    class="rounded-full bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700">{{ $fg->status }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">{{ $fg->qty }}</td>
                                        <td class="px-4 py-3">{{ $fg->weight ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $fg->packing }}</td>
                                        <td class="px-4 py-3">{{ $fg->label }}</td>
                                        <td class="px-4 py-3">
                                            <button type="button" class="text-sm text-indigo-600 hover:underline"
                                                onclick="toggleDetail({{ $fg->id }})">Lihat Detail</button>
                                        </td>
                                        <td class="px-4 py-3">
                                            <button type="button" class="text-sm text-indigo-600 hover:underline"
                                                onclick="toggleImage({{ $fg->id }})">Lihat Gambar</button>
                                        </td>
                                        <td class="px-4 py-3">{{ $fg->created_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="px-4 py-8 text-center italic text-gray-400">Belum
                                            ada data FG untuk inspeksi ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- modal detail wip --}}
                    @foreach ($inspeksiGabionanyam->inspeksiGabionanyamWip as $wip)
                        <div id="detail2-{{ $wip->id }}"
                            class="fixed inset-0 z-50 flex hidden items-center justify-center bg-gray-900 bg-opacity-50">
                            <div class="w-1/2 rounded-lg bg-white p-6 shadow-lg">
                                <table class="min-w-full divide-y divide-gray-200 text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2">No</th>
                                            <th class="px-4 py-2">Description</th>
                                            <th class="px-4 py-2">Description 2</th>
                                            <th class="px-4 py-2">QTY</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @forelse ($wip->details as $detail)
                                            <tr>
                                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-2">{{ $detail->description }}</td>
                                                <td class="px-4 py-2">{{ $detail->description2 }}</td>
                                                <td class="px-4 py-2">{{ $detail->qty }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-4 text-center italic text-gray-400">
                                                    Belum ada detail untuk WIP ini.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-4 text-right">
                                    <button onclick="toggleDetail2({{ $wip->id }})"
                                        class="rounded bg-gray-200 px-4 py-2 hover:bg-gray-300">Tutup</button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- modal gambar wip --}}
                    @foreach ($inspeksiGabionanyam->inspeksiGabionanyamWip as $wip)
                        <div id="image2-{{ $wip->id }}"
                            class="fixed inset-0 z-50 flex hidden items-center justify-center bg-gray-900 bg-opacity-50">
                            <div class="max-h-[80vh] w-3/4 overflow-y-auto rounded-lg bg-white p-6 shadow-lg">
                                @if ($wip->files)
                                    <div class="space-y-4">
                                        @foreach ($wip->files as $file)
                                            @php $ext = pathinfo($file, PATHINFO_EXTENSION); @endphp
                                            @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                                <img src="{{ asset('storage/' . $file) }}" alt="Wip Image"
                                                    class="max-h-64 w-full rounded border object-contain" />
                                            @else
                                                <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                                    class="block text-blue-600 hover:underline">Lihat File
                                                    ({{ strtoupper($ext) }})
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p class="italic text-gray-400">Tidak ada gambar diupload.</p>
                                @endif
                                <div class="mt-4 text-right">
                                    <button onclick="toggleImage2({{ $wip->id }})"
                                        class="rounded bg-gray-200 px-4 py-2 hover:bg-gray-300">Tutup</button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- modal detail fg --}}
                    @foreach ($inspeksiGabionanyam->inspeksiGabionanyamFg as $fg)
                        <div id="detail-{{ $fg->id }}"
                            class="fixed inset-0 z-50 flex hidden items-center justify-center bg-gray-900 bg-opacity-50">
                            <div class="w-1/2 rounded-lg bg-white p-6 shadow-lg">
                                <h3 class="mb-4 text-lg font-semibold">Detail FG: {{ $fg->lot_number ?? '-' }}</h3>
                                <table class="min-w-full divide-y divide-gray-200 text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2">No</th>
                                            <th class="px-4 py-2">Description</th>
                                            <th class="px-4 py-2">Description 2</th>
                                            <th class="px-4 py-2">QTY</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @forelse ($fg->details as $detail)
                                            <tr>
                                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-2">{{ $detail->description }}</td>
                                                <td class="px-4 py-2">{{ $detail->description2 }}</td>
                                                <td class="px-4 py-2">{{ $detail->qty }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-4 text-center italic text-gray-400">
                                                    Belum ada detail untuk FG ini.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-4 text-right">
                                    <button onclick="toggleDetail({{ $fg->id }})"
                                        class="rounded bg-gray-200 px-4 py-2 hover:bg-gray-300">Tutup</button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- modal gambar fg --}}
                    @foreach ($inspeksiGabionanyam->inspeksiGabionanyamFg as $fg)
                        <div id="image-{{ $fg->id }}"
                            class="fixed inset-0 z-50 flex hidden items-center justify-center bg-gray-900 bg-opacity-50">
                            <div class="max-h-[80vh] w-3/4 overflow-y-auto rounded-lg bg-white p-6 shadow-lg">
                                @if ($fg->files)
                                    <div class="space-y-4">
                                        @foreach ($fg->files as $file)
                                            @php $ext = pathinfo($file, PATHINFO_EXTENSION); @endphp
                                            @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                                <img src="{{ asset('storage/' . $file) }}" alt="FG Image"
                                                    class="max-h-64 w-full rounded border object-contain" />
                                            @else
                                                <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                                    class="block text-blue-600 hover:underline">Lihat File
                                                    ({{ strtoupper($ext) }})
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p class="italic text-gray-400">Tidak ada gambar diupload.</p>
                                @endif
                                <div class="mt-4 text-right">
                                    <button onclick="toggleImage({{ $fg->id }})"
                                        class="rounded bg-gray-200 px-4 py-2 hover:bg-gray-300">Tutup</button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- modal handling fg --}}
                    @foreach ($inspeksiGabionanyam->inspeksiGabionanyamFg as $fg)
                        @if (in_array($fg->status, ['NG', 'REJECT']))
                            <div id="handling-{{ $fg->id }}"
                                class="fixed inset-0 z-50 flex hidden items-center justify-center bg-gray-900 bg-opacity-50">
                                <div
                                    class="max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-lg bg-white p-6 shadow-lg">
                                    <div class="mb-4 flex items-center justify-between">
                                        <h3 class="text-lg font-semibold">Handling - {{ $fg->lot_number ?? '-' }}</h3>
                                        <button onclick="toggleHandling({{ $fg->id }})"
                                            class="rounded bg-gray-200 px-3 py-1 hover:bg-gray-300">Tutup</button>
                                    </div>

                                    <div class="mb-4 rounded border border-gray-200 bg-gray-50 p-3 text-sm">
                                        <p><strong>Status:</strong> {{ $fg->status }} | <strong>Qty:</strong>
                                            {{ $fg->qty }} | <strong>Weight:</strong> {{ $fg->weight ?? '-' }}
                                        </p>
                                    </div>

                                    @if ($fg->handlings->isNotEmpty())
                                        <div class="mb-6">
                                            <h4 class="mb-2 font-semibold text-gray-700">Riwayat Handling</h4>
                                            <div class="space-y-3">
                                                @foreach ($fg->handlings as $handling)
                                                    <div class="rounded border border-gray-200 p-3">
                                                        <div class="mb-2 flex items-center justify-between text-sm">
                                                            <div>
                                                                <span
                                                                    class="font-medium">{{ $handling->tanggal }}</span>
                                                                <span class="text-gray-500">oleh
                                                                    {{ $handling->user->name ?? '-' }}</span>
                                                                @if ($handling->catatan)
                                                                    <span class="text-gray-600">-
                                                                        {{ $handling->catatan }}</span>
                                                                @endif
                                                            </div>
                                                            <form
                                                                action="{{ route('inspeksi_gabionanyam_fg_handling.destroy', [$fg->id, $handling->id]) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Hapus data handling ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="text-xs text-red-600 hover:underline">Hapus</button>
                                                            </form>
                                                        </div>
                                                        <table class="min-w-full text-sm">
                                                            <thead class="bg-gray-50">
                                                                <tr>
                                                                    <th class="px-2 py-1 text-left">Status</th>
                                                                    <th class="px-2 py-1 text-left">Qty</th>
                                                                    <th class="px-2 py-1 text-left">Weight</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($handling->details as $hDetail)
                                                                    <tr class="border-t">
                                                                        <td class="px-2 py-1">{{ $hDetail->status }}
                                                                        </td>
                                                                        <td class="px-2 py-1">{{ $hDetail->qty }}</td>
                                                                        <td class="px-2 py-1">{{ $hDetail->weight }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="border-t pt-4">
                                        <h4 class="mb-2 font-semibold text-gray-700">Tambah Handling</h4>
                                        <form action="{{ route('inspeksi_gabionanyam_fg_handling.store', $fg->id) }}"
                                            method="POST" class="space-y-4">
                                            @csrf
                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700">Tanggal</label>
                                                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                                        required>
                                                </div>
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700">Catatan</label>
                                                    <input type="text" name="catatan"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                                        placeholder="Opsional">
                                                </div>
                                            </div>

                                            <div id="handling-details-{{ $fg->id }}" class="space-y-2">
                                                <div class="grid grid-cols-12 gap-2">
                                                    <div class="col-span-4">
                                                        <label
                                                            class="block text-xs font-medium text-gray-700">Status</label>
                                                        <select name="details[0][status]"
                                                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm"
                                                            required>
                                                            <option value="OK">OK</option>
                                                            <option value="NG">NG</option>
                                                            <option value="REJECT">REJECT</option>
                                                            <option value="REPAIR">REPAIR</option>
                                                            <option value="SCRAP">SCRAP</option>
                                                            <option value="DOWNGRADE">DOWNGRADE</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-span-3">
                                                        <label
                                                            class="block text-xs font-medium text-gray-700">Qty</label>
                                                        <input type="number" name="details[0][qty]" min="0"
                                                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm"
                                                            required>
                                                    </div>
                                                    <div class="col-span-3">
                                                        <label
                                                            class="block text-xs font-medium text-gray-700">Weight</label>
                                                        <input type="number" step="0.01"
                                                            name="details[0][weight]" min="0"
                                                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm"
                                                            required>
                                                    </div>
                                                    <div class="col-span-2 flex items-end">
                                                        <button type="button"
                                                            onclick="addHandlingRow({{ $fg->id }})"
                                                            class="w-full rounded bg-indigo-600 px-2 py-2 text-xs text-white hover:bg-indigo-700">+
                                                            Row</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <button type="submit"
                                                    class="rounded bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">Simpan
                                                    Handling</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">
                                    Approval Inspeksi Gabionanyam
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Review data inspeksi sebelum melakukan approval.
                                </p>
                            </div>
                        </div>
                        <!-- Middle + Right -->
                        <div class="flex items-center gap-4">
                            <!-- Status -->
                            @if ($inspeksiGabionanyam->isApproved())
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
                                <form id="approval-form-{{ $inspeksiGabionanyam->id }}"
                                    action="{{ route('inspeksi-gabionanyam.toggle', $inspeksiGabionanyam->id) }}"
                                    method="POST" class="hidden">
                                    @csrf
                                    @method('PATCH')
                                </form>
                                <button type="button"
                                    onclick="confirmApproval({{ $inspeksiGabionanyam->id }}, '{{ $inspeksiGabionanyam->isApproved() ? 'unapprove' : 'approve' }}')"
                                    class="{{ $inspeksiGabionanyam->isApproved()
                                        ? 'bg-orange-500 text-white hover:bg-orange-600'
                                        : 'bg-green-600 text-white hover:bg-green-700' }} inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold shadow-sm transition">
                                    @if ($inspeksiGabionanyam->isApproved())
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
        </div>
    </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function toggleDetail(id) {
            const modal = document.getElementById('detail-' + id);
            modal.classList.toggle('hidden');
        }

        function toggleDetail2(id) {
            const modal = document.getElementById('detail2-' + id);
            modal.classList.toggle('hidden');
        }

        function toggleImage(id) {
            const modal = document.getElementById('image-' + id);
            modal.classList.toggle('hidden');
        }

        function toggleImage2(id) {
            const modal = document.getElementById('image2-' + id);
            modal.classList.toggle('hidden');
        }

        function toggleHandling(id) {
            const modal = document.getElementById('handling-' + id);
            if (modal) modal.classList.toggle('hidden');
        }

        let handlingRowIndex = 1;

        function addHandlingRow(fgId) {
            const container = document.getElementById('handling-details-' + fgId);
            if (!container) return;
            const idx = handlingRowIndex++;
            const html = `
                <div class="grid grid-cols-12 gap-2 handling-row">
                    <div class="col-span-4">
                        <select name="details[${idx}][status]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm" required>
                            <option value="OK">OK</option>
                            <option value="NG">NG</option>
                            <option value="REJECT">REJECT</option>
                            <option value="REPAIR">REPAIR</option>
                            <option value="SCRAP">SCRAP</option>
                            <option value="DOWNGRADE">DOWNGRADE</option>
                        </select>
                    </div>
                    <div class="col-span-3">
                        <input type="number" name="details[${idx}][qty]" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm" required>
                    </div>
                    <div class="col-span-3">
                        <input type="number" step="0.01" name="details[${idx}][weight]" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm" required>
                    </div>
                    <div class="col-span-2 flex items-end">
                        <button type="button" onclick="this.closest('.handling-row').remove()" class="w-full rounded bg-red-500 px-2 py-2 text-xs text-white hover:bg-red-600">Hapus</button>
                    </div>
                </div>`;
            container.insertAdjacentHTML('beforeend', html);
        }

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

        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus data WIP?',
                text: "Data WIP terkait " + name + " akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#4f46e5',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        function confirmDeleteFg(id, name) {
            Swal.fire({
                title: 'Hapus data FG?',
                text: "Data FG " + name + " akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#4f46e5',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-fg-form-' + id).submit();
                }
            })
        }

        function confirmApproval(id, type) {
            let isUnapprove = type === 'unapprove';
            Swal.fire({
                title: isUnapprove ? 'Batalkan approval?' : 'Approve data?',
                text: isUnapprove ? "Status akan kembali ke Pending." : "Data akan disetujui.",
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
                        INSPEKSI HARIAN GABION ANYAM</h1>
                </td>
                <td
                    style="width: 20%; vertical-align: top; text-align: right; font-family: Arial, sans-serif; font-size: 11pt;">
                    <table cellpadding="3" cellspacing="0" style="border: 1px solid #000; margin-left: auto;">
                        <tr>
                            <td style="font-weight: bold; font-size: 10pt;">BM-F-QC-02 R01</td>
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
                <td style="width: 30%;">: {{ $inspeksiGabionanyam->nomor_inspeksi }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">PRO Number</td>
                <td>: {{ $inspeksiGabionanyam->pro->pro_id }}</td>
                <td style="font-weight: bold;">Description</td>
                <td>: {{ $inspeksiGabionanyam->pro->description }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">QTY Ordered</td>
                <td>: {{ $inspeksiGabionanyam->pro->qty }}</td>
                <td style="font-weight: bold;">Total Prod Per Shift</td>
                <td>: {{ $inspeksiGabionanyam->total_prod }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Shift</td>
                <td>: {{ $inspeksiGabionanyam->shift }}</td>
                <td style="font-weight: bold;">Mesin</td>
                <td>: {{ $inspeksiGabionanyam->mesin->nama_mesin }}</td>
            </tr>
        </table>

        {{-- Tabel WIP --}}
        <div style="margin-bottom: 20px;">
            <h3 style="font-family: Arial, sans-serif; font-size: 12pt; font-weight: bold; margin-bottom: 8px;">Hasil
                Inspeksi WIP Gabion Anyam</h3>
            <table width="100%" cellpadding="4" cellspacing="0"
                style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 9pt; border: 1px solid #000;">
                <thead>
                    <tr style="background-color: #f0f0f0;">
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 3%;">No</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 7%;">Inspektor</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 7%;">No. Material
                        </th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 7%;">Operator</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 5%;">Type</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 5%;">L Act</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 6%;">D Anyam</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 6%;">D Frame</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 6%;">D Anyam PVC
                        </th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 6%;">D Frame PVC
                        </th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 5%;">Mesh 1</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 5%;">Mesh 2</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 6%;">P Lilitan</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 6%;">Jml Lilitan
                        </th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 6%;">Visual</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 6%;">Status</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 7%;">Created At
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inspeksiGabionanyam->inspeksiGabionanyamWip as $wip)
                        <tr>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ $loop->iteration }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $wip->user->name ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $wip->no_material }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $wip->nama_operator }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $wip->type }}
                            </td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $wip->l1_act }}
                            </td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $wip->d_anyam }}
                            </td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $wip->d_frame }}
                            </td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ $wip->d_anyam_pvc }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ $wip->d_frame_pvc }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $wip->mesh1 }}
                            </td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $wip->mesh2 }}
                            </td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ $wip->p_lilitan }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ $wip->jml_lilitan }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $wip->visual }}
                            </td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $wip->status }}
                            </td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ optional($wip->created_at)->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="17"
                                style="border: 1px solid #000; padding: 8px; text-align: center; font-style: italic;">
                                Belum ada data WIP</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tabel FG --}}
        <div style="margin-bottom: 20px;">
            <h3 style="font-family: Arial, sans-serif; font-size: 12pt; font-weight: bold; margin-bottom: 8px;">Hasil
                Inspeksi Finished Goods (FG)</h3>
            <table width="100%" cellpadding="4" cellspacing="0"
                style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 9pt; border: 1px solid #000;">
                <thead>
                    <tr style="background-color: #f0f0f0;">
                        <th style="border: 1px solid #000; padding: 5px; text-align: center;">No</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center;">Lot Number</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center;">Inspektor</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center;">Status</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center;">Quantity</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center;">Weight</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center;">Packing</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center;">Label</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center;">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inspeksiGabionanyam->inspeksiGabionanyamFg as $fg)
                        <tr>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ $loop->iteration }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $fg->lot_number ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $fg->user->name ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $fg->status }}
                            </td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $fg->qty }}
                            </td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ $fg->weight ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $fg->packing }}
                            </td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $fg->label }}
                            </td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ optional($fg->created_at)->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9"
                                style="border: 1px solid #000; padding: 8px; text-align: center; font-style: italic;">
                                Belum ada data FG</td>
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
                        {{ $inspeksiGabionanyam->inspeksiGabionanyamWip->first()->user->name ?? ($inspeksiGabionanyam->inspeksiGabionanyamFg->first()->user->name ?? '.................') }}
                    </p>
                    <p style="margin: 2px 0 0 0; font-style: italic;">Inspektor</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="margin: 0 0 5px 0; font-weight: bold;">Disetujui Oleh:</p>
                    <br><br><br>
                    <p style="margin: 0; border-top: 1px solid #000; width: 200px; padding-top: 5px;">
                        {{ $inspeksiGabionanyam->approver->name ?? '.................' }}</p>
                    <p style="margin: 2px 0 0 0; font-style: italic;">Supervisor / Manager</p>
                </td>
            </tr>
        </table>
    </div>
    {{-- ==================== END PRINT SECTION ==================== --}}

    <script>
        function printInspeksi() {
            window.print();
        }
    </script>
</x-app-layout>
