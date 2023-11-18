<div>
    <table class="table table-report table-report--bordered display datatable w-full">
        <thead>
            <tr>
                <th class="border-b-2 whitespace-no-wrap">BULAN</th>
                <th class="border-b-2 whitespace-no-wrap">DESCRIPTION</th>
                <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                <th class="border-b-2 text-center whitespace-no-wrap">TOTAL</th>
                <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($keuanganDetails as $data)
                <tr>
                    <td class="border-b">{{ \Carbon\Carbon::create()->month($data->keuanganBulanan->bulan)->format('F') }}</td>
                    <td class="border-b">{{ $data->description }}</td>
                    <td class="text-center border-b">
                        @if ($data->status === 'pemasukan')
                        <div class="flex items-center sm:justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Pemasukan </div>
                        @else
                        <div class="flex items-center sm:justify-center text-theme-6"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Pengeluaran </div>
                        @endif
                    </td>
                    <td class="text-center border-b">Rp. {{ number_format($data->total, 2, ',', '.') }}</td>
                    <td class="border-b">
                        <div class="flex sm:justify-center items-center">
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
            {{-- @foreach ($keuanganBulanans as $data)
    @foreach ($data->keuanganDetails as $detail)
        {{ $detail->nama_field_yang_ingin_ditampilkan }}
        @if ($detail->keuanganBulanan)
            Bulan: {{ $detail->keuanganBulanan->bulan }}
        @else
            Bulan tidak tersedia
        @endif
    @endforeach
@endforeach --}}
        </tbody>
    </table>
</div>
