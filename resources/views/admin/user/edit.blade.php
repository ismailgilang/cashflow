<x-app-layout>
    <div class="ml-20 p-6 bg-gray-100 min-h-screen">
        <div class="container mx-auto p-4">
            <h1 class="text-xl font-semibold mb-4">Kode Akun</h1>
            <form method="POST" action="{{ route('Users.update', $user->id) }}" class="p-6">
                @csrf
                @method('PUT')
                <h2 class="text-lg font-medium text-black">Edit User</h2>

                <div class="mt-4">
                    <x-input-label for="name" value="Name" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                        value="{{ old('name', $user->name) }}" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" name="email" type="text" class="mt-1 block w-full"
                        value="{{ old('email', $user->email) }}" required />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" value="Password (Biarkan kosong jika tidak diubah)" />
                    <x-text-input id="password" name="password" type="text" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                </div>

                <div class="mt-4">
                    <label for="role" class="block text-gray-700 text-sm font-bold mb-2">
                        Role
                    </label>
                    <select id="role" name="role"
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                        required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>
                        <option value="super" {{ old('role', $user->role) == 'super' ? 'selected' : '' }}>
                            Super Admin
                        </option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('role')" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                    <x-primary-button class="ml-3">Update</x-primary-button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>