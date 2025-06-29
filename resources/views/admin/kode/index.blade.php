<x-app-layout>
    <div class="ml-20 p-6 bg-gray-100 min-h-screen">
        <div class="container mx-auto p-4">
            <h1 class="text-xl font-semibold mb-4">Kode Akun</h1>

            <!-- Search input -->
            <div class="flex justify-between items-center">
                <input type="text" id="searchInput" placeholder="Cari..." class="mb-4 p-2 w-1/2 border rounded">
                <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'tambah-user')">
                    Tambah Data
                </x-primary-button>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded shadow">
                    <thead>
                        <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                            <th class="p-2 border text-center">No</th>
                            <th class="p-2 border text-center">Kode</th>
                            <th class="p-2 border text-center">Keterangan</th>
                            <th class="p-2 border text-center">Tools</th>
                        </tr>
                    </thead>
                    <tbody id="kodeTable">
                        @foreach($data as $index => $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 border text-center">{{ $index + 1 }}</td>
                            <td class="p-2 border text-center">{{ $item->kode_akun ?? '-' }}</td>
                            <td class="p-2 border">{{ $item->keterangan ?? '-' }}</td>
                            <td class="p-2 border text-center">
                                <!-- Tombol Edit -->
                                <div class="flex gap-2">
                                    <a href="{{ route('Kode.edit', $item->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Tombol Delete -->
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('Kode.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600" onclick="confirmDelete({{ $item->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination (Laravel's) -->
            <div class="mt-4">
                {{ $data->links() }}
            </div>
        </div>
    </div>
    <x-modal name="tambah-user" focusable>
        <form method="POST" action="{{ route('Kode.store') }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-black">Tambah User Baru</h2>

            <div class="mt-4">
                <x-input-label for="kode_akun" value="kode_akun" />
                <x-text-input id="kode_akun" name="kode_akun" type="text" class="mt-1 block w-full" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('kode_akun')" />
            </div>

            <div class="mt-4">
                <x-input-label for="keterangan" value="keterangan" />
                <x-text-input id="keterangan" name="keterangan" type="text" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('keterangan')" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button class="ml-3">Simpan</x-primary-button>
            </div>
        </form>
    </x-modal>


    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#kodeTable tr');
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>