<x-app-layout>
    <div class="ml-20 p-6 bg-gray-100 min-h-screen">
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Dashboard</h1>
        <div class="w-full h-34 bg-purple-500/40 rounded-md p-4">
            <h1 class="text-center text-[24px] text-white">Selamat Datang !</h1>
            <p class="text-white text-center text-[16px]"> Di Aplikasi Cashflow CV. Zelia Indonesia</p>
            <p class="text-white text-center text-[16px]"></p>
        </div>

        <!-- Cards summary -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8 mt-4">

            <!-- Pemasukan -->
            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-green-500 text-4xl mb-3">
                    <i class="fas fa-arrow-circle-down"></i>
                </div>
                <h2 class="text-lg font-semibold mb-1">Pendapatan Bulan Ini</h2>
                <p class="text-2xl font-bold text-gray-700">Rp {{ number_format($saldoplus, 0, ',', '.') }}</p>
            </div>

            <!-- Pengeluaran -->
            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-red-500 text-4xl mb-3">
                    <i class="fas fa-arrow-circle-up"></i>
                </div>
                <h2 class="text-lg font-semibold mb-1">Pengeluaran Bulan Ini</h2>
                <p class="text-2xl font-bold text-gray-700">Rp {{ number_format($saldominus, 0, ',', '.') }}</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-blue-500 text-4xl mb-3">
                    <i class="fas fa-wallet"></i>
                </div>
                <h2 class="text-lg font-semibold mb-1">Saldo</h2>
                <form method="GET" action="{{ route('admin.index') }}" class="mb-4">
                    @csrf
                    <select name="filter" onchange="this.form.submit()" class="border rounded px-3 py-1 text-sm">
                        <option value="" {{ request('filter') == '' ? 'selected' : '' }}>Semua Data</option>
                        <option value="bulan" {{ request('filter') == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="triwulan" {{ request('filter') == 'triwulan' ? 'selected' : '' }}>Triwulan (3 Bulan Terakhir)</option>
                        <option value="tahun" {{ request('filter') == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
                    </select>
                </form>
                <p class="text-2xl font-bold text-gray-700">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-yellow-500 text-4xl mb-3">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h2 class="text-lg font-semibold mb-1">Laba / Rugi Bulan Ini</h2>
                <p class="text-2xl font-bold text-gray-700">Rp {{ number_format($labaRugiBulanIni, 0, ',', '.') }}</p>
            </div>

            
        </div>

        <!-- Grafik dan Ringkasan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Grafik pemasukan/pengeluaran -->
            <div class="bg-white rounded-lg shadow p-6 col-span-2">
                <h3 class="text-xl font-semibold mb-4">Grafik Laba/Rugi</h3>
                <!-- Placeholder grafik -->
                <div class="w-full h-64 bg-gray-200 rounded flex items-center justify-center text-gray-400">
                    <canvas id="grafikLabaRugi" height="100"></canvas>
                </div>
            </div>

            <!-- Ringkasan aktivitas -->
            <div class="bg-white rounded-lg shadow p-6">
            @php
                $today = \Carbon\Carbon::today();
                $month = $month ?? $today->month;
                $year = $year ?? $today->year;

                $monthName = \Carbon\Carbon::create(null, $month)->translatedFormat('F');
                $startOfMonth = \Carbon\Carbon::create($year, $month)->startOfMonth();
                $endOfMonth = \Carbon\Carbon::create($year, $month)->endOfMonth();
                $startDay = $startOfMonth->dayOfWeekIso; // Senin = 1
                $totalDays = $endOfMonth->day;
            @endphp

            <div class="max-w-md mx-auto bg-white rounded-lg shadow p-4">
                <h2 class="text-xl font-bold text-center mb-4">
                    {{ $monthName }} {{ $year }}
                </h2>

                <div class="grid grid-cols-7 gap-1 text-sm text-center font-medium text-gray-700 mb-2">
                    <div>Sen</div>
                    <div>Sel</div>
                    <div>Rab</div>
                    <div>Kam</div>
                    <div>Jum</div>
                    <div>Sab</div>
                    <div>Min</div>
                </div>

                <div class="grid grid-cols-7 gap-1 text-center">
                    @for ($i = 1; $i < $startDay; $i++)
                        <div></div>
                    @endfor

                    @for ($day = 1; $day <= $totalDays; $day++)
                        @php
                            $currentDate = \Carbon\Carbon::create($year, $month, $day);
                            $isToday = $currentDate->isToday();
                        @endphp
                        <div class="p-2 rounded 
                            {{ $isToday ? 'bg-purple-500/30 text-black font-bold' : 'bg-gray-100' }}">
                            {{ $day }}
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikLabaRugi').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Laba/Rugi per Bulan',
                data: {!! json_encode($dataLabaRugi) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
</script>