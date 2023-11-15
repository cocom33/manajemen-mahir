@props(['title', 'route' => '', 'routeBack' => ''])

<div class="content">
    <div class="intro-y space-around col-span-12 flex flex-wrap sm:flex-no-wrap items-center justify-between mt-5">
        <b class="text-xl">{{ $title }}</b>

        @if ($route)
            <div class="flex">
                <a href="{{ $route }}"><button class="button text-white bg-theme-1 shadow-md">Tambah data</button></a>
            </div>
        @endif

        @if ($routeBack)
            <div class="flex">
                <a href="{{ $routeBack }}"><button class="button text-white bg-theme-9 shadow-md ml-2">Kembali</button></a>
            </div>
        @endif
    </div>

    <div class="intro-y datatable-wrapper box p-5 mt-5">
        {{ $slot }}
    </div>
</div>
