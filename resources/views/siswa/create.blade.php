<x-layout>

    <form action="{{ route('siswa.store') }}" method="POST"
        class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8 space-y-6">
        @csrf
        <!-- Header -->
        <h2 class="text-2xl font-bold text-gray-800 border-b pb-2">Formulir Data Siswa</h2>

        <!-- Nama -->
        <div>
            <label for="nama" class="block text-sm font-semibold text-gray-700">Nama</label>
            <input type="text" name="nama" id="nama"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                value="{{ old('nama') }}">
            @error('nama')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tanggal Lahir -->
        <div>
            <label for="tanggal_lahir" class="block text-sm font-semibold text-gray-700">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                value="{{ old('tanggal_lahir') }}">
            @error('tanggal_lahir')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Jurusan -->
        <div>
            <label for="jurusan" class="block text-sm font-semibold text-gray-700">Jurusan</label>
            <select name="jurusan" id="jurusan"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-- Pilih Jurusan --</option>
                <option value="Informatika" {{ old('jurusan') == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                <option value="Sistem Informasi"{{ old('jurusan') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem
                    Informasi</option>
                <option value="Manajemen" {{ old('jurusan') == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                <option value="Akuntansi" {{ old('jurusan') == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
            </select>
            @error('jurusan')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Nilai -->
        <div>
            <label for="nilai" class="block text-sm font-semibold text-gray-700">Nilai</label>
            <input type="number" name="nilai" id="nilai" min="0" max="100"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                value="{{ old('nilai') }}">
            @error('nilai')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <!-- Mentor -->
        <div>
            <label for="mentor_id" class="block text-sm font-semibold text-gray-700">Mentor</label>
            <select name="mentor_id" id="mentor_id"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-- Pilih Mentor --</option>
                @foreach ($mentors as $mentor)
                    <option value="{{ $mentor->id }}" {{ old('mentor_id') == $mentor->id ? 'selected' : '' }}>
                        {{ $mentor->nama }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tombol -->
        <div>
            <button type="submit"
                class="w-full bg-teal-500 text-white font-semibold py-2 px-4 rounded-md shadow hover:bg-teal-400 focus:ring-2 focus:ring-teal-500">
                Simpan Data
            </button>
        </div>
    </form>



    <x-slot:footer>
        <strong>Create Siswa Page</strong>
    </x-slot:footer>
</x-layout>
