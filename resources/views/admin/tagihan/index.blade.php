@extends('layouts.app')

@section('content')
 <!-- BEGIN: Content -->

<x-card title="Tagihan List" >
    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2 text-center whitespace-no-wrap">NAME</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">HARGA</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">TANGGAL DIBELI</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">JATUH TEMPO</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">PEMBAYARAN</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
            @foreach($tagihan as $key => $item)
                <tr>
                    <td class="border-b">
                        <div class="font-medium whitespace-no-wrap">{{ $item->title ?? '' }}</div>
                    </td>

                    <td class="text-center border-b">Rp. {{ number_format($item->harga_asli) }}</td>
                    <td class="text-center border-b">{{ date('d/m/Y', strtotime($item->date_start)) }}</td>
                    @php
                        switch ($item->date_type) {
                            case 'year':
                                $tempo[$key] = date('d/m/Y', strtotime('+'. $item->date .' year', strtotime($item->date_start)));
                                break;
                            case 'month':
                                $tempo[$key] = date('d/m/Y', strtotime('+'. $item->date .' month', strtotime($item->date_start)));
                                break;
                            case 'week':
                                $tempo[$key] = date('d/m/Y', strtotime('+'. $item->date .' week', strtotime($item->date_start)));
                                break;
                            case 'day':
                                $tempo[$key] = date('d/m/Y', strtotime('+'. $item->date .' day', strtotime($item->date_start)));
                                break;
                        }
                    @endphp
                    <td class="text-center border-b">
                        {{ $tempo[$key] }}
                    </td>
                    <td class="text-center border-b">
                        @if ($item->is_lunas == 1)
                            <span class="text-theme-1">Lunas</span>
                        @else
                            <span class="text-theme-6">Belum Lunas</span>
                        @endif
                    </td>
                    <td class="text-center border-b">
                        @if ($item->is_active == 1)
                            <span class="text-theme-1">Aktif</span>
                        @else
                            <span class="text-theme-6">Tidak Aktif</span>
                        @endif
                    </td>
                    <td class="border-b w-5">
                        <div class="flex sm:justify-center items-center">
                            <div class="p-2 flex items-center gap-1">
                                <a href="{{ route('project.tagihan.detail', [$item->project->slug, $item->id]) }}" class="button inline-block text-white bg-theme-1 shadow-md">
                                  <i data-feather="eye" class=" w-4 h-4 font-bold"></i>
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-card>


<!-- END: Content -->
@endsection
