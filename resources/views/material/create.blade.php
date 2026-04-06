<x-layout>

    <form action="{{ route('material.store') }}" method="POST"
        class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8 space-y-6">
        @csrf
        <!-- Header -->
        <h2 class="text-2xl font-bold text-gray-800 border-b pb-2">Tambah Data Material</h2>

        <!-- Item ID -->
        <div>
            <label for="nama" class="block text-sm font-semibold text-gray-700">Item ID</label>
            <input type="text" name="item_id" id="item_id"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('item_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700">Description</label>
            <input type="text" name="description" id="description"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('description')
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
        <strong>Create Material Page</strong>
    </x-slot:footer>
</x-layout>
