<div>
    <div class="flex justify-around items-center">
        <div class="text-center">
            <h4 class="text-md">Pemasukan</h4>
            <p class="font-bold text-lg">{{ number_format($detail->where('status', 'pemasukan')->sum('total')) }}</p>
        </div>
        <div class="text-center">
            <h4 class="text-md">Pengeluaran</h4>
            <p class="font-bold text-lg">{{ number_format($detail->where('status', 'pengeluaran')->sum('total')) }}</p>
        </div>
        <div class="text-center">
            <h4 class="text-md">Kas</h4>
            <p class="font-bold text-lg">{{ number_format($kas->where('status', 'pemasukan')->sum('total') - $kas->where('status', 'pengeluaran')->sum('total')) }}</p>
        </div>
    </div>

    <div class="intro-y datatable-wrapper box p-5 mt-5 flex gap-6">
        <div class="w-full">
            <label>Tahun</label>
            <div class="mt-2">
                <select class="input w-full border-2" wire:model="tahun">
                    <option wire:click="changeb('semua')" value="semua" selected> Semua</option>
                    @forelse ($all as $item)
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

        <div class="w-full">
            <label>Bank</label>
            <div class="mt-2">
                <select class="input w-full border-2" id="select2" wire:model="bank">
                    <wire:ignore>
                        <option wire:click="changebank('semua')" value="semua" selected>Semua</option>
                        @foreach ($banks as $item)
                            <option wire:click="changebank({{ $item->id }})" value="{{ $item->id }}">{{ $item->name }}</option>
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
                    <th class="border-b-2 whitespace-no-wrap text-center">STATUS</th>
                    <th class="border-b-2 whitespace-no-wrap text-center">TOTAL</th>
                    <th class="border-b-2 whitespace-no-wrap text-center">BANK</th>
                    <th class="border-b-2 whitespace-no-wrap text-center">TANGGAL</th>
                    <th class="border-b-2 whitespace-no-wrap">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($detail as $key => $data)
                    <tr>
                        <td class="border-b"><span class="hidden">{{ $key }}</span>{{ $data->description }}</td>
                        <td class="border-b">
                            @if ($data->status == 'pemasukan')
                            <div class="flex items-center justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Pemasukan </div>
                            @else
                            <div class="flex items-center justify-center text-theme-6"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Pengeluaran </div>
                            @endif
                        </td>
                        <td class="border-b text-center">Rp. {{ number_format($data->total) }}</td>
                        <td class="border-b text-center">{{ $data->bank->name }}</td>
                        <td class="border-b text-center">{{ $data->tanggal }} / {{ $data->keuanganPerusahaan->bulan }} / {{ $data->keuanganPerusahaan->tahun }}</td>
                        <td class="border-b">
                            <div class="flex justify-center items-center gap-2">
                                @if ($data->tagihan_id)
                                    @php
                                        $route = route('tagihan.show', $data->tagihan_id);
                                        if ($data->tagihan && $data->tagihan->project) {
                                            $route = route('project.tagihan.detail', [$data->tagihan->project->slug, $data->tagihan->id]);
                                        }
                                    @endphp
                                    <a href="{{ $route }}"
                                        class="button inline-block text-white bg-theme-1 rounded-md">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                @elseif ($data->project_team_fee_id)
                                    <a href="{{ route('project.teams.show', [$data->project_team_fee->projectTeam->project->slug, $data->project_team_fee->project_team_id]) }}"
                                        class="button inline-block text-white bg-theme-1 rounded-md">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                @elseif ($data->langsung_id)
                                    <a href="{{ route('project.pemasukan', $data->langsung->keuangan_project->project->slug) }}"
                                        class="button inline-block text-white bg-theme-1 rounded-md">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                @elseif ($data->termin_id)
                                    <a href="{{ route('project.pemasukan.termin.detail', [$data->termin->keuangan_project->project->slug, $data->termin->slug]) }}"
                                        class="button inline-block text-white bg-theme-1 rounded-md">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                @elseif ($data->pengeluaran_id)
                                    <a href="{{ route('project.pengeluaran.show', [$data->pengeluaran->project->slug, $data->pengeluaran->id]) }}"
                                        class="button inline-block text-white bg-theme-1 rounded-md">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                @else
                                    <a href="{{ route('keuangan-umum.edit', $data->id) }}"
                                        class="button inline-block text-white bg-theme-9 rounded-md">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="{{ route('keuangan-umum.show', $data->id) }}"
                                        class="button inline-block text-white bg-theme-1 rounded-md">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <form method="POST" action="{{ route('keuangan-umum.destroy', $data->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="show-alert-delete-box button inline-block text-theme-6 bg-theme-6 rounded-md">
                                            <i class="fa-solid fa-trash text-white"></i>
                                        </button>
                                    </form>
                                @endif
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

    {{-- @push('scripts')
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
    @endpush --}}
</div>
