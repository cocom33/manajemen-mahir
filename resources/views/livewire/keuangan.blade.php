<div>
    <div class="flex items-center justify-around">
        <div class="text-center">
            <h4 class="text-lg">Pemasukan</h4>
            <p class="text-xl font-bold">{{ number_format($detail->where('status', 'pemasukan')->sum('total')) }}</p>
        </div>
        <div class="text-center">
            <h4 class="text-lg">Pengeluaran</h4>
            <p class="text-xl font-bold">{{ number_format($detail->where('status', 'pengeluaran')->sum('total')) }}</p>
        </div>
        <div class="text-center">
            <h4 class="text-lg">Kas</h4>
            <p class="text-xl font-bold">{{ number_format($kas->where('status', 'pemasukan')->sum('total') - $kas->where('status', 'pengeluaran')->sum('total')) }}</p>
        </div>
    </div>

    <div class="flex flex-col gap-6 p-5 mt-5 md:flex-row intro-y datatable-wrapper box">
        <div class="w-full">
            <label>Tahun</label>
            <div class="mt-2">
                <div class="relative w-full">
                  <div class="flex items-center justify-between w-full py-2 border-2 input" id="divtahun" onclick="showData('listtahun', 'divtahun');" >
                        <span wire:ignore id="tahun">semua</span>
                        <span><i class="fa-solid fa-angle-down"></i></span>
                  </div>
                  <div id="listtahun" class="absolute hidden w-full bg-white border-2">
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
                  <div class="flex items-center justify-between w-full py-2 border-2 input" id="divbulan" onclick="showData('listbulan', 'divbulan');" >
                        <span wire:ignore id="bulan">semua</span>
                        <span><i class="fa-solid fa-angle-down"></i></span>
                  </div>
                  <div id="listbulan" class="absolute hidden w-full bg-white border-2">
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
                  <div class="flex items-center justify-between w-full py-2 border-2 input" id="divbank" onclick="showData('listbank', 'divbank');" >
                        <span wire:ignore id="bank">semua</span>
                        <span><i class="fa-solid fa-angle-down"></i></span>
                  </div>
                  <div id="listbank" class="absolute hidden w-full bg-white border-2">
                    <div wire:model="bank" class="listdata" wire:click="changebank('semua')" onclick="changeText('bank', 'semua');">semua</div>
                    @foreach ($banks as $bank)
                        <div wire:model="bank" class="listdata" wire:click="changebank({{ $bank->id }})" onclick="changeText('bank', '{{ $bank->name }}');">{{ $bank->name }}</div>
                    @endforeach
                  </div>
                </div>
            </div>
        </div>
        <div class="md:mt-8">
            <button wire:click="exportKeuangan()" wire:loading.attr="disabled"><a class="inline-block text-white rounded-md button bg-theme-1">Export</a></button>
        </div>
    </div>

    <div class="p-5 mt-5 intro-y datatable-wrapper box">
        <table class="table w-full table-report table-report--bordered display datatable">
            <thead>
                <tr>
                    <th class="whitespace-no-wrap border-b-2">TITLE</th>
                    <th class="text-center whitespace-no-wrap border-b-2">STATUS</th>
                    <th class="text-center whitespace-no-wrap border-b-2">TOTAL</th>
                    <th class="text-center whitespace-no-wrap border-b-2">BANK</th>
                    <th class="text-center whitespace-no-wrap border-b-2">TANGGAL</th>
                    <th class="whitespace-no-wrap border-b-2">ACTIONS</th>
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
                        <td class="text-center border-b">Rp. {{ number_format($data->total) }}</td>
                        <td class="text-center border-b">{{ $data->bank->name }}</td>
                        <td class="text-center border-b">{{ $data->tanggal }} / {{ $data->keuanganPerusahaan->bulan }} / {{ $data->keuanganPerusahaan->tahun }}</td>
                        <td class="border-b">
                            <div class="flex items-center justify-center gap-2">
                                @if ($data->tagihan_id)
                                    @php
                                        $route = route('tagihan.show', $data->tagihan_id);
                                        if ($data->tagihan && $data->tagihan->project) {
                                            $route = route('project.tagihan.detail', [$data->tagihan->project->slug, $data->tagihan->id]);
                                        }
                                    @endphp
                                    <a href="{{ $route }}"
                                        class="inline-block text-white rounded-md button bg-theme-1">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                @elseif ($data->project_team_fee_id)
                                    <a href="{{ route('project.teams.show', [$data->project_team_fee->projectTeam->project->slug, $data->project_team_fee->project_team_id]) }}"
                                        class="inline-block text-white rounded-md button bg-theme-1">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                @elseif ($data->langsung_id)
                                    <a href="{{ route('project.pemasukan', $data->langsung->keuangan_project->project->slug) }}"
                                        class="inline-block text-white rounded-md button bg-theme-1">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                @elseif ($data->termin_id)
                                    <a href="{{ route('project.pemasukan.termin.detail', [$data->termin->keuangan_project->project->slug, $data->termin->slug]) }}"
                                        class="inline-block text-white rounded-md button bg-theme-1">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                @elseif ($data->pengeluaran_id)
                                    <a href="{{ route('project.pengeluaran.show', [$data->pengeluaran->project->slug, $data->pengeluaran->id]) }}"
                                        class="inline-block text-white rounded-md button bg-theme-1">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                @else
                                    <a href="{{ route('keuangan-umum.edit', $data->id) }}"
                                        class="inline-block text-white rounded-md button bg-theme-9">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="{{ route('keuangan-umum.show', $data->id) }}"
                                        class="inline-block text-white rounded-md button bg-theme-1">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <form method="POST" action="{{ route('keuangan-umum.destroy', $data->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-block rounded-md show-alert-delete-box button text-theme-6 bg-theme-6">
                                            <i class="text-white fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div wire:loading>
</div>
<script>
const selectAll = document.getElementById('select-all');
const checks = document.querySelectorAll('.select');

selectAll.addEventListener('click', () => {
  checks.forEach(ch => {
    ch.checked = selectAll.checked;
  });
})
</script>
