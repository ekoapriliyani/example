<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Incoming Bahan Baku') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- FILTER RANGE TANGGAL --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 p-6">
                <form action="{{ route('laporan.incoming') }}" method="GET"
                    class="flex flex-col gap-4 sm:flex-row sm:items-end sm:flex-wrap">

                    <div class="w-full sm:w-40">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                            class="block w-full py-2 px-3 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="w-full sm:w-40">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                            class="block w-full py-2 px-3 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit"
                            class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150 w-full sm:w-auto">
                            Cari
                        </button>
                        <a href="{{ route('laporan.incoming.export', request()->except('page')) }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition ease-in-out duration-150 w-full sm:w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Export Excel
                        </a>
                        @if (request('start_date') || request('end_date'))
                            <a href="{{ route('laporan.incoming') }}"
                                class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150 w-full sm:w-auto">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- TABEL LAPORAN --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th rowspan="2"
                                            class="px-4 py-3 font-semibold text-gray-900 text-left align-bottom w-16">No</th>
                                        <th colspan="17"
                                            class="px-4 py-2 font-semibold text-gray-900 text-center border-l border-gray-200">
                                            Incoming Bahan Baku</th>
                                        <th colspan="2"
                                            class="px-4 py-2 font-semibold text-gray-900 text-center border-l border-gray-200">
                                            Ringkasan</th>
                                        <th colspan="11"
                                            class="px-4 py-2 font-semibold text-gray-900 text-center border-l border-gray-200">
                                            Inspeksi (digabung per kolom)</th>
                                        <th colspan="10"
                                            class="px-4 py-2 font-semibold text-gray-900 text-center border-l border-gray-200">
                                            Mechanical Test (digabung per kolom)</th>
                                    </tr>
                                    <tr class="border-t border-gray-200">
                                        {{-- Incoming --}}
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left border-l border-gray-200">Tanggal</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Jenis</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Nomor Inspeksi</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">No RCR</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Description / Nama Barang</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Supplier</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">No PO</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">No SJ</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Jml Koil</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">D Kawat</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Kawat</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Jenis Kawat</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Certificate</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Status Approval</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Approved By</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Approved At</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Created At</th>

                                        {{-- Ringkasan --}}
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-center border-l border-gray-200">Jumlah Inspeksi</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-center">Jumlah Mechanical Test</th>

                                        {{-- Inspeksi --}}
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left border-l border-gray-200">No Koil</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">D1</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">D2</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">D3</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Rata-rata</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Dimensi</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Visual</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Description 1</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Description 2</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Lot Number</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Inspeksi Oleh</th>

                                        {{-- Mechanical Test --}}
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left border-l border-gray-200">Nomor Koil</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Hasil Tensile</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Hasil Coating Weight</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Hasil Lilit</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Hasil Puntir</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Status</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Description 1</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Description 2</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Lot Number</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Mechanical Test Oleh</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($data as $item)
                                        @php
                                            $inspeksi = $item->incomingbahanbakuinspeksi;
                                            $mechanical = $item->mechanicalTests;
                                            $fmt = [\App\Support\LaporanFormatter::class, 'joinValues'];
                                        @endphp
                                        <tr class="hover:bg-gray-50 transition-colors align-top">
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $loop->iteration + ($data->firstItem() - 1) }}
                                            </td>

                                            {{-- Incoming --}}
                                            <td class="px-4 py-3 whitespace-nowrap border-l border-gray-200">{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : '-' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $item->jenis === 'non_reguler' ? 'Non Reguler' : 'Reguler' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $item->nomor_inspeksi }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $item->no_rcr ?? '-' }}</td>
                                            <td class="px-4 py-3">{{ $item->description ?? '-' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $item->supplier->nama ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $item->no_po ?? '-' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $item->no_sj ?? '-' }}</td>
                                            <td class="px-4 py-3 text-right">{{ $item->jml_koil ?? '-' }}</td>
                                            <td class="px-4 py-3 text-right">{{ $item->d_kawat ?? '-' }}</td>
                                            <td class="px-4 py-3 text-right">{{ $item->tol ?? '-' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $item->jenis_kawat ?? '-' }}</td>
                                            <td class="px-4 py-3">{{ $item->certificate ?? '-' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if ($item->isApproved())
                                                    <span class="inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700">Approved</span>
                                                @else
                                                    <span class="inline-flex rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">Pending</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $item->approver->name ?? '-' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $item->approved_at ? \Carbon\Carbon::parse($item->approved_at)->format('d/m/Y H:i') : '-' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}</td>

                                            {{-- Ringkasan --}}
                                            <td class="px-4 py-3 text-center border-l border-gray-200">{{ $inspeksi->count() }}</td>
                                            <td class="px-4 py-3 text-center">{{ $mechanical->count() }}</td>

                                            {{-- Inspeksi (digabung per kolom) --}}
                                            <td class="px-4 py-3 border-l border-gray-200">{{ $fmt($inspeksi, 'no_koil') ?: '-' }}</td>
                                            <td class="px-4 py-3">{{ $fmt($inspeksi, 'd1') ?: '-' }}</td>
                                            <td class="px-4 py-3">{{ $fmt($inspeksi, 'd2') ?: '-' }}</td>
                                            <td class="px-4 py-3">{{ $fmt($inspeksi, 'd3') ?: '-' }}</td>
                                            <td class="px-4 py-3">{{ $fmt($inspeksi, 'rata_rata') ?: '-' }}</td>
                                            <td class="px-4 py-3">{{ $fmt($inspeksi, 'dimensi') ?: '-' }}</td>
                                            <td class="px-4 py-3">{{ $fmt($inspeksi, 'visual') ?: '-' }}</td>
                                            <td class="px-4 py-3">{{ $fmt($inspeksi, 'description1') ?: '-' }}</td>
                                            <td class="px-4 py-3">{{ $fmt($inspeksi, 'description2') ?: '-' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $fmt($inspeksi, 'lot_number') ?: '-' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $fmt($inspeksi->pluck('user')->filter(), 'name') ?: '-' }}</td>

                                            {{-- Mechanical Test (digabung per kolom) --}}
                                            <td class="px-4 py-3 border-l border-gray-200">{{ $fmt($mechanical, 'nomor_koil') ?: '-' }}</td>
                                            <td class="px-4 py-3">{{ $fmt($mechanical, 'hasil_tensile') ?: '-' }}</td>
                                            <td class="px-4 py-3">{{ $fmt($mechanical, 'hasil_coatingweight') ?: '-' }}</td>
                                            <td class="px-4 py-3">{{ $fmt($mechanical, 'hasil_lilit') ?: '-' }}</td>
                                            <td class="px-4 py-3">{{ $fmt($mechanical, 'hasil_puntir') ?: '-' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $fmt($mechanical, 'status') ?: '-' }}</td>
                                            <td class="px-4 py-3">{{ $fmt($mechanical, 'description1') ?: '-' }}</td>
                                            <td class="px-4 py-3">{{ $fmt($mechanical, 'description2') ?: '-' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $fmt($mechanical, 'lot_number') ?: '-' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $fmt($mechanical->pluck('user')->filter(), 'name') ?: '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="41" class="px-4 py-8 text-center text-gray-500">
                                                Tidak ada data untuk filter tanggal yang dipilih.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
