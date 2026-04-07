<x-layout>
    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Dashboard Operasional</h1>
            <p class="mt-1 text-sm text-gray-500 font-medium">Selamat datang kembali! Berikut adalah ringkasan aset
                produksi Anda hari ini.</p>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-2">

            <article
                class="flex items-center gap-4 rounded-xl border border-gray-100 bg-white p-6 shadow-sm hover:shadow-md transition">
                <span class="rounded-full bg-indigo-100 p-3 text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </span>

                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Mesin</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalMesin ?? 0 }} Unit</p>
                    <a href="{{ route('mesin.index') }}"
                        class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                        Lihat Detail
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </article>

            <article
                class="flex items-center gap-4 rounded-xl border border-gray-100 bg-white p-6 shadow-sm hover:shadow-md transition">
                <span class="rounded-full bg-teal-100 p-3 text-teal-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </span>

                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Material</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalMaterial ?? 0 }} Item</p>
                    <a href="{{ route('material.index') }}"
                        class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-teal-600 hover:text-teal-800 transition">
                        Manajemen Stok
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </article>

        </div>

        <div class="mt-10">
            <h2 class="text-lg font-bold text-gray-900 mb-4 italic">Aksi Cepat</h2>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('mesin.create') }}"
                    class="inline-block rounded bg-indigo-600 px-6 py-3 text-sm font-medium text-white transition hover:scale-105 hover:bg-indigo-700 focus:outline-none focus:ring active:bg-indigo-500">
                    Tambah Mesin Baru
                </a>
                <a href="{{ route('material.create') }}"
                    class="inline-block rounded border border-teal-600 px-6 py-3 text-sm font-medium text-teal-600 transition hover:scale-105 hover:bg-teal-600 hover:text-white focus:outline-none focus:ring active:bg-teal-500">
                    Input Material Baru
                </a>
            </div>
        </div>
    </div>

    <x-slot:footer>
        <strong>Dashboard Operasional v1.0</strong>
    </x-slot:footer>
</x-layout>
