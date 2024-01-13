@extends('layouts.app')

@section('content')
 <!-- BEGIN: Content -->
<x-card title="List Tagihan" >
    <div class="mt-5  intro-y datatable-wrapper box">
        <table class="table w-full table-report table-report--bordered display datatable">
            <thead>
                <tr>
                    <th class="text-center whitespace-no-wrap border-b-2">NAME</th>
                    <th class="text-center whitespace-no-wrap border-b-2">HARGA</th>
                    <th class="text-center whitespace-no-wrap border-b-2">TANGGAL DIBELI</th>
                    <th class="text-center whitespace-no-wrap border-b-2">JATUH TEMPO</th>
                    <th class="text-center whitespace-no-wrap border-b-2">PEMBAYARAN</th>
                    <th class="text-center whitespace-no-wrap border-b-2">STATUS</th>
                    <th class="text-center whitespace-no-wrap border-b-2">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
            @foreach($tagihan as $key => $item)
                <tr>
                    <td class="border-b">
                        <div class="font-medium whitespace-no-wrap">{{ $item->title ?? '' }}</div>
                    </td>

                    <td class="text-center border-b">Rp. {{ number_format($item->harga_jual) }}</td>
                    <td class="text-center border-b">{{ date('d/m/Y', strtotime($item->date_start)) }}</td>
                    <td class="text-center border-b">
                        {{ date('d/m/Y', strtotime($item->date_end)) }}
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
                    <td class="w-5 border-b">
                        <div class="flex items-center sm:justify-center">
                            <div class="flex items-center gap-1 p-2">
                                <a href="{{ route('project.tagihan.detail', [$item->project->slug, $item->id]) }}" class="inline-block text-white shadow-md button bg-theme-1">
                                  <i data-feather="eye" class="w-4 h-4 font-bold "></i>
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
