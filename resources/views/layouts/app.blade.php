<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/x-icon" href="https://simpleicon.com/wp-content/uploads/link-2.svg">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Midone admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="R44MMPR">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Dashboard - Mahir</title>
        <!-- BEGIN: CSS Assets-->
        @livewireStyles
        @stack('styles')
        <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
        <link rel="stylesheet" href="{{ asset('dist/css/iziToast.min.css') }}" />
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet">
    </head>

    <body class="app">
        @include('layouts.mobile-menu')

        <div class="flex">

            @include('layouts.side-menu')

            <div class="content">

            @include('layouts.navbar')

            <!-- BEGIN: Content -->
                @yield('content')
            <!-- END: Content -->

            </div>

        </div>

        @livewireScripts
        @stack('scripts')
        @include('layouts.scripts')

        @if($errors->any())
            @foreach($errors->all() as $error)
                <script>
                    iziToast.error({
                        title: '',
                        position: 'topRight',
                        message: '{{ $error }}',
                    });
                </script>
            @endforeach
        @endif
        @if(session()->get('error'))
            <script>
                iziToast.error({
                    title: '',
                    position: 'topRight',
                    message: '{{ session()->get('error') }}',
                });
            </script>
        @endif

        @if(session()->get('success'))
            <script>
                iziToast.success({
                    title: '',
                    position: 'topRight',
                    message: '{{ session()->get('success') }}',
                });
            </script>
        @endif
        <script>
            const menuBtn = document.getElementById('side-menu-toggler');
            const sidebar = document.getElementById('side-menu');

            menuBtn.onclick = function() {
                const iconElement = document.getElementById('side-menu-toggler');
            if (sidebar.className.indexOf('side-nav--simple') === -1) {
                sidebar.className += ' side-nav--simple';
                iconElement.setAttribute('data-feather', 'arrow-right');
            } else {
                sidebar.className = 'side-nav';
                iconElement.setAttribute('data-feather', 'arrow-left');
            }
            return;
            };

        </script>
        {{-- @vite('resources/js/app.js') --}}
    </body>
</html>
