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
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Pengeluaran</h1>

        <div class="container mx-auto p-4">
            <h1 class="text-xl font-semibold mb-4">Data Pengeluaran</h1>

            <!-- Search input -->
            <div class="flex justify-between items-center">
                <div class="flex w-full gap-2">
                    <input type="text" id="searchInput" placeholder="Cari..." class="mb-4 p-2 w-1/2 border rounded">
                    <form method="GET" action="{{ route('Pengeluaran.index') }}" class="flex items-center gap-2 mb-4">
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
                            <th class="p-2 border text-center">Gaji</th>
                            <th class="p-2 border text-center">Biaya Kirim</th>
                            <th class="p-2 border text-center">Transportasi</th>
                            <th class="p-2 border text-center">LPTI</th>
                            <th class="p-2 border text-center">ATK</th>
                            <th class="p-2 border text-center">Bahan</th>
                            <th class="p-2 border text-center">Peralatan</th>
                            <th class="p-2 border text-center">Lain - Lain</th>
                            <th class="p-2 border text-center">Investor</th>
                            <th class="p-2 border text-center">Vendor</th>
                            <th class="p-2 border text-center">Profit</th>
                            <th class="p-2 border text-center">Cicilan</th>
                            <th class="p-2 border text-center">Pajak</th>
                            <th class="p-2 border text-center">Pemindahan</th>
                            <th class="p-2 border text-center">Status</th>
                            <th class="p-2 border text-center">Tools</th>
                        </tr>
                    </thead>
                    <tbody id="kodeTable">
                        @foreach($data as $index => $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 border whitespace-nowrap text-center">{{ $index + 1 }}</td>
                            <td class="p-2 border whitespace-nowrap text-center">{{ $item->kode_akun }}</td>
                            <td class="p-2 border whitespace-nowrap text-center">{{ $item->keterangan }}</td>
                            <td class="p-2 border whitespace-nowrap">{{ $item->tanggal }}</td>
                            <td class="p-2 border whitespace-nowrap">Rp.{{ number_format($item->gaji, 0, ',', '.') }}</td>
                            <td class="p-2 border whitespace-nowrap">Rp.{{ number_format($item->biaya_kirim, 0, ',', '.') }}</td>
                            <td class="p-2 border whitespace-nowrap">Rp.{{ number_format($item->transportasi, 0, ',', '.') }}</td>
                            <td class="p-2 border whitespace-nowrap">Rp.{{ number_format($item->lpti, 0, ',', '.') }}</td>
                            <td class="p-2 border whitespace-nowrap">Rp.{{ number_format($item->atk, 0, ',', '.') }}</td>
                            <td class="p-2 border whitespace-nowrap">Rp.{{ number_format($item->bahan, 0, ',', '.') }}</td>
                            <td class="p-2 border whitespace-nowrap">Rp.{{ number_format($item->peralatan, 0, ',', '.') }}</td>
                            <td class="p-2 border whitespace-nowrap">Rp.{{ number_format($item->lain_lain, 0, ',', '.') }}</td>
                            <td class="p-2 border whitespace-nowrap">Rp.{{ number_format($item->invest, 0, ',', '.') }}</td>
                            <td class="p-2 border whitespace-nowrap">Rp.{{ number_format($item->vendor, 0, ',', '.') }}</td>
                            <td class="p-2 border whitespace-nowrap">Rp.{{ number_format($item->profit, 0, ',', '.') }}</td>
                            <td class="p-2 border whitespace-nowrap">Rp.{{ number_format($item->cicilan, 0, ',', '.') }}</td>
                            <td class="p-2 border whitespace-nowrap">Rp.{{ number_format($item->pajak, 0, ',', '.') }}</td>
                            <td class="p-2 border whitespace-nowrap">Rp.{{ number_format($item->pemindahan, 0, ',', '.') }}</td>
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
                                <!-- Tombol Edit -->
                                <div class="flex gap-2">
                                    <a href="{{ route('Pengeluaran.edit', $item->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Tombol Delete -->
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('Pengeluaran.destroy', $item->id) }}" method="POST" class="inline">
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
                        <tr class="font-bold bg-purple-500/30">
                            <td colspan="4" class="text-left p-2 border">Total</td>
                            <td class="p-2 border">Rp.{{ number_format($data->sum('gaji'), 0, ',', '.') }}</td>
                            <td class="p-2 border">Rp.{{ number_format($data->sum('biaya_kirim'), 0, ',', '.') }}</td>
                            <td class="p-2 border">Rp.{{ number_format($data->sum('transportasi'), 0, ',', '.') }}</td>
                            <td class="p-2 border">Rp.{{ number_format($data->sum('lpti'), 0, ',', '.') }}</td>
                            <td class="p-2 border">Rp.{{ number_format($data->sum('atk'), 0, ',', '.') }}</td>
                            <td class="p-2 border">Rp.{{ number_format($data->sum('bahan'), 0, ',', '.') }}</td>
                            <td class="p-2 border">Rp.{{ number_format($data->sum('peralatan'), 0, ',', '.') }}</td>
                            <td class="p-2 border">Rp.{{ number_format($data->sum('lain_lain'), 0, ',', '.') }}</td>
                            <td class="p-2 border">Rp.{{ number_format($data->sum('invest'), 0, ',', '.') }}</td>
                            <td class="p-2 border">Rp.{{ number_format($data->sum('vendor'), 0, ',', '.') }}</td>
                            <td class="p-2 border">Rp.{{ number_format($data->sum('profit'), 0, ',', '.') }}</td>
                            <td class="p-2 border">Rp.{{ number_format($data->sum('cicilan'), 0, ',', '.') }}</td>
                            <td class="p-2 border">Rp.{{ number_format($data->sum('pajak'), 0, ',', '.') }}</td>
                            <td class="p-2 border">Rp.{{ number_format($data->sum('pemindahan'), 0, ',', '.') }}</td>
                            <td class="p-2 border"></td>
                        </tr>
                        @php
                            $totalPengeluaran = $data->sum('gaji')
                                            + $data->sum('biaya_kirim')
                                            + $data->sum('transportasi')
                                            + $data->sum('lpti')
                                            + $data->sum('atk')
                                            + $data->sum('bahan')
                                            + $data->sum('peralatan')
                                            + $data->sum('lain_lain')
                                            + $data->sum('invest')
                                            + $data->sum('vendor')
                                            + $data->sum('profit')
                                            + $data->sum('cicilan')
                                            + $data->sum('pajak')
                                            + $data->sum('pemindahan');
                        @endphp
                        <tr class="font-bold bg-purple-500/40">
                            <td colspan="17" class="text-left p-2 border">Saldo Pengeluaran</td>
                            <td class="p-2 border font-bold">Rp.{{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                            <td class="p-2 border"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <x-modal name="tambah-user" focusable>
        <form method="POST" action="{{ route('Pengeluaran.store') }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-black">Tambah Pengeluaran Baru</h2>

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
                <x-text-input id="tanggal" name="tanggal" type="date" class="mt-1 block w-full" required/>
                <x-input-error class="mt-2" :messages="$errors->get('tanggal')" />
            </div>

            <div class="mt-4">
                <x-input-label for="gaji" value="gaji" />
                <x-text-input id="gaji" name="gaji" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('gaji')" />
            </div>

            <div class="mt-4">
                <x-input-label for="biaya_kirim" value="biaya_kirim" />
                <x-text-input id="biaya_kirim" name="biaya_kirim" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('biaya_kirim')" />
            </div>

            <div class="mt-4">
                <x-input-label for="transportasi" value="transportasi" />
                <x-text-input id="transportasi" name="transportasi" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('transportasi')" />
            </div>

            <div class="mt-4">
                <x-input-label for="lpti" value="lpti" />
                <x-text-input id="lpti" name="lpti" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('lpti')" />
            </div>

            <div class="mt-4">
                <x-input-label for="atk" value="atk" />
                <x-text-input id="atk" name="atk" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('atk')" />
            </div>

            <div class="mt-4">
                <x-input-label for="bahan" value="bahan" />
                <x-text-input id="bahan" name="bahan" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('bahan')" />
            </div>

            <div class="mt-4">
                <x-input-label for="peralatan" value="peralatan" />
                <x-text-input id="peralatan" name="peralatan" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('peralatan')" />
            </div>

            <div class="mt-4">
                <x-input-label for="lain_lain" value="lain_lain" />
                <x-text-input id="lain_lain" name="lain_lain" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('lain_lain')" />
            </div>

            <div class="mt-4">
                <x-input-label for="invest" value="invest" />
                <x-text-input id="invest" name="invest" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('invest')" />
            </div>

            <div class="mt-4">
                <x-input-label for="vendor" value="vendor" />
                <x-text-input id="vendor" name="vendor" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('vendor')" />
            </div>

            <div class="mt-4">
                <x-input-label for="profit" value="profit" />
                <x-text-input id="profit" name="profit" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('profit')" />
            </div>

            <div class="mt-4">
                <x-input-label for="cicilan" value="cicilan" />
                <x-text-input id="cicilan" name="cicilan" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('cicilan')" />
            </div>

            <div class="mt-4">
                <x-input-label for="pajak" value="pajak" />
                <x-text-input id="pajak" name="pajak" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('pajak')" />
            </div>

            <div class="mt-4">
                <x-input-label for="pemindahan" value="pemindahan" />
                <x-text-input id="pemindahan" name="pemindahan" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('pemindahan')" />
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