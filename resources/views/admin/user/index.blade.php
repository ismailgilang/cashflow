<x-app-layout>
    <div class="ml-20 p-6 bg-gray-100 min-h-screen">
        <div class="container mx-auto p-4">
            <h1 class="text-xl font-semibold mb-4">Users</h1>

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
                            <th class="p-2 border text-center">Name</th>
                            <th class="p-2 border text-center">Email</th>
                            <th class="p-2 border text-center">Role</th>
                            <th class="p-2 border text-center">Tools</th>
                        </tr>
                    </thead>
                    <tbody id="kodeTable">
                        @foreach($data as $index => $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 border text-center">{{ $index + 1 }}</td>
                            <td class="p-2 border text-center">{{ $item->name ?? '-' }}</td>
                            <td class="p-2 border">{{ $item->email ?? '-' }}</td>
                            <td class="p-2 border">{{ $item->role ?? '-' }}</td>
                            <td class="p-2 border text-center">
                                <!-- Tombol Edit -->
                                <div class="flex gap-2">
                                    <a href="{{ route('Users.edit', $item->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Tombol Delete -->
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('Users.destroy', $item->id) }}" method="POST" class="inline">
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
        </div>
    </div>
    <x-modal name="tambah-user" focusable>
        <form method="POST" action="{{ route('Users.store') }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-black">Tambah User Baru</h2>

            <div class="mt-4">
                <x-input-label for="name" value="name" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="mt-4">
                <x-input-label for="email" value="email" />
                <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" value="password" />
                <x-text-input id="password" name="password" type="text" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('password')" />
            </div>

            <div class="mt-4">
                <label for="role" class="block text-gray-700 text-sm font-bold mb-2">
                    Role
                </label>
                <select id="role" name="role" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">
                        Admin
                    </option>
                    <option value="super">
                        Super Admin
                    </option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('role')" />
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