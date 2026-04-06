<x-layout>

    <form action="{{ route('mesin.store') }}" method="POST"
        class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8 space-y-6">
        @csrf
        <!-- Header -->
        <h2 class="text-2xl font-bold text-gray-800 border-b pb-2">Tambah Data Mesin</h2>

        <!-- Item ID -->
        <div>
            <label for="id_mesin" class="block text-sm font-semibold text-gray-700">ID Mesin</label>
            <input type="text" name="id_mesin" id="id_meisin"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('id_mesin')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <!-- Nama Mesin -->
        <div>
            <label for="nama_mesin" class="block text-sm font-semibold text-gray-700">Nama Mesin</label>
            <input type="text" name="nama_mesin" id="nama_mesin"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('nama_mesin')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>



        <!-- Tombol -->
        <div>
            <button type="submit"
                class="w-full bg-teal-500 text-white font-semibold py-2 px-4 rounded-md shadow hover:bg-teal-400 focus:ring-2 focus:ring-teal-500">
                Simpan Data
            </button>
        </div>

        @if ($errors->any())
            <div class="my-5">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-red-500 text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </form>



    <x-slot:footer>
        <strong>Create Mesin Page</strong>
    </x-slot:footer>
</x-layout>
