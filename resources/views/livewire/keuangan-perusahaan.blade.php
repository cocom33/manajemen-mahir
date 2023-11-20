<div>
    <div class="intro-y datatable-wrapper box p-5 mt-5 flex gap-6">
        <div class="w-full">
            <label>Tahun</label>
            <div class="mt-2">
                <select data-hide-search="true" class="select2 w-full">
                    <option value="{{ $data->id }}">{{ $data->tahun }}</option>
                </select>
            </div>
        </div>
        <div class="w-full">
            <label>Bulan</label>
            <div class="mt-2">
                <select wire:model="bulan_id" wire:change="filter" data-hide-search="true" class="select2 w-full">
                    @foreach ($data->bulan as $item)
                        <option value="{{ $item->bulan }}"> {{ \Carbon\Carbon::create()->month($item->bulan)->format('F') }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">BULAN</th>
                    <th class="border-b-2 whitespace-no-wrap">DESCRIPTION</th>
                    <th class="border-b-2  whitespace-no-wrap">STATUS</th>
                    <th class="border-b-2  whitespace-no-wrap">TOTAL</th>
                    <th class="border-b-2  whitespace-no-wrap">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($keuanganDetails as $data)
                    <tr>
                        <td class="border-b">{{ \Carbon\Carbon::create()->month($data->keuanganBulanan->bulan)->format('F') }}</td>
                        <td class="border-b">{{ $data->description }}</td>
                        <td class=" border-b">
                            @if ($data->status === 'pemasukan')
                            <div class="flex items-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Pemasukan </div>
                            @else
                            <div class="flex items-center text-theme-6"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Pengeluaran </div>
                            @endif
                        </td>
                        <td class=" border-b">Rp. {{ number_format($data->total, 2, ',', '.') }}</td>
                        <td class="border-b">
                            <div class="flex  items-center">
                                <a class="flex items-center mr-3" href="{{ route('keuangan-perusahaan.edit', $data->id) }}">
                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('keuangan-perusahaan.destroy', $data->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center text-theme-6 show-alert-delete-box" data-toggle="tooltip" title='Delete'><i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div wire:loading>

    </div>
</div>
