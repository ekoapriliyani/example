<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Shipment BI') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="mb-4">
                <form action="{{ route('shipment_bi.index') }}" method="GET" class="flex gap-2">
                    <div class="relative flex-1 max-w-md">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ $search }}"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Cari berdasarkan No, Customer, atau Deskripsi...">
                    </div>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 transition ease-in-out duration-150">
                        Cari
                    </button>
                    @if ($search)
                        <a href="{{ route('shipment_bi.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap text-left">
                                            No</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap text-left">
                                            Shipment ID</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap text-left">
                                            Sales Order</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap text-left">
                                            Customer</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap text-left">
                                            Item ID</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap text-left">
                                            Description</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap text-left">
                                            QTY</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap text-left">
                                            Nopol</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($data as $row)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                                {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $row['trno'] ?? '-' }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $row['SoNO'] ?? '-' }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $row['custname'] ?? '-' }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $row['itemid'] ?? '-' }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $row['description'] ?? '-' }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $row['qt'] ?? '-' }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $row['Nopol'] ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-8 text-center text-gray-500 italic">Belum
                                                ada data Shipment BI.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="flex items-center justify-between mt-4 px-4 py-3 border-t border-gray-100">
                                <div>
                                    {{ $data->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
