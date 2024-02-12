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

    <div class="flex gap-6 p-5 mt-5 intro-y datatable-wrapper box">
        <div class="w-full">
            <label>Tahun</label>
            <div class="mt-2">
                <select class="w-full border-2 input" wire:model="tahun">
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
                <select class="w-full border-2 input" id="select2" wire:model="bulan">
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
                <select class="w-full border-2 input" id="select2" wire:model="bank">
                    <wire:ignore>
                        <option wire:click="changebank('semua')" value="semua" selected>Semua</option>
                        @foreach ($banks as $item)
                            <option wire:click="changebank({{ $item->id }})" value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </wire:ignore>
                </select>
            </div>
        </div>
        <button wire:click="export('xlsx')" wire:loading.attr="disabled">Export</button>
    </div>

    <div class="p-5 mt-5 intro-y datatable-wrapper box">
        <table class="table w-full table-report table-report--bordered display datatable">
            <thead>
                <tr>
                    <th class="whitespace-no-wrap border-b-2">
                        <input type="checkbox" class="form-control" id="select-all">
                    </th>
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
                        <td class="border-b">
                            <input  type="checkbox" class="form-control select" value="{{$data->id}}">
                        </td>
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
