<x-app-layout>
    <div class="ml-20 p-6 bg-gray-100 min-h-screen">
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Laporan</h1>

        <div class="container mx-auto p-4">
            <h1 class="text-xl font-semibold mb-4">Data Laporan</h1>

            <form method="GET" action="{{ route('Laporan.index') }}" class="mb-6 space-y-4">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Periode Awal</label>
                        <input type="month" name="periode_awal" value="{{ request('periode_awal') }}"
                            class="w-full p-2 border rounded" />
                    </div>
                    <div class="flex-1">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Periode Akhir</label>
                        <input type="month" name="periode_akhir" value="{{ request('periode_akhir') }}"
                            class="w-full p-2 border rounded" />
                    </div>
                    <div class="flex-1">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Jenis Laporan</label>
                        <select name="jenis_laporan" class="w-full p-2 border rounded">
                            <option value="">-- Pilih --</option>
                            <option value="arus_kas" {{ request('jenis_laporan') == 'arus_kas' ? 'selected' : '' }}>Arus Kas</option>
                            <option value="laba_rugi" {{ request('jenis_laporan') == 'laba_rugi' ? 'selected' : '' }}>Laba Rugi</option>
                        </select>
                    </div>
                </div>
                <button type="submit"
                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Filter</button>
            </form>


            <!-- Laporan Laba Rugi -->
            <div id="kas" class="max-w-3xl mt-4 mx-auto border border-black p-6 {{ request('jenis_laporan') == 'laba_rugi' ? '' : 'hidden' }}">
                <h1 class="text-center text-lg font-bold underline mb-2">LAPORAN LABA ( RUGI )</h1>
                <h2 class="text-center text-sm mb-6">
                    PERIODE {{ \Carbon\Carbon::parse($periodeAwal)->translatedFormat('d F Y') ?? '-' }} -
                    {{ \Carbon\Carbon::parse($periodeAkhir)->translatedFormat('d F Y') ?? '-' }}
                </h2>

                <div class="mb-4">
                    <h3 class="font-semibold">PENDAPATAN</h3>
                    <div class="flex justify-between"><span>Yogya Dept Store</span><span>Rp.{{ number_format($yogya, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Retail & Online</span><span>Rp.{{ number_format($omsetretail, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between font-semibold border-t border-black mt-1 pt-1">
                        <span>Jumlah Pendapatan</span><span>Rp.{{ number_format($yogya + $omsetretail, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between mt-4"><span>Pengurangan Pendapatan</span><span></span></div>
                    <div class="flex justify-between"><span class="ml-4">Komisi Penjualan</span><span>-</span></div>
                    <div class="flex justify-between font-semibold border-t border-black mt-1 pt-1">
                        <span>Jumlah Pengurangan Pendapatan</span><span>-</span>
                    </div>

                    <div class="flex justify-between font-semibold mt-4">
                        <span>Pendapatan Bersih</span><span>Rp.{{ number_format($yogya + $omsetretail, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="font-semibold">HARGA POKOK PENJUALAN</h3>
                    <div class="flex justify-between">
                        <span>Laba Kotor</span><span>Rp.{{ number_format($kotor, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-semibold">
                        <span>Selisih</span>
                        <span>Rp.{{ number_format(($yogya + $omsetretail) - $kotor, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="font-semibold">BIAYA OPERASIONAL</h3>
                    <div class="flex justify-between"><span>B. Gaji</span><span>Rp.{{ number_format($gaji, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>B. Operasional</span><span>Rp.{{ number_format($operasional, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>B. Penyusutan</span><span>-</span></div>
                    <div class="flex justify-between"><span>B. Maintanance</span><span>-</span></div>
                    <div class="flex justify-between"><span>B. Pengurusan & Perijinan</span><span>-</span></div>
                    <div class="flex justify-between"><span>B. Sewa</span><span>-</span></div>
                    <div class="flex justify-between"><span>B. Operasional Lainnya</span><span>Rp.{{ number_format($operasionalLain, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between font-semibold border-t border-black mt-1 pt-1">
                        <span>Jumlah Biaya Operasional</span>
                        <span>Rp.{{ number_format($gaji + $operasional + $operasionalLain, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-red-600">
                        <span>Laba Usaha</span>
                        <span>Rp.{{ number_format((($yogya + $omsetretail) - $kotor) - ($gaji + $operasional + $operasionalLain), 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="font-semibold">BIAYA & PENDAPATAN LAIN - LAIN</h3>
                    <h4 class="ml-4 font-semibold">A. BIAYA LAIN - LAIN</h4>
                    <div class="flex justify-between"><span class="ml-8">B. Pajak Bagi Hasil Tabungan/Giro</span><span>-</span></div>
                    <div class="flex justify-between"><span class="ml-8">B. Denda</span><span>-</span></div>
                    <div class="flex justify-between"><span class="ml-8">B. Lain-lain</span><span>-</span></div>

                    <h4 class="ml-4 font-semibold mt-2">B. PENDAPATAN LAIN - LAIN</h4>
                    <div class="flex justify-between"><span class="ml-8">Pendapatan Bagi Hasil Tabungan / Giro</span><span>-</span></div>
                    <div class="flex justify-between"><span class="ml-8">Pendapatan Lainnya</span><span>-</span></div>

                    <div class="flex justify-between font-semibold border-t border-black mt-2 pt-1">
                        <span>Jumlah biaya & pendapatan lainnya</span><span>-</span>
                    </div>
                    <div class="flex justify-between font-bold text-red-600">
                        <span>LABA BERSIH SEBELUM PAJAK</span>
                        <span>Rp.{{ number_format((($yogya + $omsetretail) - $kotor) - ($gaji + $operasional + $operasionalLain), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>


            <!-- Arus Kas -->
            <div id="laba" class="max-w-3xl mt-4 mx-auto border border-black p-6 {{ request('jenis_laporan') == 'arus_kas' ? '' : 'hidden' }}">
                <h1 class="text-center text-lg font-bold text-black py-2 mb-4">ARUS KAS JANUARI</h1>
                <h2 class="text-center text-sm mb-6">
                    PERIODE {{ \Carbon\Carbon::parse($periodeAwal)->translatedFormat('d F Y') ?? '-' }} -
                    {{ \Carbon\Carbon::parse($periodeAkhir)->translatedFormat('d F Y') ?? '-' }}
                </h2>

                <div class="mb-6">
                    <h2 class="font-semibold mb-2">Aktifitas Operasional</h2>

                    <h3 class="font-medium">A. Penerimaan Kas Dari :</h3>
                    <div class="flex justify-between"><span>Omset Dari Mall</span><span>Rp.{{ number_format($yogya, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Penerimaan Lain</span><span>Rp.{{ number_format($omsetretail, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between font-semibold border-t border-black mt-1 pt-1"><span>Total Penerimaan</span><span>{{ number_format($yogya + $omsetretail, 0, ',', '.') }}</span></div>
                </div>

                <div class="mb-6">
                    <h3 class="font-medium">B. Pengeluaran Kas :</h3>
                    <div class="flex justify-between"><span>Pembelian Bahan</span><span>Rp.{{ number_format($bahan, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Pembayaran Gaji</span><span>Rp.{{ number_format($gaji, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Transportasi</span><span>Rp.{{ number_format($transportasi, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Biaya Kirim</span><span>Rp.{{ number_format($biayaKirim, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Pembayaran Jasa Vendor</span><span>Rp.{{ number_format($vendor, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Lain-Lain</span><span>Rp.{{ number_format($lainLain, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between font-semibold border-t border-black mt-1 pt-1"><span>Total Pengeluaran</span><span>Rp.{{ number_format($bahan + $gaji + $transportasi + $biayaKirim + $vendor + $lainLain, 0, ',', '.') }}</span></div>
                </div>

                <div>
                    <h3 class="font-medium">C. Arus Kas Aktifitas Investasi :</h3>
                    <div class="flex justify-between"><span>Pengeluaran Kas</span><span>-</span></div>
                    <div class="flex justify-between"><span>Pengembalian Investasi</span><span>Rp.{{ number_format($pengeluarankas, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Cicilan BRI</span><span>-</span></div>
                    <div class="flex justify-between"><span>Cicilan ACC</span><span>Rp.{{ number_format($cicilan, 0, ',', '.') }}</span></div>
                    <div class="flex justify-end font-semibold border-t border-black mt-1 pt-1"><span>Rp.{{ number_format($pengeluarankas + $cicilan, 0, ',', '.') }}</span></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>