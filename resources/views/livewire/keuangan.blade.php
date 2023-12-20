<div>
    <div class="intro-y datatable-wrapper box p-5 mt-5 flex gap-6">
        <div class="w-full">
            <label>Tahun</label>
            <div class="mt-2">
                <select class="input w-full border-2" wire:model="tahun">
                    <option wire:click="changeb('semua')" value="semua" selected> Semua</option>
                    @forelse ($filtertahun as $item)
                        <option wire:click="changet({{ $item }})" value="{{ $item }}">{{ $item }}</option>
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
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">TITLE</th>
                    <th class="border-b-2  whitespace-no-wrap">STATUS</th>
                    <th class="border-b-2  whitespace-no-wrap">TOTAL</th>
                    <th class="border-b-2  whitespace-no-wrap">TANGGAL</th>
                    <th class="border-b-2  whitespace-no-wrap">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($detail as $data)
                    <tr>
                        <td class="border-b">{{ $data->description }}</td>
                        <td class=" border-b">
                            @if ($data->status == 'pemasukan')
                            <div class="flex items-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Pemasukan </div>
                            @else
                            <div class="flex items-center text-theme-6"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Pengeluaran </div>
                            @endif
                        </td>
                        <td class=" border-b">Rp. {{ number_format($data->total) }}</td>
                        <td class=" border-b">{{ $data->tanggal }} / {{ $data->keuanganPerusahaan->bulan }} / {{ $data->keuanganPerusahaan->tahun }}</td>
                        <td class="border-b">
                            <div class="flex  items-center">
                                <a class="flex items-center mr-3" href="{{ route('keuangan-umum.edit', $data->id) }}">
                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('keuangan-umum.destroy', $data->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center text-theme-6 show-alert-delete-box" data-toggle="tooltip" title='Delete'><i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete</button>
                                </form>
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
