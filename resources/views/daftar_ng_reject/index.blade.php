<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Daftar NG/REJECT') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

            <div class="overflow-hidden border border-gray-200 bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('daftar_ng_reject.index') }}" method="GET"
                    class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-6 lg:items-end">

                    <div class="relative sm:col-span-2 lg:col-span-2">
                        <label for="search" class="mb-1 block text-sm font-medium text-gray-700">Pencarian</label>
                        <span
                            class="pointer-events-none absolute inset-y-0 bottom-0 left-0 flex items-center pb-1 pl-3">
                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="block w-full rounded-md border border-gray-300 bg-white py-2 pl-10 pr-3 leading-5 placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Cari lot number...">
                    </div>

                    <div>
                        <label for="start_date" class="mb-1 block text-sm font-medium text-gray-700">Tanggal
                            Awal</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                            class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 leading-5 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="end_date" class="mb-1 block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                            class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 leading-5 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="status" class="mb-1 block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status"
                            class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 leading-5 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Semua Status</option>
                            <option value="NG" {{ request('status') === 'NG' ? 'selected' : '' }}>NG</option>
                            <option value="REJECT" {{ request('status') === 'REJECT' ? 'selected' : '' }}>REJECT
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="modul" class="mb-1 block text-sm font-medium text-gray-700">Module</label>
                        <select name="modul" id="modul"
                            class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 leading-5 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Semua Module</option>
                            <option value="WM" {{ request('modul') === 'WM' ? 'selected' : '' }}>WM</option>
                            <option value="Fencing" {{ request('modul') === 'Fencing' ? 'selected' : '' }}>Fencing
                            </option>
                            <option value="CTCL" {{ request('modul') === 'CTCL' ? 'selected' : '' }}>CTCL</option>
                            <option value="Chainlink" {{ request('modul') === 'Chainlink' ? 'selected' : '' }}>
                                Chainlink</option>
                            <option value="Kawat Duri" {{ request('modul') === 'Kawat Duri' ? 'selected' : '' }}>Kawat
                                Duri</option>
                            <option value="Razor Packing" {{ request('modul') === 'Razor Packing' ? 'selected' : '' }}>
                                Razor Packing</option>
                            <option value="Gabion Packing"
                                {{ request('modul') === 'Gabion Packing' ? 'selected' : '' }}>Gabion Packing</option>
                        </select>
                    </div>

                    <div class="flex gap-2 sm:col-span-2 lg:col-span-6">
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700">
                            Cari
                        </button>

                        @if (request()->hasAny(['search', 'start_date', 'end_date', 'status', 'modul']))
                            <a href="{{ route('daftar_ng_reject.index') }}"
                                class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="w-16 px-4 py-3 text-left font-semibold text-gray-900">No</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Aksi</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Status</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">No Inspeksi</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Tanggal</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Shift</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">PRO Number</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Nama Mesin</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Description (Nama
                                            Produk)</th>
                                        <th class="px-4 py-3 text-right font-semibold text-gray-900">Qty</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Modul</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Lot Number</th>

                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($data as $item)
                                        <tr class="transition-colors hover:bg-gray-50">
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $loop->iteration + ($data->firstItem() - 1) }}</td>
                                            <td class="px-4 py-3">
                                                <a href="{{ $item['qrcode_url'] }}" target="_blank"
                                                    class="inline-flex items-center gap-1 rounded-md bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 transition hover:bg-indigo-100"
                                                    title="Cetak Label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2z" />
                                                    </svg>
                                                    Cetak Label
                                                </a>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if ($item['status'] === 'NG')
                                                    <span
                                                        class="inline-block rounded bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">NG</span>
                                                @else
                                                    <span
                                                        class="inline-block rounded bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700">REJECT</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $item['nomor_inspeksi'] }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item['tanggal'] }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item['shift'] }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item['pro_number'] }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $item['nama_mesin'] ?? '-' }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $item['description'] ?? '-' }}</td>
                                            <td class="px-4 py-3 text-right font-medium text-gray-900">
                                                {{ $item['qty'] }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item['modul'] }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item['lot_number'] }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="px-4 py-8 text-center italic text-gray-500">
                                                Belum ada data NG/REJECT.
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
