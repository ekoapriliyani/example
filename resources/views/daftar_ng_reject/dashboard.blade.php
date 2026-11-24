<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Dashboard NG/REJECT') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Klik chart untuk memfilter data. Semua KPI dan chart akan ikut berubah.</p>
            </div>
            <a href="{{ route('daftar_ng_reject.index') }}"
                class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50">
                Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8" x-data="ngRejectDashboard()" x-init="init()">

            {{-- Filters --}}
            <div class="overflow-hidden border border-gray-200 bg-white p-6 shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5 lg:items-end">
                    <div>
                        <label for="start_date" class="mb-1 block text-sm font-medium text-gray-700">Tanggal Awal</label>
                        <input type="date" id="start_date" x-model="filters.start_date" @change="applyFilters()"
                            class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="end_date" class="mb-1 block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                        <input type="date" id="end_date" x-model="filters.end_date" @change="applyFilters()"
                            class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="status" class="mb-1 block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" x-model="filters.status" @change="applyFilters()"
                            class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            <option value="">Semua Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="modul" class="mb-1 block text-sm font-medium text-gray-700">Module</label>
                        <select id="modul" x-model="filters.modul" @change="applyFilters()"
                            class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            <option value="">Semua Module</option>
                            @foreach ($moduls as $modul)
                                <option value="{{ $modul }}">{{ $modul }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" @click="resetFilters()"
                            class="inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50">
                            Reset
                        </button>
                    </div>
                </div>

                {{-- Active filter chips --}}
                <div class="mt-4 flex flex-wrap items-center gap-2" x-show="hasActiveFilters()">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Filter aktif:</span>
                    <template x-if="filters.start_date">
                        <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700">
                            Dari: <span x-text="filters.start_date"></span>
                            <button type="button" @click="filters.start_date=''; applyFilters()" class="text-indigo-500 hover:text-indigo-800">✕</button>
                        </span>
                    </template>
                    <template x-if="filters.end_date">
                        <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700">
                            Sampai: <span x-text="filters.end_date"></span>
                            <button type="button" @click="filters.end_date=''; applyFilters()" class="text-indigo-500 hover:text-indigo-800">✕</button>
                        </span>
                    </template>
                    <template x-if="filters.status">
                        <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700">
                            Status: <span x-text="filters.status"></span>
                            <button type="button" @click="filters.status=''; applyFilters()" class="text-indigo-500 hover:text-indigo-800">✕</button>
                        </span>
                    </template>
                    <template x-if="filters.modul">
                        <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700">
                            Module: <span x-text="filters.modul"></span>
                            <button type="button" @click="filters.modul=''; applyFilters()" class="text-indigo-500 hover:text-indigo-800">✕</button>
                        </span>
                    </template>
                    <template x-if="filters.defect">
                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-700">
                            Defect: <span x-text="filters.defect"></span>
                            <button type="button" @click="filters.defect=''; applyFilters()" class="text-amber-500 hover:text-amber-800">✕</button>
                        </span>
                    </template>
                    <template x-if="filters.produk">
                        <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700">
                            Produk: <span x-text="filters.produk"></span>
                            <button type="button" @click="filters.produk=''; applyFilters()" class="text-indigo-500 hover:text-indigo-800">✕</button>
                        </span>
                    </template>
                    <template x-if="filters.inspector">
                        <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700">
                            Inspektor: <span x-text="filters.inspector"></span>
                            <button type="button" @click="filters.inspector=''; applyFilters()" class="text-indigo-500 hover:text-indigo-800">✕</button>
                        </span>
                    </template>
                </div>
            </div>

            {{-- KPI Cards --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="text-sm font-medium text-gray-500">Total NG</div>
                    <div class="mt-2 text-3xl font-bold text-red-600" x-text="formatNumber(kpi.total_ng)">0</div>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="text-sm font-medium text-gray-500">Total REJECT</div>
                    <div class="mt-2 text-3xl font-bold text-orange-600" x-text="formatNumber(kpi.total_reject)">0</div>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="text-sm font-medium text-gray-500">Total Qty</div>
                    <div class="mt-2 text-3xl font-bold text-gray-800" x-text="formatNumber(kpi.total_qty)">0</div>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="text-sm font-medium text-gray-500">Total Weight</div>
                    <div class="mt-2 text-3xl font-bold text-indigo-600" x-text="formatNumber(kpi.total_weight)">0</div>
                </div>
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                <div class="overflow-hidden rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-gray-800">Tren Tanggal</h3>
                            <p class="text-xs text-gray-500">Klik titik/bar untuk filter ke tanggal tersebut.</p>
                        </div>
                        <div x-show="loading" class="text-xs text-gray-400">Memuat...</div>
                    </div>
                    <div id="trendChart" class="min-h-[320px]"></div>
                </div>

                <div class="overflow-hidden rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-gray-800">Top Defect</h3>
                            <p class="text-xs text-gray-500">Gabungan detail inspeksi 1 &amp; 2. Klik bar untuk filter defect.</p>
                        </div>
                        <div x-show="loading" class="text-xs text-gray-400">Memuat...</div>
                    </div>
                    <div id="defectChart" class="min-h-[320px]"></div>
                </div>
            </div>

            {{-- Top Produk & Top Inspektor --}}
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                <div class="overflow-hidden rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-gray-800">Top Produk (NG vs REJECT)</h3>
                            <p class="text-xs text-gray-500">Produk dengan kejadian terbanyak. Klik bar untuk filter produk.</p>
                        </div>
                        <div x-show="loading" class="text-xs text-gray-400">Memuat...</div>
                    </div>
                    <div id="productChart" class="min-h-[320px]"></div>
                </div>

                <div class="overflow-hidden rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-gray-800">Top Inspektor (NG vs REJECT)</h3>
                            <p class="text-xs text-gray-500">Inspektor yang paling sering menemukan NG/REJECT. Klik bar untuk filter inspektor.</p>
                        </div>
                        <div x-show="loading" class="text-xs text-gray-400">Memuat...</div>
                    </div>
                    <div id="inspectorChart" class="min-h-[320px]"></div>
                </div>
            </div>

            {{-- Rekap Data Visual --}}
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h3 class="text-base font-semibold text-gray-800">Rekap Top Produk</h3>
                        <p class="text-xs text-gray-500">Daftar produk pada chart Top Produk sesuai filter aktif.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="w-12 px-4 py-3 text-left font-semibold text-gray-900">No</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-900">Produk</th>
                                    <th class="px-4 py-3 text-right font-semibold text-red-600">NG</th>
                                    <th class="px-4 py-3 text-right font-semibold text-orange-600">REJECT</th>
                                    <th class="px-4 py-3 text-right font-semibold text-gray-900">Total</th>
                                    <th class="px-4 py-3 text-right font-semibold text-gray-900">%</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <template x-for="(row, index) in topProducts" :key="'produk-' + index + '-' + row.label">
                                    <tr class="transition-colors hover:bg-gray-50">
                                        <td class="px-4 py-3 text-gray-600" x-text="index + 1"></td>
                                        <td class="px-4 py-3 font-medium text-gray-900" x-text="row.label"></td>
                                        <td class="px-4 py-3 text-right font-medium text-red-600" x-text="formatNumber(row.ng)"></td>
                                        <td class="px-4 py-3 text-right font-medium text-orange-600" x-text="formatNumber(row.reject)"></td>
                                        <td class="px-4 py-3 text-right font-semibold text-gray-900" x-text="formatNumber(row.total)"></td>
                                        <td class="px-4 py-3 text-right text-gray-600" x-text="formatPercent(row.total)"></td>
                                    </tr>
                                </template>
                                <tr x-show="topProducts.length === 0">
                                    <td colspan="6" class="px-4 py-8 text-center italic text-gray-500">Tidak ada data.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h3 class="text-base font-semibold text-gray-800">Rekap Top Inspektor</h3>
                        <p class="text-xs text-gray-500">Daftar inspektor pada chart Top Inspektor sesuai filter aktif.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="w-12 px-4 py-3 text-left font-semibold text-gray-900">No</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-900">Inspektor</th>
                                    <th class="px-4 py-3 text-right font-semibold text-red-600">NG</th>
                                    <th class="px-4 py-3 text-right font-semibold text-orange-600">REJECT</th>
                                    <th class="px-4 py-3 text-right font-semibold text-gray-900">Total</th>
                                    <th class="px-4 py-3 text-right font-semibold text-gray-900">%</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <template x-for="(row, index) in topInspectors" :key="'inspector-' + index + '-' + row.label">
                                    <tr class="transition-colors hover:bg-gray-50">
                                        <td class="px-4 py-3 text-gray-600" x-text="index + 1"></td>
                                        <td class="px-4 py-3 font-medium text-gray-900" x-text="row.label"></td>
                                        <td class="px-4 py-3 text-right font-medium text-red-600" x-text="formatNumber(row.ng)"></td>
                                        <td class="px-4 py-3 text-right font-medium text-orange-600" x-text="formatNumber(row.reject)"></td>
                                        <td class="px-4 py-3 text-right font-semibold text-gray-900" x-text="formatNumber(row.total)"></td>
                                        <td class="px-4 py-3 text-right text-gray-600" x-text="formatPercent(row.total)"></td>
                                    </tr>
                                </template>
                                <tr x-show="topInspectors.length === 0">
                                    <td colspan="6" class="px-4 py-8 text-center italic text-gray-500">Tidak ada data.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div x-show="error" class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700" x-text="error"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        function ngRejectDashboard() {
            return {
                endpoint: @json(route('daftar_ng_reject.dashboard_data', [], false)),
                filters: {
                    start_date: '',
                    end_date: '',
                    status: '',
                    modul: '',
                    defect: '',
                    produk: '',
                    inspector: '',
                },
                kpi: { total_ng: 0, total_reject: 0, total_qty: 0, total_weight: 0 },
                topProducts: [],
                topInspectors: [],
                productLabels: [],
                inspectorLabels: [],
                loading: false,
                error: '',
                trendChart: null,
                defectChart: null,
                productChart: null,
                inspectorChart: null,

                init() {
                    this.renderCharts();
                    this.fetchData();
                },

                hasActiveFilters() {
                    return !!(this.filters.start_date || this.filters.end_date || this.filters.status || this.filters.modul || this.filters.defect || this.filters.produk || this.filters.inspector);
                },

                applyFilters() {
                    this.fetchData();
                },

                resetFilters() {
                    this.filters = { start_date: '', end_date: '', status: '', modul: '', defect: '', produk: '', inspector: '' };
                    this.fetchData();
                },

                formatNumber(value) {
                    const num = Number(value || 0);
                    return num.toLocaleString('id-ID');
                },

                formatPercent(value) {
                    const total = Number(this.kpi.total_ng || 0) + Number(this.kpi.total_reject || 0);
                    if (!total) {
                        return '0%';
                    }
                    return ((Number(value || 0) / total) * 100).toFixed(1) + '%';
                },

                truncateLabel(value, max = 28) {
                    const text = String(value ?? '');
                    return text.length > max ? text.slice(0, max - 1) + '…' : text;
                },

                buildQuery() {
                    const params = new URLSearchParams();
                    Object.entries(this.filters).forEach(([key, value]) => {
                        if (value !== '' && value !== null && value !== undefined) {
                            params.append(key, value);
                        }
                    });
                    return params.toString();
                },

                async fetchData() {
                    this.loading = true;
                    this.error = '';
                    try {
                        const qs = this.buildQuery();
                        const url = qs ? `${this.endpoint}?${qs}` : this.endpoint;
                        const response = await fetch(url, {
                            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        if (!response.ok) {
                            throw new Error(`Gagal memuat data (${response.status})`);
                        }
                        const data = await response.json();
                        this.kpi = data.kpi || this.kpi;
                        this.updateCharts(data);
                    } catch (e) {
                        this.error = e.message || 'Terjadi kesalahan saat memuat dashboard.';
                    } finally {
                        this.loading = false;
                    }
                },

                renderCharts() {
                    const trendOptions = {
                        chart: {
                            type: 'line',
                            height: 320,
                            toolbar: { show: true },
                            events: {
                                dataPointSelection: (event, chartContext, config) => {
                                    const label = config.w.config.xaxis.categories[config.dataPointIndex];
                                    if (!label) return;
                                    // Toggle: klik tanggal yang sama = clear filter tanggal
                                    if (this.filters.start_date === label && this.filters.end_date === label) {
                                        this.filters.start_date = '';
                                        this.filters.end_date = '';
                                    } else {
                                        this.filters.start_date = label;
                                        this.filters.end_date = label;
                                    }
                                    this.fetchData();
                                }
                            }
                        },
                        series: [
                            { name: 'NG', data: [] },
                            { name: 'REJECT', data: [] }
                        ],
                        xaxis: { categories: [], labels: { rotate: -45 } },
                        stroke: { curve: 'smooth', width: 3 },
                        markers: { size: 4 },
                        colors: ['#dc2626', '#ea580c'],
                        dataLabels: { enabled: false },
                        legend: { position: 'top' },
                        noData: { text: 'Tidak ada data' },
                        tooltip: { shared: true, intersect: false },
                    };

                    const defectOptions = {
                        chart: {
                            type: 'bar',
                            height: 320,
                            toolbar: { show: false },
                            events: {
                                dataPointSelection: (event, chartContext, config) => {
                                    const label = config.w.config.xaxis.categories[config.dataPointIndex];
                                    if (!label) return;
                                    // Toggle defect filter
                                    this.filters.defect = (this.filters.defect === label) ? '' : label;
                                    this.fetchData();
                                }
                            }
                        },
                        series: [{ name: 'Jumlah', data: [] }],
                        plotOptions: {
                            bar: { horizontal: true, borderRadius: 4, distributed: true }
                        },
                        xaxis: { categories: [] },
                        colors: ['#6366f1', '#8b5cf6', '#ec4899', '#f59e0b', '#10b981', '#3b82f6', '#ef4444', '#14b8a6', '#f97316', '#84cc16'],
                        dataLabels: { enabled: true },
                        legend: { show: false },
                        noData: { text: 'Tidak ada data' },
                        tooltip: { y: { formatter: (val) => `${val} kejadian` } },
                    };

                    const productOptions = {
                        chart: {
                            type: 'bar',
                            height: 320,
                            stacked: true,
                            toolbar: { show: false },
                            events: {
                                dataPointSelection: (event, chartContext, config) => {
                                    const label = this.productLabels[config.dataPointIndex];
                                    if (!label) return;
                                    this.filters.produk = (this.filters.produk === label) ? '' : label;
                                    this.fetchData();
                                }
                            }
                        },
                        series: [
                            { name: 'NG', data: [] },
                            { name: 'REJECT', data: [] }
                        ],
                        plotOptions: {
                            bar: { horizontal: true, borderRadius: 4, barHeight: '60%' }
                        },
                        xaxis: { categories: [] },
                        colors: ['#dc2626', '#ea580c'],
                        dataLabels: { enabled: true },
                        legend: { position: 'top' },
                        noData: { text: 'Tidak ada data' },
                        tooltip: { shared: true, intersect: false },
                    };

                    const inspectorOptions = {
                        chart: {
                            type: 'bar',
                            height: 320,
                            stacked: true,
                            toolbar: { show: false },
                            events: {
                                dataPointSelection: (event, chartContext, config) => {
                                    const label = this.inspectorLabels[config.dataPointIndex];
                                    if (!label) return;
                                    this.filters.inspector = (this.filters.inspector === label) ? '' : label;
                                    this.fetchData();
                                }
                            }
                        },
                        series: [
                            { name: 'NG', data: [] },
                            { name: 'REJECT', data: [] }
                        ],
                        plotOptions: {
                            bar: { horizontal: true, borderRadius: 4, barHeight: '60%' }
                        },
                        xaxis: { categories: [] },
                        colors: ['#dc2626', '#ea580c'],
                        dataLabels: { enabled: true },
                        legend: { position: 'top' },
                        noData: { text: 'Tidak ada data' },
                        tooltip: { shared: true, intersect: false },
                    };

                    this.trendChart = new ApexCharts(document.querySelector('#trendChart'), trendOptions);
                    this.defectChart = new ApexCharts(document.querySelector('#defectChart'), defectOptions);
                    this.productChart = new ApexCharts(document.querySelector('#productChart'), productOptions);
                    this.inspectorChart = new ApexCharts(document.querySelector('#inspectorChart'), inspectorOptions);
                    this.trendChart.render();
                    this.defectChart.render();
                    this.productChart.render();
                    this.inspectorChart.render();
                },

                updateCharts(data) {
                    const trend = data.trend || { labels: [], ng: [], reject: [] };
                    const defects = data.top_defects || { labels: [], values: [] };
                    const products = data.top_products || { labels: [], ng: [], reject: [], rows: [] };
                    const inspectors = data.top_inspectors || { labels: [], ng: [], reject: [], rows: [] };

                    this.trendChart.updateOptions({
                        xaxis: { categories: trend.labels || [] }
                    }, false, true);
                    this.trendChart.updateSeries([
                        { name: 'NG', data: trend.ng || [] },
                        { name: 'REJECT', data: trend.reject || [] }
                    ], true);

                    this.defectChart.updateOptions({
                        xaxis: { categories: defects.labels || [] }
                    }, false, true);
                    this.defectChart.updateSeries([
                        { name: 'Jumlah', data: defects.values || [] }
                    ], true);

                    this.productLabels = products.labels || [];
                    this.inspectorLabels = inspectors.labels || [];

                    this.productChart.updateOptions({
                        xaxis: { categories: this.productLabels.map((label) => this.truncateLabel(label)) }
                    }, false, true);
                    this.productChart.updateSeries([
                        { name: 'NG', data: products.ng || [] },
                        { name: 'REJECT', data: products.reject || [] }
                    ], true);

                    this.inspectorChart.updateOptions({
                        xaxis: { categories: this.inspectorLabels.map((label) => this.truncateLabel(label)) }
                    }, false, true);
                    this.inspectorChart.updateSeries([
                        { name: 'NG', data: inspectors.ng || [] },
                        { name: 'REJECT', data: inspectors.reject || [] }
                    ], true);

                    this.topProducts = products.rows || [];
                    this.topInspectors = inspectors.rows || [];
                }
            }
        }
    </script>
</x-app-layout>
