<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('QC') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <div class="mt-4">
                        <form id="syncForm" action="{{ route('sync.pro.reference') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Sync Pro Reference
                            </button>
                        </form>
                    <div id="syncModal" class="sync-modal" style="display: none;">
                        <div class="sync-box">
                            <div id="syncLoading">
                                <div class="spinner"></div>
                                <h5>Sync sedang berjalan...</h5>
                                <p>Mohon tunggu sebentar</p>
                            </div>

                            <div id="syncSuccess" style="display: none;">
                                <div class="checkmark">✓</div>
                                <h5>Sync berhasil!</h5>

                                @if (session('sync_success'))
                                    <pre>{{ session('sync_success') }}</pre>
                                @endif
                            </div>
                        </div>
                    </div>
                    <style>
                    .sync-modal {
                        position: fixed;
                        inset: 0;
                        background: rgba(0,0,0,0.45);
                        z-index: 9999;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .sync-box {
                        background: white;
                        width: 360px;
                        padding: 30px;
                        border-radius: 14px;
                        text-align: center;
                        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                    }

                    .spinner {
                        width: 48px;
                        height: 48px;
                        border: 5px solid #ddd;
                        border-top-color: #4f46e5;
                        border-radius: 50%;
                        margin: 0 auto 18px;
                        animation: spin 1s linear infinite;
                    }

                    .checkmark {
                        width: 64px;
                        height: 64px;
                        line-height: 64px;
                        border-radius: 50%;
                        background: #22c55e;
                        color: white;
                        font-size: 42px;
                        font-weight: bold;
                        margin: 0 auto 18px;
                    }

                    .sync-box pre {
                        background: #f3f4f6;
                        padding: 10px;
                        border-radius: 8px;
                        font-size: 13px;
                        text-align: left;
                        white-space: pre-wrap;
                    }

                    @keyframes spin {
                        to {
                            transform: rotate(360deg);
                        }
                    }
                    </style>
            </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('syncForm').addEventListener('submit', function () {
            document.getElementById('syncModal').style.display = 'flex';
        });
        </script>

        @if (session('sync_success'))
        <script>
        window.addEventListener('load', function () {
            const modal = document.getElementById('syncModal');
            const loading = document.getElementById('syncLoading');
            const success = document.getElementById('syncSuccess');

            modal.style.display = 'flex';
            loading.style.display = 'none';
            success.style.display = 'block';

            setTimeout(function () {
                modal.style.display = 'none';
            }, 3000);
        });
    </script>
@endif
</x-app-layout>
