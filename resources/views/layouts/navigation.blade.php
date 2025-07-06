<!-- Sidebar -->
<div class="fixed flex flex-col items-center w-20 h-screen overflow-visible bg-gray-900 text-gray-300 shadow-lg z-50">

    <!-- Logo -->
    @if(auth()->user()->role === 'admin')
    <a href="{{route('admin.index')}}" class="flex items-center justify-center w-full h-16 text-white hover:text-blue-400">
        <i class="fas fa-cubes text-2xl"></i>
    </a>
    @endif
    @if(auth()->user()->role === 'super')
    <a href="{{route('dashboard')}}" class="flex items-center justify-center w-full h-16 text-white hover:text-blue-400">
        <i class="fas fa-cubes text-2xl"></i>
    </a>
    @endif

    <div class="w-full border-t border-gray-700 mb-4"></div>

    <!-- Navigation -->
    <nav class="flex flex-col items-center w-full space-y-2 relative">

        <!-- Menu Item with full width hover text -->
        @if(auth()->user()->role === 'admin')
        <div class="group relative w-full">
            <a href="{{route('admin.index')}}" class="flex flex-col items-center w-full py-3 hover:bg-gray-800 hover:text-blue-400">
                <i class="fas fa-home text-xl"></i>
            </a>
            <!-- Full width label -->
            <div class="absolute top-0 left-20 h-full bg-gray-800 text-white text-sm flex items-center px-4 rounded-r opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300 z-50">
                Home
            </div>
        </div>
        @endif
        @if(auth()->user()->role === 'super')
        <div class="group relative w-full">
            <a href="{{route('dashboard')}}" class="flex flex-col items-center w-full py-3 hover:bg-gray-800 hover:text-blue-400">
                <i class="fas fa-home text-xl"></i>
            </a>
            <!-- Full width label -->
            <div class="absolute top-0 left-20 h-full bg-gray-800 text-white text-sm flex items-center px-4 rounded-r opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300 z-50">
                Home
            </div>
        </div>
        @endif

        @if(auth()->user()->role === 'admin')
        <div class="group relative w-full">
            <a href="{{ route('Users.index')}}" class="flex flex-col items-center w-full py-3 hover:bg-gray-800 hover:text-blue-400">
                <i class="fas fa-users text-xl"></i>
            </a>
            <div class="absolute top-0 left-20 h-full bg-gray-800 text-white text-sm flex items-center px-4 rounded-r opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300 z-50">
                User
            </div>
        </div>


        <div class="group relative w-full">
            <a href="{{route('Kode.index')}}" class="flex flex-col items-center w-full py-3 hover:bg-gray-800 hover:text-blue-400">
                <i class="fas fa-address-card text-xl"></i>
            </a>
            <div class="absolute top-0 left-20 h-full bg-gray-800 text-white text-sm flex items-center px-4 rounded-r opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300 z-50">
                Kode Akun
            </div>
        </div>

        <!-- Dropdown Menu -->
        <div x-data="{ openTransaksi: false }" class="relative w-full group">
            <!-- Tombol Transaksi dengan hover text animasi -->
            <button @click="openTransaksi = !openTransaksi"
                class="flex flex-col items-center w-full py-3 hover:bg-gray-800 focus:outline-none relative group">
                <i class="fas fa-edit text-xl group-hover:text-blue-400"></i>
                <div class="absolute top-0 left-20 h-full bg-gray-800 text-white text-sm flex items-center px-4 rounded-r opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300 z-50">
                    Transaksi
                </div>
            </button>

            <!-- Dropdown submenu muncul ke bawah tombol -->
            <div x-show="openTransaksi" x-transition
                class="w-full mt-1 space-y-1 flex flex-col items-center"
                style="display: none;">
                <a href="{{route('Pemasukan.index')}}"
                    class="flex flex-col items-center w-full py-3 hover:bg-gray-800 transition duration-150">
                    <i class="fas fa-arrow-circle-down text-blue-400 text-xl"></i>
                    <span class="text-[10px] mt-1 hidden xl:block text-gray-300">
                        Pemasukan
                    </span>
                </a>
                <a href="{{route('Pengeluaran.index')}}"
                    class="flex flex-col items-center w-full py-3 hover:bg-gray-800 transition duration-150">
                    <i class="fas fa-arrow-circle-up text-red-400 text-xl"></i>
                    <span class="text-[10px] mt-1 hidden xl:block text-gray-300">
                        Pengeluaran
                    </span>
                </a>
            </div>
        </div>


        <div class="group relative w-full">
            <a href="{{route('Laporan.index')}}" class="flex flex-col items-center w-full py-3 hover:bg-gray-800 hover:text-blue-400">
                <i class="fas fa-file-alt text-xl"></i>
            </a>
            <div class="absolute top-0 left-20 h-full bg-gray-800 text-white text-sm flex items-center px-4 rounded-r opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300 z-50">
                Laporan
            </div>
        </div>
        @endif

        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'super')
        <div class="group relative w-full">
            <a href="{{route('Riwayat.index')}}" class="flex flex-col items-center w-full py-3 hover:bg-gray-800 hover:text-blue-400">
                <i class="fas fa-history text-xl"></i>
            </a>
            <div class="absolute top-0 left-20 h-full bg-gray-800 text-white text-sm flex items-center px-4 rounded-r opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300 z-50">
                Riwayat
            </div>
        </div>
        @endif

        @if(auth()->user()->role === 'manajer')
            <div x-data="{ openTransaksi: false }" class="relative w-full group">
                <!-- Tombol Transaksi dengan hover text animasi -->
                <button @click="openTransaksi = !openTransaksi"
                    class="flex flex-col items-center w-full py-3 hover:bg-gray-800 focus:outline-none relative group">
                    <i class="fa-regular text-xl fa-circle-check group-hover:text-blue-400"></i>
                    <div class="absolute top-0 left-20 h-full bg-gray-800 text-white text-sm flex items-center px-4 rounded-r opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300 z-50">
                        Legalisasi Transaksi
                    </div>
                </button>

                <!-- Dropdown submenu muncul ke bawah tombol -->
                <div x-show="openTransaksi" x-transition
                    class="w-full mt-1 space-y-1 flex flex-col items-center"
                    style="display: none;">
                    <a href="{{route('manager.create2')}}"
                        class="flex flex-col items-center w-full py-3 hover:bg-gray-800 transition duration-150">
                        <i class="fas fa-arrow-circle-down text-blue-400 text-xl"></i>
                        <span class="text-[10px] mt-1 hidden xl:block text-gray-300">
                            Pemasukan
                        </span>
                    </a>
                    <a href="{{route('manager.create')}}"
                        class="flex flex-col items-center w-full py-3 hover:bg-gray-800 transition duration-150">
                        <i class="fas fa-arrow-circle-up text-red-400 text-xl"></i>
                        <span class="text-[10px] mt-1 hidden xl:block text-gray-300">
                            Pengeluaran
                        </span>
                    </a>
                </div>
            </div>
        @endif
    </nav>
    <div class="flex-grow"></div>

    <!-- Profile -->
    <form method="POST" action="{{ route('logout') }}" class="group relative w-full mb-4">
        @csrf
        <button type="submit" class="flex flex-col items-center w-full py-3 hover:bg-gray-800 hover:text-blue-400 focus:outline-none">
            <i class="fas fa-right-from-bracket text-2xl text-gray-400 group-hover:text-blue-400"></i>
        </button>
        <div class="absolute top-0 left-20 h-full bg-gray-800 text-white text-sm flex items-center px-4 rounded-r opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300 z-50">
            logout
        </div>
    </form>

</div>