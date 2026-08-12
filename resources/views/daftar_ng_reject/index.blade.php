<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar NG/REJECT') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 p-6">
                <form action="{{ route('daftar_ng_reject.index') }}" method="GET"
                    class="flex flex-col gap-4 sm:flex-row sm:items-end sm:flex-wrap">

                    <div class="relative flex-1 min-w-[250px]">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <span class="absolute inset-y-0 bottom-0 left-0 flex items-center pl-3 pointer-events-none pb-1">
                            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Cari lot number...">
                    </div>

                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit"
                            class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150 w-full sm:w-auto">
                            Cari
                        </button>

                        @if (request('search'))
                            <a href="{{ route('daftar_ng_reject.index') }}"
                                class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150 w-full sm:w-auto">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left w-16">No</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Lot Number</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">No Inspeksi</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tanggal</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Shift</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">PRO Number</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-right">Qty</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Status</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Modul</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($data as $item)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $loop->iteration + ($data->firstItem() - 1) }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item['lot_number'] }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item['nomor_inspeksi'] }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item['tanggal'] }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item['shift'] }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item['pro_number'] }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900 text-right">{{ $item['qty'] }}</td>
                                            <td class="px-4 py-3">
                                                @if ($item['status'] === 'NG')
                                                    <span
                                                        class="inline-block rounded bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">NG</span>
                                                @else
                                                    <span
                                                        class="inline-block rounded bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700">REJECT</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item['modul'] }}</td>
                                            <td class="px-4 py-3">
                                                <a href="{{ $item['qrcode_url'] }}" target="_blank"
                                                    class="inline-flex items-center gap-1 rounded-md bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 transition"
                                                    title="Cetak Label">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2z" />
                                                    </svg>
                                                    Cetak Label
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="px-4 py-8 text-center text-gray-500 italic">
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
