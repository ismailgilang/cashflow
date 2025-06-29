<x-app-layout>
    <div class="ml-20 p-6 bg-gray-100 min-h-screen">
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Dashboard</h1>

        <!-- Cards summary -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
            <!-- Saldo -->


            <!-- Pemasukan -->
            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-green-500 text-4xl mb-3">
                    <i class="fas fa-arrow-circle-down"></i>
                </div>
                <h2 class="text-lg font-semibold mb-1">Pendapatan Bulan Ini</h2>
                <p class="text-2xl font-bold text-gray-700">Rp 5.750.000</p>
            </div>

            <!-- Pengeluaran -->
            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-red-500 text-4xl mb-3">
                    <i class="fas fa-arrow-circle-up"></i>
                </div>
                <h2 class="text-lg font-semibold mb-1">Pengeluaran Bulan Ini</h2>
                <p class="text-2xl font-bold text-gray-700">Rp 3.300.000</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-blue-500 text-4xl mb-3">
                    <i class="fas fa-wallet"></i>
                </div>
                <h2 class="text-lg font-semibold mb-1">Saldo Bulan Ini</h2>
                <p class="text-2xl font-bold text-gray-700">Rp 12.500.000</p>
            </div>

            <!-- Selisih -->
            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-yellow-500 text-4xl mb-3">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h2 class="text-lg font-semibold mb-1">Laba / Rugi Bulan Ini</h2>
                <p class="text-2xl font-bold text-gray-700">Rp 2.450.000</p>
            </div>
        </div>

        <!-- Grafik dan Ringkasan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Grafik pemasukan/pengeluaran -->
            <div class="bg-white rounded-lg shadow p-6 col-span-2">
                <h3 class="text-xl font-semibold mb-4">Grafik Pemasukan & Pengeluaran</h3>
                <!-- Placeholder grafik -->
                <div class="w-full h-64 bg-gray-200 rounded flex items-center justify-center text-gray-400">
                    Grafik akan muncul di sini
                </div>
            </div>

            <!-- Ringkasan aktivitas -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold mb-4">Ringkasan Aktivitas</h3>
                <ul class="space-y-3 text-gray-700">
                    <li>10 Transaksi baru hari ini</li>
                    <li>3 Pemasukan baru ditambahkan</li>
                    <li>1 Pengeluaran besar tercatat</li>
                    <li>Saldo terakhir diperbarui 1 jam lalu</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>