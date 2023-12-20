@props(['title', 'project' => '', 'route' => '', 'routeBack' => '', 'routeEdit' => ''])

    <div class="intro-y space-around col-span-12 flex flex-wrap sm:flex-no-wrap items-center justify-between mt-5">
        <b class="text-xl">{{ $title }}</b>

        @if ($route)
            <div class="flex">
                <a href="{{ $route }}"><button class="button text-white bg-theme-1 shadow-md">Tambah data</button></a>
            </div>
        @endif

        @if ($routeEdit)
            <div class="flex">
                <a href="{{ $routeEdit }}"><button class="button text-white bg-theme-1 shadow-md">Edit data</button></a>
            </div>
        @endif

        @if ($project)
            <div class="flex gap-3 items-center relative">
                <p class="text-lg font-bold mr-3">Harga Deal : Rp. {{ number_format($project['deal']) }}</p>
                <p class="text-lg font-bold">Piutang : Rp. {{ number_format($project['sisa']) }}</p>
                <p class="text-lg font-bold">Pengeluaran : Rp. {{ number_format($project['sisa']) }}</p>
                <small class="border-2 border-black w-5 h-5 text-center rounded-full cursor-pointer" onclick="Detail()">i</small>
                <div id="detail" class="hidden px-4 py-2 bg-theme-1 text-white absolute right-0 rounded-md" style="top: 35px">
                    @if ($project['type_pajak'] == 0)
                        <p>Pajak : Rp. {{ number_format($project['pajak']) }}</p>
                    @endif
                    <p>Fee Team : Rp. {{ number_format($project['fee']) }}</p>
                    <p>Pengeluaran Project : Rp. {{ number_format($project['belanja']) }}</p>
                </div>
            </div>

            <script>
                function Detail() {
                    document.getElementById("detail").classList.remove('hidden')
                    setTimeout(() => {
                        document.getElementById("detail").classList.add('hidden')
                    }, 2000);
                }
            </script>
        @endif

        @if ($routeBack)
            <div class="flex">
                <a href="{{ $routeBack }}"><button class="button text-white bg-theme-1 shadow-md ml-2">Kembali</button></a>
            </div>
        @endif
    </div>

    <div class="intro-y datatable-wrapper box p-5 mt-5">
        {{ $slot }}
    </div>
