<x-layout>
    <form action="{{ route('siswa.update', $siswa->id) }}" method="POST"
        class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8 space-y-6">
        @csrf
        @method('PUT') <h2 class="text-2xl font-bold text-gray-800 border-b pb-2">Edit Data Siswa</h2>

        <div>
            <label for="nama" class="block text-sm font-semibold text-gray-700">Nama</label>
            <input type="text" name="nama" id="nama"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                value="{{ old('nama', $siswa->nama) }}">
            @error('nama')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="tanggal_lahir" class="block text-sm font-semibold text-gray-700">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
            @error('tanggal_lahir')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="jurusan" class="block text-sm font-semibold text-gray-700">Jurusan</label>
            <select name="jurusan" id="jurusan"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-- Pilih Jurusan --</option>
                @php
                    $jurusans = ['Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi'];
                @endphp
                @foreach ($jurusans as $j)
                    <option value="{{ $j }}" {{ old('jurusan', $siswa->jurusan) == $j ? 'selected' : '' }}>
                        {{ $j }}
                    </option>
                @endforeach
            </select>
            @error('jurusan')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="nilai" class="block text-sm font-semibold text-gray-700">Nilai</label>
            <input type="number" name="nilai" id="nilai" min="0" max="100"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                value="{{ old('nilai', $siswa->nilai) }}">
            @error('nilai')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="mentor_id" class="block text-sm font-semibold text-gray-700">Mentor</label>
            <select name="mentor_id" id="mentor_id"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-- Pilih Mentor --</option>
                @foreach ($mentors as $mentor)
                    <option value="{{ $mentor->id }}"
                        {{ old('mentor_id', $siswa->mentor_id) == $mentor->id ? 'selected' : '' }}>
                        {{ $mentor->nama }}
                    </option>
                @endforeach
            </select>
            @error('mentor_id')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit"
                class="flex-1 bg-indigo-600 text-white font-semibold py-2 px-4 rounded-md shadow hover:bg-indigo-500 focus:ring-2 focus:ring-indigo-500">
                Update Data
            </button>
            <a href="{{ route('siswa.index') }}"
                class="flex-1 bg-gray-200 text-center text-gray-700 font-semibold py-2 px-4 rounded-md shadow hover:bg-gray-300">
                Batal
            </a>
        </div>
    </form>

    <x-slot:footer>
        <strong>Edit Siswa Page</strong>
    </x-slot:footer>
</x-layout>
