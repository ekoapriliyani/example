<x-layout>
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Tambah Siswa Baru</h1>
            <p class="mt-1 text-sm text-gray-500">
                Silakan isi formulir di bawah ini untuk mendaftarkan siswa baru ke dalam sistem.
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
            <form action="{{ route('siswa.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="nama" class="block text-xs font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama"
                        class="mt-1 w-full rounded-md border-gray-200 shadow-sm sm:text-sm focus:border-teal-500 focus:ring-teal-500"
                        value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso">
                    @error('nama')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="tanggal_lahir" class="block text-xs font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                            class="mt-1 w-full rounded-md border-gray-200 shadow-sm sm:text-sm focus:border-teal-500 focus:ring-teal-500"
                            value="{{ old('tanggal_lahir') }}">
                        @error('tanggal_lahir')
                            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nilai" class="block text-xs font-medium text-gray-700">Nilai Akhir
                            (0-100)</label>
                        <input type="number" name="nilai" id="nilai" min="0" max="100"
                            class="mt-1 w-full rounded-md border-gray-200 shadow-sm sm:text-sm focus:border-teal-500 focus:ring-teal-500"
                            value="{{ old('nilai') }}" placeholder="0">
                        @error('nilai')
                            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="jurusan" class="block text-xs font-medium text-gray-700">Jurusan</label>
                    <select name="jurusan" id="jurusan"
                        class="mt-1 w-full rounded-md border-gray-200 shadow-sm sm:text-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="">-- Pilih Jurusan --</option>
                        <option value="Informatika" {{ old('jurusan') == 'Informatika' ? 'selected' : '' }}>Informatika
                        </option>
                        <option value="Sistem Informasi" {{ old('jurusan') == 'Sistem Informasi' ? 'selected' : '' }}>
                            Sistem Informasi</option>
                        <option value="Manajemen" {{ old('jurusan') == 'Manajemen' ? 'selected' : '' }}>Manajemen
                        </option>
                        <option value="Akuntansi" {{ old('jurusan') == 'Akuntansi' ? 'selected' : '' }}>Akuntansi
                        </option>
                    </select>
                    @error('jurusan')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="mentor_id" class="block text-xs font-medium text-gray-700">Mentor Pembimbing</label>
                    <select name="mentor_id" id="mentor_id"
                        class="mt-1 w-full rounded-md border-gray-200 shadow-sm sm:text-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="">-- Pilih Mentor --</option>
                        @foreach ($mentors as $mentor)
                            <option value="{{ $mentor->id }}"
                                {{ old('mentor_id') == $mentor->id ? 'selected' : '' }}>
                                {{ $mentor->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('mentor_id')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('siswa.index') }}"
                        class="inline-block rounded-md px-5 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </a>

                    <button type="submit"
                        class="inline-block rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-teal-700 shadow-sm">
                        Simpan Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-slot:footer>
        <strong>Create Siswa Page</strong>
    </x-slot:footer>
</x-layout>
