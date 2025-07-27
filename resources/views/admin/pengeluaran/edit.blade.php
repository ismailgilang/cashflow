<x-app-layout>
    <div class="ml-20 p-6 bg-gray-100 min-h-screen">
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Pengeluaran</h1>

        <div class="container mx-auto p-4">
            <form method="POST" action="{{ route('Pengeluaran.update', $pengeluaran->id) }}" class="p-6">
                @csrf
                @method('PUT')
                <h2 class="text-lg font-medium text-black">Edit Pengeluaran</h2>

                <div class="mt-4">
                    <label for="keteranganSelect" class="block text-gray-700 text-sm font-bold mb-2">
                        Keterangan
                    </label>
                    <select id="keteranganSelect" name="keterangan_field_display" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">-- Pilih Keterangan --</option>
                        @foreach($data2 as $d)
                        @php
                        $optionValue = $d->kode_akun . ',' . $d->keterangan;
                        $isSelected = ($pengeluaran->kode_akun == $d->kode_akun && $pengeluaran->keterangan == $d->keterangan);
                        @endphp
                        <option value="{{ $optionValue }}" {{ $isSelected ? 'selected' : '' }}>
                            {{ $d->kode_akun }} | {{ $d->keterangan }}
                        </option>
                        @endforeach
                    </select>

                    <input type="hidden" id="hidden_kode_akun" name="kode_akun" value="{{ $pengeluaran->kode_akun }}">
                    <input type="hidden" id="hidden_keterangan" name="keterangan" value="{{ $pengeluaran->keterangan }}">
                </div>

                @php
                $fields = [
                'tanggal' => 'date',
                'gaji' => 'text',
                'biaya_kirim' => 'text',
                'transportasi' => 'text',
                'lpti' => 'text',
                'atk' => 'text',
                'bahan' => 'text',
                'peralatan' => 'text',
                'lain_lain' => 'text',
                'invest' => 'text',
                'vendor' => 'text',
                'profit' => 'text',
                'cicilan' => 'text',
                'pajak' => 'text',
                'pemindahan' => 'text',
                ];
                @endphp

                @foreach ($fields as $field => $type)
                <div class="mt-4">
                    <x-input-label for="{{ $field }}" value="{{ $field }}" />
                    <x-text-input id="{{ $field }}" name="{{ $field }}" type="{{ $type }}" class="mt-1 block w-full" value="{{ old($field, $pengeluaran->$field) }}" />
                    <x-input-error class="mt-2" :messages="$errors->get($field)" />
                </div>
                @endforeach

                <div class="mt-6 flex justify-end">
                    <a href="{{route('Pengeluaran.index')}}"><x-secondary-button>Batal</x-secondary-button></a>
                    <x-primary-button class="ml-3">Update</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('keteranganSelect').addEventListener('change', function() {
        const [kode_akun, keterangan] = this.value.split(',');
        document.getElementById('hidden_kode_akun').value = kode_akun || '';
        document.getElementById('hidden_keterangan').value = keterangan || '';
    });
</script>