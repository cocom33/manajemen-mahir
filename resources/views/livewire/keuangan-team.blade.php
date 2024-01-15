<div>
    <div class="intro-y datatable-wrapper box p-5 flex gap-6">
        <div class="w-full">
            <label>Tahun</label>
            <div class="mt-2">
                <select class="input w-full border-2" wire:model="tahun">
                    <option wire:click="changeb('semua')" value="semua" selected> Semua</option>
                    @forelse ($all as $item)
                        <option wire:click="changet({{ $item->format('Y') }})" value="{{ $item->format('Y') }}">{{ $item->format('Y') }}</option>
                    @empty
                        <option class="hidden" value="{{ date('Y') }}">{{ Date('Y') }}</option>
                    @endforelse
                </select>
            </div>
        </div>

        <div class="w-full">
            <label>Bulan</label>
            <div class="mt-2">
                <select class="input w-full border-2" id="select2" wire:model="bulan">
                    <wire:ignore>
                        <option wire:click="changeb('semua')" value="semua" selected> Semua</option>
                        @foreach ([1,2,3,4,5,6,7,8,9,10,11,12] as $item)
                            <option wire:click="changeb({{ $item }})" value="{{ $item }}" @if($item == date('m')) selected @endif> {{ \Carbon\Carbon::create()->month($item)->format('F') }}</option>
                        @endforeach
                    </wire:ignore>
                </select>
            </div>
        </div>
    </div>


    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <h2 class="text-base font-bold mb-3">Pendapatan : {{ number_format($fee->sum('fee')) }}</h2>

        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2  whitespace-no-wrap">FEE</th>
                    <th class="border-b-2  whitespace-no-wrap">BUKTI</th>
                    <th class="border-b-2  whitespace-no-wrap">TANGGAL</th>
                    <th class="border-b-2  whitespace-no-wrap">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fee as $data)
                    <tr>
                        <td class="border-b">{{ 1000 }}</td>
                        <td class="border-b">
                            @if (true)
                                <a href="" target="_blank" class="inline-block text-white button bg-theme-1" type="button">
                                    Lihat Bukti
                                </a>
                            @else
                                Tidak ada bukti
                            @endif
                        </td>
                        <td class=" border-b">{{ $data->created_at->format('d / m / Y') }}</td>
                        <td class="border-b">
                            <div class="flex  items-center">
                                <a class="flex items-center mr-3 text-theme-1"
                                    href="">
                                    <i data-feather="eye" class="w-4 h-4 mr-1"></i> Lihat
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div wire:loading>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                $('#select2').select2();
                $('#select2').on('change', function (e) {
                    var data = $('#select2').select2("val");
                    @this.set('bulan', data);
                });
            });
        </script>
    @endpush
</div>
