<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Detail Inspeksi WM') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('inspeksi_wm.index') }}"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                    Kembali
                </a>
                @php
                    $isApproved = $inspeksi_wm->approval_status === 'APPROVED';
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
                        <a href="{{ route('inspeksi_wm.wip', $inspeksi_wm->id) }}"
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
                        <a href="{{ route('inspeksi_wm.fg', $inspeksi_wm->id) }}"
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
                                <dd class="text-lg font-bold text-indigo-600">{{ $inspeksi_wm->nomor_inspeksi }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">PRO Number</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksi_wm->pro->pro_id }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Description</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksi_wm->pro->description }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">QTY Ordered</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksi_wm->pro->qty }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Total Produksi per shift</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksi_wm->total_prod }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Shift</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksi_wm->shift }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Grade</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksi_wm->grade }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Type Coating</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksi_wm->type_coating }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium italic text-gray-500">Mesin</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksi_wm->mesin->nama_mesin }}
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
                        <h3 class="text-lg font-bold text-gray-800">Hasil Inspeksi WIP Wiremesh</h3>
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
                                    <th class="px-4 py-3 font-semibold text-gray-900">D. Kawat Act</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Selisih Diagonal</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">P Produk</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">L Produk</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">P Mesh</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">L Mesh</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Torsi Strength</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Dimensi</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Visual</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Shear Strength</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Weight</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Detail</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Gambar</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-900">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($inspeksi_wm->inspeksiWmWip as $wip)
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
                                                    <a href="{{ route('inspeksi_wm_wip.edit', $wip->id) }}"
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
                                                    <form action="{{ route('inspeksi_wm_wip.destroy', $wip->id) }}"
                                                        method="POST" class="delete-form inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
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
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->d_kawat_act }}</td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->selisih_diagonal }}
                                        </td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->p_product_act }}</td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->l_product_act }}</td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->p_mesh_act }}</td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->l_mesh_act }}</td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->torsi_strength }}
                                        </td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->status_dimensi }}
                                        </td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->visual }}
                                        </td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->shear_strength }}
                                        </td>
                                        <td class="bg-blue-50/30 px-4 py-3 text-center">{{ $wip->weight }}</td>
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
                        <div class="rounded-lg bg-green-100 p-2 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                                @forelse ($inspeksi_wm->inspeksiWmFg as $fg)
                                    <tr class="transition-colors hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium">{{ $loop->iteration }}</td>
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
                                                    <a href="{{ route('inspeksi_wm_fg.edit', $fg->id) }}"
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
                                                    <form action="{{ route('inspeksi_wm_fg.destroy', $fg->id) }}"
                                                        method="POST" class="delete-form inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
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
                                                {{-- QR Code --}}
                                                @if ($fg->lot_number)
                                                    <a href="{{ route('inspeksi_wm_fg.qrcode', $fg->id) }}"
                                                        target="_blank"
                                                        class="inline-flex items-center rounded-md bg-blue-100 p-2 text-blue-600 transition hover:bg-blue-200"
                                                        title="Cetak QR Code">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                                        </svg>
                                                    </a>
                                                @endif
                                                {{-- Handling --}}
                                                @if (in_array($fg->status, ['NG', 'REJECT']))
                                                    <button type="button"
                                                        onclick="toggleHandling({{ $fg->id }})"
                                                        class="inline-flex items-center rounded-md bg-orange-100 p-2 text-orange-600 transition hover:bg-orange-200"
                                                        title="Handling">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 font-medium">
                                            @if ($fg->lot_number)
                                                <span class="text-blue-600">{{ $fg->lot_number }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 font-medium">{{ $fg->user->name }}</td>
                                        <td class="px-4 py-3 font-medium">
                                            @if ($fg->status === 'OK')
                                                <span class="rounded bg-green-100 px-2 py-1 text-green-800">
                                                    {{ $fg->status }}
                                                </span>
                                            @elseif($fg->status === 'NG')
                                                <span class="rounded bg-yellow-100 px-2 py-1 text-yellow-800">
                                                    {{ $fg->status }}
                                                </span>
                                            @elseif($fg->status === 'REJECT')
                                                <span class="rounded bg-red-100 px-2 py-1 text-red-800">
                                                    {{ $fg->status }}
                                                </span>
                                            @else
                                                <span class="rounded bg-gray-100 px-2 py-1 text-gray-800">
                                                    {{ $fg->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">{{ $fg->qty }}</td>
                                        <td class="px-4 py-3">{{ $fg->weight }} Kg</td>
                                        <td class="px-4 py-3">{{ $fg->packing }}</td>
                                        <td class="px-4 py-3">{{ $fg->label }}</td>
                                        <td class="px-4 py-3">
                                            <button type="button" class="text-sm text-indigo-600 hover:underline"
                                                onclick="toggleDetail({{ $fg->id }})">
                                                Lihat Detail
                                            </button>
                                        </td>
                                        <td class="px-4 py-3">
                                            <button type="button" class="text-sm text-indigo-600 hover:underline"
                                                onclick="toggleImage({{ $fg->id }})">
                                                Lihat Gambar
                                            </button>
                                        </td>
                                        <td class="px-4 py-3">{{ $fg->created_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-8 text-center italic text-gray-400">Belum
                                            ada data FG untuk inspeksi ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{-- modal detail fg --}}
                        @foreach ($inspeksi_wm->inspeksiWmFg as $fg)
                            <div id="detail-{{ $fg->id }}"
                                class="fixed inset-0 flex hidden items-center justify-center bg-gray-900 bg-opacity-50">
                                <div class="w-1/2 rounded-lg bg-white p-6 shadow-lg">
                                    <h3 class="mb-4 text-lg font-semibold">Detail FG: {{ $fg->batch_number }}</h3>
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
                                                    <td colspan="3"
                                                        class="px-4 py-4 text-center italic text-gray-400">
                                                        Belum ada detail untuk FG ini.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="mt-4 text-right">
                                        <button onclick="toggleDetail({{ $fg->id }})"
                                            class="rounded bg-gray-200 px-4 py-2 hover:bg-gray-300">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        {{-- modal detail wip --}}
                        @foreach ($inspeksi_wm->inspeksiWmWip as $wip)
                            <div id="detail2-{{ $wip->id }}"
                                class="fixed inset-0 flex hidden items-center justify-center bg-gray-900 bg-opacity-50">
                                <div class="w-1/2 rounded-lg bg-white p-6 shadow-lg">
                                    {{-- <h3 class="text-lg font-semibold mb-4">Detail FG: {{ $wip->batch_number }}</h3> --}}
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
                                                    <td colspan="3"
                                                        class="px-4 py-4 text-center italic text-gray-400">
                                                        Belum ada detail untuk WIP ini.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="mt-4 text-right">
                                        <button onclick="toggleDetail2({{ $wip->id }})"
                                            class="rounded bg-gray-200 px-4 py-2 hover:bg-gray-300">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- modal gambar fg --}}
                        @foreach ($inspeksi_wm->inspeksiWmFg as $fg)
                            <div id="image-{{ $fg->id }}"
                                class="fixed inset-0 flex hidden items-center justify-center bg-gray-900 bg-opacity-50">
                                <div class="max-h-[80vh] w-3/4 overflow-y-auto rounded-lg bg-white p-6 shadow-lg">
                                    {{-- <h3 class="text-lg font-semibold mb-4">Gambar FG: {{ $fg->batch_number }}</h3> --}}

                                    @if ($fg->files)
                                        <div class="space-y-4">
                                            @foreach ($fg->files as $file)
                                                @php $ext = pathinfo($file, PATHINFO_EXTENSION); @endphp

                                                @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                                    <img src="{{ asset('storage/' . $file) }}" alt="FG Image"
                                                        class="max-h-64 w-full rounded border object-contain" />
                                                @else
                                                    <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                                        class="block text-blue-600 hover:underline">
                                                        Lihat File ({{ strtoupper($ext) }})
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="italic text-gray-400">Tidak ada gambar diupload.</p>
                                    @endif

                                    <div class="mt-4 text-right">
                                        <button onclick="toggleImage({{ $fg->id }})"
                                            class="rounded bg-gray-200 px-4 py-2 hover:bg-gray-300">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

        {{-- modal gambar wip --}}
        @foreach ($inspeksi_wm->inspeksiWmWip as $wip)
            <div id="image2-{{ $wip->id }}"
                class="fixed inset-0 flex hidden items-center justify-center bg-gray-900 bg-opacity-50">
                <div class="max-h-[80vh] w-3/4 overflow-y-auto rounded-lg bg-white p-6 shadow-lg">
                    {{-- <h3 class="text-lg font-semibold mb-4">Gambar WIP: {{ $wip->batch_number }}</h3> --}}

                    @if ($wip->files)
                        <div class="space-y-4">
                            @foreach ($wip->files as $file)
                                @php $ext = pathinfo($file, PATHINFO_EXTENSION); @endphp

                                @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                    <img src="{{ asset('storage/' . $file) }}" alt="Wip Image"
                                        class="max-h-64 w-full rounded border object-contain" />
                                @else
                                    <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                        class="block text-blue-600 hover:underline">
                                        Lihat File ({{ strtoupper($ext) }})
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="italic text-gray-400">Tidak ada gambar diupload.</p>
                    @endif

                    <div class="mt-4 text-right">
                        <button onclick="toggleImage2({{ $wip->id }})"
                            class="rounded bg-gray-200 px-4 py-2 hover:bg-gray-300">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- modal handling fg --}}
        @foreach ($inspeksi_wm->inspeksiWmFg as $fg)
            @if (in_array($fg->status, ['NG', 'REJECT']))
                <div id="handling-{{ $fg->id }}"
                    class="fixed inset-0 flex hidden items-center justify-center bg-gray-900 bg-opacity-50 z-50">
                    <div class="max-h-[90vh] w-3/4 overflow-y-auto rounded-lg bg-white p-6 shadow-lg">
                        <div class="mb-4 flex items-center justify-between border-b pb-3">
                            <h3 class="text-lg font-semibold">
                                Handling Lot: <span class="text-blue-600">{{ $fg->lot_number }}</span>
                            </h3>
                            <button onclick="toggleHandling({{ $fg->id }})"
                                class="rounded bg-gray-200 px-3 py-1 text-sm hover:bg-gray-300">
                                Tutup
                            </button>
                        </div>

                        {{-- Info Lot --}}
                        <div class="mb-4 grid grid-cols-4 gap-4 rounded bg-gray-50 p-3 text-sm">
                            <div><span class="font-semibold">Status:</span> {{ $fg->status }}</div>
                            <div><span class="font-semibold">Qty:</span> {{ $fg->qty }}</div>
                            <div><span class="font-semibold">Weight:</span> {{ $fg->weight }} Kg</div>
                            <div><span class="font-semibold">Lot:</span> {{ $fg->lot_number }}</div>
                        </div>

                        {{-- Riwayat Handling --}}
                        @if ($fg->handlings->isNotEmpty())
                            <div class="mb-4">
                                <h4 class="mb-2 text-sm font-semibold text-gray-700">Riwayat Handling</h4>
                                <div class="overflow-x-auto rounded border">
                                    <table class="min-w-full divide-y divide-gray-200 text-left text-xs">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-3 py-2">Tanggal</th>
                                                <th class="px-3 py-2">User</th>
                                                <th class="px-3 py-2">Catatan</th>
                                                <th class="px-3 py-2">Status</th>
                                                <th class="px-3 py-2">Qty</th>
                                                <th class="px-3 py-2">Weight</th>
                                                <th class="px-3 py-2">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach ($fg->handlings as $handling)
                                                @foreach ($handling->details as $detail)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-3 py-2">{{ $handling->tanggal }}</td>
                                                        <td class="px-3 py-2">{{ $handling->user->name }}</td>
                                                        <td class="px-3 py-2 max-w-[150px] truncate">{{ $handling->catatan ?? '-' }}</td>
                                                        <td class="px-3 py-2">
                                                            <span class="rounded px-2 py-0.5 text-xs font-medium
                                                                {{ $detail->status === 'OK' ? 'bg-green-100 text-green-800' : '' }}
                                                                {{ $detail->status === 'NG' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                                {{ $detail->status === 'REJECT' ? 'bg-red-100 text-red-800' : '' }}
                                                                {{ $detail->status === 'REPAIR' ? 'bg-blue-100 text-blue-800' : '' }}
                                                                {{ $detail->status === 'SCRAP' ? 'bg-gray-100 text-gray-800' : '' }}
                                                                {{ $detail->status === 'DOWNGRADE' ? 'bg-purple-100 text-purple-800' : '' }}">
                                                                {{ $detail->status }}
                                                            </span>
                                                        </td>
                                                        <td class="px-3 py-2">{{ $detail->qty }}</td>
                                                        <td class="px-3 py-2">{{ $detail->weight }} Kg</td>
                                                        <td class="px-3 py-2">
                                                            @if ($loop->first)
                                                                <form action="{{ route('inspeksi_wm_fg_handling.destroy', [$fg->id, $handling->id]) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Hapus handling ini?');">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        {{-- Form Handling Baru --}}
                        <form action="{{ route('inspeksi_wm_fg_handling.store', $fg->id) }}" method="POST">
                            @csrf
                            <div class="mb-3 grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Catatan</label>
                                    <input type="text" name="catatan" placeholder="Opsional"
                                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                </div>
                            </div>

                            <div class="mb-3 flex items-center justify-between">
                                <h4 class="text-sm font-semibold text-gray-700">Detail Handling</h4>
                                <button type="button" onclick="addHandlingRow({{ $fg->id }})"
                                    class="inline-flex items-center gap-1 rounded bg-indigo-100 px-3 py-1 text-xs font-medium text-indigo-700 hover:bg-indigo-200">
                                    + Tambah Baris
                                </button>
                            </div>

                            <div class="overflow-x-auto rounded border">
                                <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-3 py-2 text-xs font-semibold text-gray-700">Status</th>
                                            <th class="px-3 py-2 text-xs font-semibold text-gray-700">Qty</th>
                                            <th class="px-3 py-2 text-xs font-semibold text-gray-700">Weight (Kg)</th>
                                            <th class="px-3 py-2 text-xs font-semibold text-gray-700">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="handling-details-{{ $fg->id }}" class="divide-y divide-gray-200">
                                        <tr class="handling-row">
                                            <td class="px-3 py-2">
                                                <select name="details[0][status]" required
                                                    class="block w-full rounded border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    <option value="">Pilih Status</option>
                                                    <option value="OK">OK</option>
                                                    <option value="NG">NG</option>
                                                    <option value="REJECT">REJECT</option>
                                                    <option value="REPAIR">REPAIR</option>
                                                    <option value="SCRAP">SCRAP</option>
                                                    <option value="DOWNGRADE">DOWNGRADE</option>
                                                </select>
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="number" name="details[0][qty]" min="0" value="0" required
                                                    class="block w-24 rounded border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="number" name="details[0][weight]" min="0" step="0.01" value="0" required
                                                    class="block w-28 rounded border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-3 py-2">
                                                <button type="button" onclick="this.closest('tr').remove()"
                                                    class="text-red-600 hover:underline text-xs">Hapus</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 flex justify-end gap-2">
                                <button type="button" onclick="toggleHandling({{ $fg->id }})"
                                    class="rounded border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="rounded bg-orange-600 px-4 py-2 text-sm text-white hover:bg-orange-700">
                                    Simpan Handling
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endforeach
                    </div>  {{-- End overflow-x-auto --}}
                </div>  {{-- End p-6 --}}
            </div>  {{-- End FG card --}}

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
                                    Approval Inspeksi WM
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Review data inspeksi sebelum melakukan approval.
                                </p>
                            </div>
                        </div>
                        <!-- Middle + Right -->
                        <div class="flex items-center gap-4">
                            <!-- Status -->
                            @if ($inspeksi_wm->isApproved())
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
                                <form id="approval-form-{{ $inspeksi_wm->id }}"
                                    action="{{ route('inspeksi-wm.toggle', $inspeksi_wm->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('PATCH')
                                </form>
                                <button type="button"
                                    onclick="confirmApproval({{ $inspeksi_wm->id }}, '{{ $inspeksi_wm->isApproved() ? 'unapprove' : 'approve' }}')"
                                    class="{{ $inspeksi_wm->isApproved()
                                        ? 'bg-orange-500 text-white hover:bg-orange-600'
                                        : 'bg-green-600 text-white hover:bg-green-700' }} inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold shadow-sm transition">
                                    @if ($inspeksi_wm->isApproved())
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


    <script>
        function toggleDetail(id) {
            const modal = document.getElementById('detail-' + id);
            modal.classList.toggle('hidden');
        }
    </script>
    <script>
        function toggleDetail2(id) {
            const modal = document.getElementById('detail2-' + id);
            modal.classList.toggle('hidden');
        }
    </script>
    <script>
        function toggleImage(id) {
            const modal = document.getElementById('image-' + id);
            modal.classList.toggle('hidden');
        }
    </script>
    <script>
        function toggleImage2(id) {
            const modal = document.getElementById('image2-' + id);
            modal.classList.toggle('hidden');
        }
    </script>
    <script>
        function toggleHandling(id) {
            const modal = document.getElementById('handling-' + id);
            modal.classList.toggle('hidden');
        }

        let handlingRowIndex = {};
        function addHandlingRow(fgId) {
            if (!handlingRowIndex[fgId]) {
                handlingRowIndex[fgId] = document.querySelectorAll('#handling-details-' + fgId + ' tr').length;
            }
            const idx = handlingRowIndex[fgId]++;
            const tbody = document.getElementById('handling-details-' + fgId);
            const tr = document.createElement('tr');
            tr.className = 'handling-row';
            tr.innerHTML = `
                <td class="px-3 py-2">
                    <select name="details[${idx}][status]" required
                        class="block w-full rounded border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Pilih Status</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                        <option value="REJECT">REJECT</option>
                        <option value="REPAIR">REPAIR</option>
                        <option value="SCRAP">SCRAP</option>
                        <option value="DOWNGRADE">DOWNGRADE</option>
                    </select>
                </td>
                <td class="px-3 py-2">
                    <input type="number" name="details[${idx}][qty]" min="0" value="0" required
                        class="block w-24 rounded border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </td>
                <td class="px-3 py-2">
                    <input type="number" name="details[${idx}][weight]" min="0" step="0.01" value="0" required
                        class="block w-28 rounded border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </td>
                <td class="px-3 py-2">
                    <button type="button" onclick="this.closest('tr').remove()"
                        class="text-red-600 hover:underline text-xs">Hapus</button>
                </td>
            `;
            tbody.appendChild(tr);
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
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        @endif
    </script>

    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus seluruh record?',
                text: "Semua data WIP dan FG terkait " + name + " akan ikut terhapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#4f46e5',
                confirmButtonText: 'Ya, Hapus Semua!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

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
    </script>
    {{-- hapus fg --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Hapus Data?',
                        text: "Data dihapus tidak bisa dikembalikan.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
