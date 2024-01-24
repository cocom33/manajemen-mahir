@extends('layouts.app')

@section('content')
 <!-- BEGIN: Content -->
<x-card title="List Tagihan" route="{{ route('tagihan.create') }}">
    <div class="p-5 mt-5 intro-y datatable-wrapper box">
        <table class="table w-full table-report table-report--bordered display datatable">
            <thead>
                <tr>
                    <th class="whitespace-no-wrap border-b-2">NAME</th>
                    <th class="text-center whitespace-no-wrap border-b-2">Type</th>
                    <th class="text-center whitespace-no-wrap border-b-2">HARGA</th>
                    {{-- <th class="text-center whitespace-no-wrap border-b-2">TANGGAL DIBELI</th> --}}
                    <th class="text-center whitespace-no-wrap border-b-2">JATUH TEMPO</th>
                    <th class="text-center whitespace-no-wrap border-b-2">PEMBAYARAN</th>
                    <th class="text-center whitespace-no-wrap border-b-2">STATUS</th>
                    <th class="text-center whitespace-no-wrap border-b-2">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tagihan as $key => $item)
                    <tr>
                        {{-- <td class="hidden border-b">
                            <div class="font-medium whitespace-no-wrap">{{ $item->id }}</div>
                        </td> --}}
                        <td class="border-b">
                            <div class="font-medium whitespace-no-wrap">{{ $item->title }}</div>
                        </td>
                        <td class="text-center border-b">
                            @if ($item->project_id)
                                <div class="text-xs font-medium whitespace-no-wrap">
                                    Project <br>{{ explode(" ", $item->title)[0] }} {{ explode(" ", $item->title)[1] }}
                                </div>
                            @elseif ($item->client_id)
                                <div class="text-xs font-medium whitespace-no-wrap">
                                    Client <br> {{ $item->client->name }}
                                </div>
                            @endif
                        </td>

                        <td class="text-center border-b">
                            {{-- Rp. {{ number_format($item->harga_beli) }} --}}

                            <div class="text-xs font-medium whitespace-no-wrap">Beli : Rp. {{ number_format($item->harga_beli) }}</div>
                            <div class="text-xs font-medium whitespace-no-wrap">Jual : Rp. {{ number_format($item->harga_jual) }}</div>
                        </td>
                        {{-- <td class="text-center border-b">{{ date('d / m / Y', strtotime($item->date_start)) }}</td> --}}
                        <td class="text-center border-b">
                            {{ date('d / m / Y', strtotime($item->date_end)) }}
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
                                    @php
                                        $route = route('tagihan.show', $item->id);
                                        if ($item->project_id) {
                                            $route = route('project.tagihan.detail', [$item->project->slug, $item->id]);
                                        }
                                    @endphp
                                    <a href="{{ $route }}" class="inline-block text-white shadow-md button bg-theme-1">
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
