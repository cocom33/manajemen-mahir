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
            <div class="relative flex items-center gap-3">
                <p class="text-lg font-bold">Piutang : Rp. {{ number_format($project['piutang']) }}</p>
                <small class="border-2 border-black w-5 h-5 text-center rounded-full cursor-pointer" onclick="Piutang()">i</small>
                <div id="piutang" class="hidden px-4 py-2 bg-theme-1 text-white right-0 absolute rounded-md" style="top: 35px; min-width: 200px">
                    {{-- @dd($project) --}}
                    @if ($project['type_piutang'] == 'termin')
                        @forelse ($project['termin'] as $item)
                            <div class="flex">
                                <p>{{ $item->name }} : Rp. {{ number_format($item->price) }}</p>
                                @if ($item->status == 1) <i data-feather="check" class=" w-4 h-4 font-bold ml-2" style="margin-top: 2px"></i> @endif
                            </div>
                        @empty
                            <div>Belum ada tagihan</div>
                        @endforelse
                    @else
                        <div class="flex">
                            <p>Piutang : Rp. {{ number_format($piutang ?? 0) }}</p>
                            @if (true) <i data-feather="check" class=" w-4 h-4 font-bold ml-2" style="margin-top: 2px"></i> @endif
                        </div>
                    @endif
                </div>
            </div>
            <p class="text-lg font-bold">Pengeluaran : Rp. {{ number_format($project['belanja']) }}</p>
        </div>

        <script>
            function Piutang() {
                if (document.getElementById("piutang").classList.contains('hidden')) {
                    document.getElementById("piutang").classList.remove('hidden')

                    setTimeout(() => {
                        document.getElementById("piutang").classList.add('hidden')
                    }, 2000);
                } else {
                    document.getElementById("piutang").classList.add('hidden')
                }
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
