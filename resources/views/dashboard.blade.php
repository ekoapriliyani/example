<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('QC Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 p-4">
                <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-4">
                    <label for="module" class="text-sm font-semibold text-gray-600 whitespace-nowrap">Pilih Modul Inspeksi:</label>
                    <select name="module" id="module" onchange="this.form.submit()"
                        class="block w-full max-w-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @foreach ($modules as $mod)
                            <option value="{{ $mod['key'] }}" {{ $module === $mod['key'] ? 'selected' : '' }}>
                                {{ $mod['label'] }}
                            </option>
                        @endforeach
                    </select>
                    <noscript><button type="submit" class="btn btn-sm btn-primary">Go</button></noscript>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Inspeksi</p>
                        <h3 class="text-3xl font-extrabold text-indigo-600 mt-1">{{ $totalInspeksi }}</h3>
                    </div>
                    <div class="p-3 rounded-full bg-indigo-50 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Pending Approval</p>
                        <h3 class="text-3xl font-extrabold text-amber-500 mt-1">{{ $pendingApproval }}</h3>
                    </div>
                    <div class="p-3 rounded-full bg-amber-50 text-amber-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Approved</p>
                        <h3 class="text-3xl font-extrabold text-emerald-600 mt-1">{{ $approved }}</h3>
                    </div>
                    <div class="p-3 rounded-full bg-emerald-50 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-full bg-indigo-50 text-indigo-600">
                            <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Sync PRO Reference</p>
                            <p class="text-xs text-gray-500">
                                @php $lastSync = Cache::get('last_sync_at'); @endphp
                                @if ($lastSync && is_string($lastSync))
                                    Terakhir sync: {{ \Carbon\Carbon::parse($lastSync)->diffForHumans() }}
                                @else
                                    Belum pernah sync
                                @endif
                            </p>
                        </div>
                    </div>
                    <form action="{{ route('sync.pro.reference') }}" method="POST">
                        @csrf
                        <button type="submit"
                            onclick="this.disabled=true; this.innerText='Sync...'; this.form.submit()"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700 transition">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Sync Now
                        </button>
                    </form>
                </div>
            </div>

            @if ($pendingList->isNotEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <h4 class="text-lg font-bold text-gray-800 mb-4">
                            Daftar Inspeksi {{ $modules->firstWhere('key', $module)['label'] }} — Pending Approval
                        </h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">No. Inspeksi</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Inspektor</th>
                                        <th class="px-4 py-3 text-center font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($pendingList as $item)
                                        @php
                                            $child = $item->{$config['wip_relation']}->first();
                                            $inspector = optional(optional($child)->user)->name ?? '-';
                                        @endphp
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3">
                                                <a href="{{ route($config['resource_prefix'] . '.show', $item) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 font-medium">
                                                    {{ $item->nomor_inspeksi }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-3 text-gray-700">
                                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700">
                                                @if ($child && $child->user)
                                                    <span class="inline-flex items-center gap-1">
                                                        <svg class="size-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                        {{ $child->user->name }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400 italic">Belum ada WIP</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                @if (auth()->user()->hasAnyRole(['supervisor', 'manager', 'administrator']))
                                                    <form action="{{ route($config['toggle_route'], $item->id) }}"
                                                        method="POST" class="inline"
                                                        onsubmit="return confirm('Approve {{ $item->nomor_inspeksi }}?')">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-500 text-white text-xs font-semibold rounded-md hover:bg-emerald-600 transition">
                                                            <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Approve
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-xs text-gray-400">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6 text-gray-900 text-center">
                        <p class="text-gray-500">Tidak ada inspeksi {{ $modules->firstWhere('key', $module)['label'] }} yang pending.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
