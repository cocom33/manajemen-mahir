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
                @if ($project->keuangan_project)
                    <div class="flex">
                        <div class="mr-3">
                            <p class="font-bold text-lg">Pemasukan</p>
                            <p class="font-bold text-lg">Pengeluaran</p>
                            <p class="font-bold text-lg">Total</p>
                        </div>
                        <div>
                            {{-- $project->tagihan->where('is_lunas', 1)->sum('harga_jual') --}}
                            @if($project->keuangan_project->type == 'termin')
                                <p class="font-bold text-lg">: Rp. {{ number_format($project->keuangan_project->termin->where('status', 1)->sum('price')) }}</p>
                            @elseif($project->keuangan_project->type == 'langsung')
                                <p class="font-bold text-lg">: Rp. {{ number_format($project->keuangan_project->langsung->where('status', 1)->sum('price')) }}</p>
                            @else
                                <p class="font-bold text-lg">: 0</p>
                            @endif

                            <p class="font-bold text-lg">: Rp. {{ number_format($pengeluaran->sum('price')) }}</p>

                            @if($project->keuangan_project->type == 'termin')
                                <p class="font-bold text-lg">: Rp. {{ number_format($project->keuangan_project->termin->where('status', 1)->sum('price') - $pengeluaran->sum('price')) }}</p>
                            @elseif($project->keuangan_project->type == 'langsung')
                                <p class="font-bold text-lg">: Rp. {{ number_format($project->keuangan_project->langsung->where('status', 1)->sum('price') - $pengeluaran->sum('price')) }}</p>
                            @else
                                <p class="font-bold text-lg">: 0</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-8">
                <h2 class="font-semibold text-lg">Pemasukan</h2>
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
                    @if ($project->keuangan_project)
                        @if ($project->keuangan_project->type == 'termin')
                            @foreach($project->keuangan_project->termin as $key => $item)
                                <tr>
                                    <td class="border-b">
                                        <div class="font-medium whitespace-no-wrap">{{ $item->name }}</div>
                                    </td>
                                    <td class="text-center border-b">
                                        Rp. {{ number_format($item->price) }}
                                    </td>
                                    <td class="text-center border-b">
                                        <span class="whitespace-no-wrap">
                                            @if ($item->status == 1)
                                                <span class="text-theme-1">
                                                    Lunas
                                                </span>
                                            @else
                                                <span class="text-theme-6">
                                                Belum Lunas
                                                </span>
                                            @endif
                                        </span>
                                    </td>
                                    <td class="text-center border-b">
                                        {{ date('d M Y', strtotime($item->tanggal)) }}
                                    </td>
                                </tr>
                            @endforeach
                        @elseif ($project->keuangan_project->type == 'langsung')
                            <tr>
                                <td class="border-b">
                                    <div class="font-medium whitespace-no-wrap">Piutang</div>
                                </td>
                                <td class="text-center border-b">
                                    Rp. {{ number_format($project->keuangan_project->langsung->price) }}
                                </td>
                                <td class="text-center border-b">
                                    <span class="whitespace-no-wrap text-theme-1">lunas</span>
                                </td>
                                <td class="text-center border-b">
                                       {{ date('d M Y', strtotime($project->keuangan_project->langsung->created_at)) }}
                                </td>
                            </tr>
                        @endif
                    @endif
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                <h2 class="font-semibold text-lg">Pengeluaran</h2>
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
                            <td class="border-b">
                                <div class="font-medium whitespace-no-wrap"><span class="hidden">{{ $key }}</span>{{ $item->title }}</div>
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
                                    <div class="font-medium">
                                        Fee Team
                                    </div>
                                @else
                                    <div class="font-medium">
                                        Pengeluaran
                                    </div>
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
