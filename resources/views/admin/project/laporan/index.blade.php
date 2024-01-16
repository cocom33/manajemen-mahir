@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}" :project="$detail">
        <x-tab-detail page="laporan" slug="{{ $project->slug }}" />
        <div class="mt-5">
            <div class="w-full flex justify-between align-center">
                <h3 class="font-bold text-xl">
                    Laporan Keuangan Project
                </h3>
            </div>

            <div class="mt-8">
                <table class="table table-report table-report--bordered display datatable w-full">
                    <thead>
                        <tr>
                            <th class="border-b-2 text-center whitespace-no-wrap">DETAIL NAME</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">BIAYA</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">TANGGAL PENGELUARAN</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($pengeluaran as $key => $item)
                        <tr>
                            <td class="border-b hidden">
                                <div class="font-medium whitespace-no-wrap"><span class="hidden">{{ $key }}</span>{{ $item->id }}</div>
                            </td>
                            <td class="border-b">
                                <div class="font-medium whitespace-no-wrap">{{ $item->title }}</div>
                            </td>
                            <td class="text-center border-b">
                                @if ($item->tagihan_id)
                                    <div class="font-medium text-xs whitespace-no-wrap">Beli : Rp. {{ number_format($item->tagihan->harga_beli) }}</div>
                                    <div class="font-medium text-xs whitespace-no-wrap">Jual : Rp. {{ number_format($item->tagihan->harga_jual) }}</div>
                                @else
                                    Rp. {{ number_format($item->price) }}
                                @endif
                            </td>
                            <td class="text-center border-b">
                                @if ($item->tagihan_id)
                                    <div class="font-medium whitespace-no-wrap">Tagihan</div>
                                    @if ($item->tagihan->is_lunas == 0)
                                        <span class="text-xs whitespace-no-wrap">status : <span class="text-theme-6">belum lunas</span> </span>
                                    @else
                                        <span class="text-xs whitespace-no-wrap">status : <span class="text-theme-1">lunas</span></span>
                                    @endif
                                @elseif ($item->project_team_fee_id)
                                    Fee Team
                                @else
                                    Pengeluaran
                                @endif
                            </td>
                            <td class="text-center border-b">
                                @if ($item->tagihan_id)
                                    <div class="font-medium text-xs whitespace-no-wrap">Tanggal Beli : {{ date('d M Y', strtotime($item->tagihan->date_start)) }}</div>
                                    <div class="font-medium text-xs whitespace-no-wrap">Jatuh Tempo : {{ date('d M Y', strtotime($item->tagihan->date_end)) }}</div>
                                @else
                                    {{ date('d M Y', strtotime($item->date)) }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-card>
@endsection
