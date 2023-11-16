@extends('layouts.app')
@section('title', 'Keuangan Perusahaan')

@section('content')
 <!-- BEGIN: Content -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Keuangan Perusahaan</h2>
    </div>

    {{-- <div class="intro-y datatable-wrapper box p-5 mt-5 flex gap-6">
        <div class="w-full">
            <label>Tahun</label>
            <div class="mt-2">
                <select  data-hide-search="true" class="select2 w-full">
                    <option value="1">{{ $data->tahun }}</option>
                </select>
            </div>
        </div>
        <div class="w-full">
            <label>Bulan</label>
            <div class="mt-2">
                <select  data-hide-search="true" class="select2 w-full">
                    @foreach ($data->bulan as $item)
                    <option value="{{ $item->bulan }}"> {{ \Carbon\Carbon::create()->month($item->bulan)->format('F') }}</option>
                @endforeach
                </select>
            </div>
        </div>
    </div> --}}
    {{-- <livewire:counter /> --}}
    <livewire:filter-keuangan-perusahaans />

    <!-- BEGIN: Datatable -->
    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <livewire:show-keuangan-perusahaans />
    </div>
    <!-- END: Datatable -->
@endsection
