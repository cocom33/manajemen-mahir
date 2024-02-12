<div>
    <div class="flex justify-around items-center">
        <div class="text-center">
            <h4 class="text-lg">Pemasukan</h4>
            <p class="font-bold text-xl">{{ number_format($detail->where('status', 'pemasukan')->sum('total')) }}</p>
        </div>
        <div class="text-center">
            <h4 class="text-lg">Pengeluaran</h4>
            <p class="font-bold text-xl">{{ number_format($detail->where('status', 'pengeluaran')->sum('total')) }}</p>
        </div>
        <div class="text-center">
            <h4 class="text-lg">Kas</h4>
            <p class="font-bold text-xl">{{ number_format($kas->where('status', 'pemasukan')->sum('total') - $kas->where('status', 'pengeluaran')->sum('total')) }}</p>
        </div>
    </div>

    <div class="intro-y datatable-wrapper box p-5 mt-5 flex gap-6">
        <div class="w-full">
            <label>Tahun</label>
            <div class="mt-2">
                <div class="relative w-full">
                  <div class="input w-full border-2 py-2 flex justify-between items-center" id="divtahun" onclick="showData('listtahun', 'divtahun');" >
                        <span wire:ignore id="tahun">semua</span>
                        <span><i class="fa-solid fa-angle-down"></i></span>
                  </div>
                  <div id="listtahun" class="absolute bg-white w-full border-2 hidden">
                    <div wire:model="tahun" class="listdata" wire:click="changet('semua')" onclick="changeText('tahun', 'semua');">semua</div>
                    @foreach ($all as $item)
                        <div wire:model="tahun" class="listdata" wire:click="changet({{ $item }})" onclick="changeText('tahun', '{{ $item }}');">{{ $item }}</div>
                    @endforeach
                  </div>
                </div>
            </div>
        </div>

        <div class="w-full">
            <label>Bulan</label>
            <div class="mt-2">
                <div class="relative w-full">
                  <div class="input w-full border-2 py-2 flex justify-between items-center" id="divbulan" onclick="showData('listbulan', 'divbulan');" >
                        <span wire:ignore id="bulan">semua</span>
                        <span><i class="fa-solid fa-angle-down"></i></span>
                  </div>
                  <div id="listbulan" class="absolute bg-white w-full border-2 hidden">
                    <div wire:model="bulan" class="listdata" wire:click="changeb('semua')" onclick="changeText('bulan', 'semua');">semua</div>
                    @foreach ([1,2,3,4,5,6,7,8,9,10,11,12] as $item)
                        <div wire:model="bulan" class="listdata" wire:click="changeb({{ $item }})" onclick="changeText('bulan', '{{ \Carbon\Carbon::create()->month($item)->format('F') }}');">{{ \Carbon\Carbon::create()->month($item)->format('F') }}</div>
                    @endforeach
                  </div>
                </div>
            </div>
        </div>

        <div class="w-full">
            <label>Bank</label>
            <div class="mt-2">
                <div class="relative w-full">
                  <div class="input w-full border-2 py-2 flex justify-between items-center" id="divbank" onclick="showData('listbank', 'divbank');" >
                        <span wire:ignore id="bank">semua</span>
                        <span><i class="fa-solid fa-angle-down"></i></span>
                  </div>
                  <div id="listbank" class="absolute bg-white w-full border-2 hidden">
                    <div wire:model="bank" class="listdata" wire:click="changebank('semua')" onclick="changeText('bank', 'semua');">semua</div>
                    @foreach ($banks as $bank)
                        <div wire:model="bank" class="listdata" wire:click="changebank({{ $bank->id }})" onclick="changeText('bank', '{{ $bank->name }}');">{{ $bank->name }}</div>
                    @endforeach
                  </div>
                </div>
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
</div>
