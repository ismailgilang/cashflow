<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- AlertifyJS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <style>
        /* Ubah warna success */
        .alertify .ajs-message.ajs-success {
            background-color: #dcbbfc !important; /* biru tua */
            color: #fff !important;
        }

        /* Ubah warna error */
        .alertify .ajs-message.ajs-error {
            background-color: #b91c1c !important; /* merah tua */
            color: #fff !important;
        }
    </style>



    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>
        function confirmDelete(id) {
            alertify.confirm('Konfirmasi Hapus', 'Apakah Anda yakin ingin menghapus data ini?',
                function() {
                    // Jika klik OK, submit form
                    document.getElementById('delete-form-' + id).submit();
                    alertify.success('Data berhasil dihapus!');
                },
                function() {
                    // Jika klik Cancel
                    alertify.error('Penghapusan dibatalkan');
                });
        }
    </script>
    <script>
        function confirmLogout() {
            alertify.confirm('Konfirmasi Logout', 'Apakah Anda yakin ingin Logout?',
                function() {
                    // Jika klik OK, submit form
                    document.getElementById('logout-form').submit();
                    alertify.success('Berhasil Logout!');
                },
                function() {
                    // Jika klik Cancel
                    alertify.error('Logout Dibatalkan');
                });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                alertify.success("{{ session('success') }}");
            @endif

            @if(session('error'))
                alertify.error("{{ session('error') }}");
            @endif
        });
    </script>

</body>

</html>