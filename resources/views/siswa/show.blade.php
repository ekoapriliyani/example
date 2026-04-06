<x-layout>
    <div class="flow-root">
        <dl class="-my-3 divide-y divide-gray-200 text-sm">
            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                <dt class="font-medium text-gray-900">Nama</dt>
                <dd class="text-gray-700 sm:col-span-2">{{ $siswa->nama }}</dd>
            </div>

            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                <dt class="font-medium text-gray-900">Tanggal Lahir</dt>
                <dd class="text-gray-700 sm:col-span-2">{{ $siswa->tanggal_lahir }}</dd>
            </div>

            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                <dt class="font-medium text-gray-900">Jurusan</dt>
                <dd class="text-gray-700 sm:col-span-2">{{ $siswa->jurusan }}</dd>
            </div>

            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                <dt class="font-medium text-gray-900">Nilai</dt>
                <dd class="text-gray-700 sm:col-span-2">
                    {{ $siswa->nilai }}
                </dd>
            </div>

            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                <dt class="font-medium text-gray-900">Nama Mentor</dt>
                <dd class="text-gray-700 sm:col-span-2">
                    {{ $siswa->mentor->nama }}
                </dd>
            </div>
        </dl>
    </div>
    <div class="flex items-center gap-2 my-8">
        <a href="{{ route('siswa.edit', $siswa->id) }}"
            class="text-white text-sm bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">
            Edit
        </a>

        <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="text-white text-sm bg-red-500 px-4 py-2 rounded cursor-pointer hover:bg-red-600">
                Delete
            </button>
        </form>
    </div>
    <x-slot:footer>
        <strong>Siswa Detail Page</strong>
    </x-slot:footer>
</x-layout>
