<x-app-layout>
    <div class="ml-20 p-6 bg-gray-100 min-h-screen">
        <div class="container mx-auto p-4">

            <form method="POST" action="{{ route('Pemasukan.update', $pemasukan->id) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <h2 class="text-lg font-medium text-black">Edit Pemasukan</h2>

                <!-- Keterangan Dropdown -->
                <div class="space-y-2">
                    <label for="keteranganSelect" class="block text-sm font-medium text-gray-700">
                        Keterangan
                    </label>
                    <select id="keteranganSelect" name="keterangan_field_display"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Pilih Keterangan --</option>
                        @foreach($data2 as $d)
                        <option value="{{$d->kode_akun}},{{$d->keterangan}}"
                            {{ (isset($pemasukan) && $pemasukan->kode_akun == $d->kode_akun && $pemasukan->keterangan == $d->keterangan) ? 'selected' : '' }}>
                            {{$d->kode_akun}} | {{$d->keterangan}}
                        </option>
                        @endforeach
                    </select>

                    <input type="hidden" id="hidden_kode_akun" name="kode_akun" value="{{ $pemasukan->kode_akun ?? '' }}">
                    <input type="hidden" id="hidden_keterangan" name="keterangan" value="{{ $pemasukan->keterangan ?? '' }}">
                </div>

                <!-- Tanggal Input -->
                <div class="space-y-2">
                    <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input id="tanggal" name="tanggal" type="date" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        value="{{ $pemasukan->tanggal ?? '' }}">
                    @error('tanggal')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Omset Konter Input -->
                <div class="space-y-2">
                    <label for="omset_konter" class="block text-sm font-medium text-gray-700 300">Omset Konter</label>
                    <input id="omset_konter" name="omset_konter" type="text" required
                        class="w-full rounded-md border-gray-300 600 700 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        value="{{ $pemasukan->omset_konter ?? '' }}">
                    @error('omset_konter')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Omset Retail Input -->
                <div class="space-y-2">
                    <label for="omset_retail" class="block text-sm font-medium text-gray-700 300">Omset Retail</label>
                    <input id="omset_retail" name="omset_retail" type="text" required
                        class="w-full rounded-md border-gray-300 600 700 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        value="{{ $pemasukan->omset_retail ?? '' }}">
                    @error('omset_retail')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Investor Input -->
                <div class="space-y-2">
                    <label for="investor" class="block text-sm font-medium text-gray-700 300">Investor</label>
                    <input id="investor" name="investor" type="text" required
                        class="w-full rounded-md border-gray-300 600 700 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        value="{{ $pemasukan->investor ?? '' }}">
                    @error('investor')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Refund Input -->
                <div class="space-y-2">
                    <label for="refund" class="block text-sm font-medium text-gray-700 300">Refund</label>
                    <input id="refund" name="refund" type="text" required
                        class="w-full rounded-md border-gray-300 600 700 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        value="{{ $pemasukan->refund ?? '' }}">
                    @error('refund')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pemindahan Dana Input -->
                <div class="space-y-2">
                    <label for="pemindahan_dana" class="block text-sm font-medium text-gray-700 300">Pemindahan Dana</label>
                    <input id="pemindahan_dana" name="pemindahan_dana" type="text" required
                        class="w-full rounded-md border-gray-300 600 700 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        value="{{ $pemasukan->pemindahan_dana ?? '' }}">
                    @error('pemindahan_dana')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" x-on:click="$dispatch('close')"
                        class="px-4 py-2 border border-gray-300 600 rounded-md shadow-sm text-sm font-medium text-gray-700 300 bg-white 700 hover:bg-gray-50 gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
</x-app-layout>

<script>
    // JavaScript for handling the keterangan select
    document.addEventListener('DOMContentLoaded', function() {
        const keteranganSelect = document.getElementById('keteranganSelect');
        const hiddenKodeAkun = document.getElementById('hidden_kode_akun');
        const hiddenKeterangan = document.getElementById('hidden_keterangan');

        function updateHiddenInputs() {
            const selectedValue = keteranganSelect.value;
            if (selectedValue) {
                const [kodeAkun, keterangan] = selectedValue.split(',');
                hiddenKodeAkun.value = kodeAkun?.trim() || '';
                hiddenKeterangan.value = keterangan?.trim() || '';
            } else {
                hiddenKodeAkun.value = '';
                hiddenKeterangan.value = '';
            }
        }

        keteranganSelect.addEventListener('change', updateHiddenInputs);
        updateHiddenInputs(); // Initialize on load
    });
</script>