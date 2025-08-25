<style>
    .custom-select-container {
        position: relative;
        width: 100%;
    }
    .custom-select-display {
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 8px;
        background: #fff;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .custom-select-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #ccc;
        border-top: none;
        max-height: 200px;
        overflow-y: auto;
        display: none;
        z-index: 999;
    }
    .custom-select-dropdown.show {
        display: block;
    }
    .custom-select-search {
        width: 100%;
        box-sizing: border-box;
        padding: 8px;
        border-bottom: 1px solid #ccc;
    }
    .custom-select-option {
        padding: 8px;
        cursor: pointer;
    }
    .custom-select-option:hover {
        background: #f0f0f0;
    }
</style>
<x-app-layout>
    <div class="ml-20 p-6 bg-gray-100 min-h-screen">
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Pemasukan</h1>
        
        <div class="container mx-auto p-4">
            <h1 class="text-xl font-semibold mb-4">Data Pemasukan</h1>

            <!-- Search input -->
            <div class="flex justify-between items-center">
                <div class="flex w-full gap-2">
                    <input type="text" id="searchInput" placeholder="Cari..." class="mb-4 p-2 w-1/2 border rounded">
                    <form method="GET" action="{{ route('Pemasukan.index') }}" class="flex items-center gap-2 mb-4">
                        <input 
                            type="month" 
                            name="periode" 
                            value="{{ request('periode', now()->format('Y-m')) }}" 
                            class="border rounded px-3 py-3 text-sm" 
                            onchange="this.form.submit()">

                        <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded text-sm hover:bg-blue-600">
                            Filter
                        </button>
                    </form>
                </div>
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
                            <th class="p-2 border text-center">Kode Akun</th>
                            <th class="p-2 border text-center">Keterangan</th>
                            <th class="p-2 border text-center">Tanggal</th>
                            <th class="p-2 border text-center">Omset Konter</th>
                            <th class="p-2 border text-center">Omset Retail</th>
                            <th class="p-2 border text-center">Investor</th>
                            <th class="p-2 border text-center">Refund</th>
                            <th class="p-2 border text-center">Pemindahan Dana</th>
                            <th class="p-2 border text-center">Status</th>
                            <th class="p-2 border text-center">Tools</th>
                        </tr>
                    </thead>
                    <tbody id="kodeTable">
                        @foreach($data as $index => $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 border text-center">{{ $index + 1 }}</td>
                            <td class="p-2 border text-center">{{ $item->kode_akun }}</td>
                            <td class="p-2 border text-center">{{ $item->keterangan }}</td>
                            <td class="p-2 border">{{ $item->tanggal }}</td>
                            <td class="p-2 border">{{ $item->omset_konter !== null ? 'Rp.' . number_format($item->omset_konter, 0, ',', '.') : '' }}</td>
                            <td class="p-2 border">{{ $item->omset_retail !== null ? 'Rp.' . number_format($item->omset_retail, 0, ',', '.') : '' }}</td>
                            <td class="p-2 border">{{ $item->investor !== null ? 'Rp.' . number_format($item->investor, 0, ',', '.') : '' }}</td>
                            <td class="p-2 border">{{ $item->refund !== null ? 'Rp.' . number_format($item->refund, 0, ',', '.') : '' }}</td>
                            <td class="p-2 border">{{ $item->pemindahan_dana !== null ? 'Rp.' . number_format($item->pemindahan_dana, 0, ',', '.') : '' }}</td>
                            <td class="p-2 border text-center">
                                @if($item->status === 'disetujui')
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Disetujui</span>
                                @elseif($item->status === 'ditolak')
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Ditolak</span>
                                @elseif($item->status === 'pending')
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">Pending</span>
                                @else
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>
                            <td class="p-2 border text-center">
                                <div class="flex gap-2 justify-center">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('Pemasukan.edit', $item->id) }}" 
                                    class="bg-blue-500 text-white w-8 h-8 rounded flex items-center justify-center hover:bg-blue-600 transition">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Tombol Delete -->
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('Pemasukan.destroy', $item->id) }}" method="POST" 
                                        class="flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="bg-red-500 text-white w-8 h-8 rounded flex items-center justify-center hover:bg-red-600 transition" onclick="confirmDelete({{ $item->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="font-bold bg-purple-500/30">
                            <td colspan="4" class="text-left p-2 border">Total</td>
                            <td class="p-2 border">{{ $data->sum('omset_konter') >0 ? 'Rp.' . number_format($data->sum('omset_konter'), 0, ',', '.') : '' }}</td>
                            <td class="p-2 border">{{ $data->sum('omset_retail') >0 ? 'Rp.' . number_format($data->sum('omset_retail'), 0, ',', '.') : '' }}</td>
                            <td class="p-2 border">{{ $data->sum('investor') >0 ? 'Rp.' . number_format($data->sum('investor'), 0, ',', '.') : '' }}</td>
                            <td class="p-2 border">{{ $data->sum('refund') >0 ? 'Rp.' . number_format($data->sum('refund'), 0, ',', '.') : '' }}</td>
                            <td class="p-2 border">{{ $data->sum('pemindahan_dana') >0 ? 'Rp.' . number_format($data->sum('pemindahan_dana'), 0, ',', '.') : '' }}</td>
                            <td class="p-2 border"></td>
                        </tr>
                        @php
                            $totalPemasukan = $data->sum('omset_konter')
                                            + $data->sum('omset_retail')
                                            + $data->sum('investor')
                                            + $data->sum('refund')
                                            + $data->sum('pemindahan_dana');
                        @endphp
                        <tr class="font-bold bg-purple-500/40">
                            <td colspan="8" class="text-left p-2 border">Saldo Pemasukan</td>
                            <td class="p-2 border font-bold">{{ $totalPemasukan !== null ? 'Rp.' . number_format($totalPemasukan, 0, ',', '.') : '' }}</td>
                            <td class="p-2 border"></td>
                        </tr>
                    </tbody>
                    <tr id="noDataRow" style="display: none;">
                        <td colspan="4" class="text-center p-2 border">Data tidak ditemukan</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <x-modal name="tambah-user" focusable>
        <form method="POST" action="{{ route('Pemasukan.store') }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-black">Tambah Pemasukan Baru</h2>
            <input type="hidden" name="status" value="pending">
            <div class="mt-4">
                <label for="keteranganSelect" class="block text-gray-700 text-sm font-bold mb-2">
                    Keterangan
                </label>

                <!-- Custom Select -->
                <div class="custom-select-container" id="customSelect">
                    <div class="custom-select-display" id="customSelectDisplay">
                        -- Pilih Keterangan --
                    </div>
                    <div class="custom-select-dropdown" id="customSelectDropdown">
                        <input type="text" class="custom-select-search" placeholder="Cari...">
                        <div id="customSelectOptions">
                            @foreach($data2 as $d)
                                <div class="custom-select-option" data-value="{{$d->kode_akun}},{{$d->keterangan}}">
                                    {{$d->kode_akun}} | {{$d->keterangan}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Hidden Inputs -->
                <input type="hidden" id="hidden_kode_akun" name="kode_akun">
                <input type="hidden" id="hidden_keterangan" name="keterangan">
            </div>

            <div class="mt-4">
                <x-input-label for="tanggal" value="tanggal" />
                <x-text-input id="tanggal" name="tanggal" type="date" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('tanggal')" />
            </div>

            <div class="mt-4">
                <x-input-label for="omset_konter" value="Omset Konter" />
                <x-text-input 
                    id="omset_konter" 
                    name="omset_konter" 
                    type="text" 
                    class="mt-1 block w-full" 
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                />
                <x-input-error class="mt-2" :messages="$errors->get('omset_konter')" />
            </div>

            <div class="mt-4">
                <x-input-label for="omset_retail" value="Omset Retail" />
                <x-text-input 
                    id="omset_retail" 
                    name="omset_retail" 
                    type="text" 
                    class="mt-1 block w-full" 
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                />
                <x-input-error class="mt-2" :messages="$errors->get('omset_retail')" />
            </div>

            <div class="mt-4">
                <x-input-label for="investor" value="Investor" />
                <x-text-input 
                    id="investor" 
                    name="investor" 
                    type="text" 
                    class="mt-1 block w-full" 
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                />
                <x-input-error class="mt-2" :messages="$errors->get('investor')" />
            </div>

            <div class="mt-4">
                <x-input-label for="refund" value="Refund" />
                <x-text-input 
                    id="refund" 
                    name="refund" 
                    type="text" 
                    class="mt-1 block w-full" 
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                />
                <x-input-error class="mt-2" :messages="$errors->get('refund')" />
            </div>

            <div class="mt-4">
                <x-input-label for="pemindahan_dana" value="Pemindahan Dana" />
                <x-text-input 
                    id="pemindahan_dana" 
                    name="pemindahan_dana" 
                    type="text" 
                    class="mt-1 block w-full" 
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                />
                <x-input-error class="mt-2" :messages="$errors->get('pemindahan_dana')" />
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
            let found = false;

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                if (text.includes(filter)) {
                    row.style.display = '';
                    found = true;
                } else {
                    row.style.display = 'none';
                }
            });

            // Tampilkan atau sembunyikan pesan "Data tidak ditemukan"
            document.getElementById('noDataRow').style.display = found ? 'none' : '';
        });
    </script>
    <script>
        const customSelect = document.getElementById('customSelect');
        const display = document.getElementById('customSelectDisplay');
        const dropdown = document.getElementById('customSelectDropdown');
        const searchInput = dropdown.querySelector('.custom-select-search');
        const optionsContainer = document.getElementById('customSelectOptions');
        const hiddenKodeAkun = document.getElementById('hidden_kode_akun');
        const hiddenKeterangan = document.getElementById('hidden_keterangan');

        // Toggle dropdown
        display.addEventListener('click', () => {
            dropdown.classList.toggle('show');
            searchInput.value = '';
            filterOptions('');
            searchInput.focus();
        });

        // Klik di luar custom select untuk menutup dropdown
        document.addEventListener('click', (e) => {
            if (!customSelect.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Filter saat mengetik
        searchInput.addEventListener('input', () => {
            const term = searchInput.value.toLowerCase();
            filterOptions(term);
        });

        // Fungsi filter opsi
        function filterOptions(term) {
            const options = optionsContainer.querySelectorAll('.custom-select-option');
            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                option.style.display = text.includes(term) ? '' : 'none';
            });
        }

        // Klik pada opsi
        optionsContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('custom-select-option')) {
                const value = e.target.getAttribute('data-value');
                display.textContent = e.target.textContent;
                dropdown.classList.remove('show');

                // Set hidden inputs
                const [kode, ket] = value.split(',');
                hiddenKodeAkun.value = kode.trim();
                hiddenKeterangan.value = ket.trim();
            }
        });
    </script>
</x-app-layout>