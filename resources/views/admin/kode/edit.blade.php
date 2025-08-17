<x-app-layout>
    <div class="ml-20 p-6 bg-gray-100 min-h-screen">
        <div class="container mx-auto p-4">
            <h1 class="text-xl font-semibold mb-4">Kode Akun</h1>
            <form action="{{ route('Kode.update', $kode->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mt-4">
                    <x-input-label for="kode_akun" value="Kode Akun" />
                    <x-text-input 
                        id="kode_akun" 
                        name="kode_akun" 
                        value="{{ old('kode_akun', $kode->kode_akun) }}"
                        type="text" 
                        class="mt-1 block w-full" 
                        maxlength="4" 
                        pattern="\d{4}" 
                        inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,4)"
                        required 
                        autofocus 
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('kode_akun')" />
                </div>

                <!-- Keterangan -->
                <div class="mb-4">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('keterangan', $kode->keterangan) }}</textarea>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('Kode.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>