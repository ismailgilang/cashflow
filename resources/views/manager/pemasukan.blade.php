<x-app-layout>
    <div class="ml-20 p-6 bg-gray-100 min-h-screen">
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Pemasukan</h1>
        
        <div class="container mx-auto p-4">
            <h1 class="text-xl font-semibold mb-4">Data Pemasukan</h1>

            <!-- Search input -->
            <div class="flex justify-between items-center">
                <div class="flex w-full gap-2">
                    <input type="text" id="searchInput" placeholder="Cari..." class="mb-4 p-2 w-1/2 border rounded">
                    <form method="GET" action="{{ route('manager.create') }}" class="flex items-center gap-2 mb-4">
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
                                <!-- Tombol Edit -->
                                <div class="flex gap-2">
                                    <a href="{{ route('manager.edit', $item->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="10" fill="#3B82F6"/> <!-- Biru: Tailwind text-blue-500 -->
                                        <path d="M9.5 12.5l1.5 1.5 3.5-3.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('manager.edit21', $item->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
        // Ambil referensi ke elemen select dan input hidden
        const keteranganSelect = document.getElementById('keteranganSelect');
        const hiddenKodeAkun = document.getElementById('hidden_kode_akun');
        const hiddenKeterangan = document.getElementById('hidden_keterangan');

        // Tambahkan event listener untuk mendengarkan perubahan pada select
        keteranganSelect.addEventListener('change', function() {
            const selectedValue = this.value; // Ambil nilai dari option yang terpilih

            if (selectedValue) {
                // Jika ada nilai yang dipilih (bukan option placeholder)
                // Pisahkan string berdasarkan koma
                const parts = selectedValue.split(',');

                // Pastikan ada dua bagian (kode_akun dan keterangan)
                if (parts.length === 2) {
                    // Isi nilai ke input hidden, trim untuk menghilangkan spasi berlebih
                    hiddenKodeAkun.value = parts[0].trim();
                    hiddenKeterangan.value = parts[1].trim();
                } else {
                    // Handle kasus jika format nilai tidak sesuai (misalnya, hanya ada satu bagian)
                    console.warn('Format nilai option tidak sesuai: ' + selectedValue);
                    hiddenKodeAkun.value = '';
                    hiddenKeterangan.value = '';
                }
            } else {
                hiddenKodeAkun.value = '';
                hiddenKeterangan.value = '';
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah ada option yang sudah terpilih secara default
            const initialSelectedValue = keteranganSelect.value;
            if (initialSelectedValue) {
                const parts = initialSelectedValue.split(',');
                if (parts.length === 2) {
                    hiddenKodeAkun.value = parts[0].trim();
                    hiddenKeterangan.value = parts[1].trim();
                }
            }
        });
    </script>

</x-app-layout>