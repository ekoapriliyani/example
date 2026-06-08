<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('QC Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Inspeksi</p>
                        <h3 class="text-3xl font-extrabold text-indigo-600 mt-1">24</h3>
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
                        <h3 class="text-3xl font-extrabold text-amber-500 mt-1">5</h3>
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
                        <h3 class="text-3xl font-extrabold text-emerald-600 mt-1">19</h3>
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <h4 class="text-lg font-bold text-gray-800 mb-2">Selamat Datang di Panel QC Inspection</h4>
                    <p class="text-sm text-gray-600">
                        Gunakan menu navigasi di atas untuk mengelola data material, subkon, proyek, atau memproses
                        ringkasan data operasional inspeksi lapangan.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
