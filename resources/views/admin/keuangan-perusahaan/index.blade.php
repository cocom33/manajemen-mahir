@extends('layouts.app')
@section('title', 'Keuangan Perusahaan')

@section('content')
    <!-- BEGIN: Content -->
    <div class="intro-y space-around col-span-12 flex flex-wrap sm:flex-no-wrap items-center justify-between mt-5 mb-10">
        <b class="text-xl">Keuangan Perusahaan</b>
        <div class="flex">
            <div class="dropdown relative mr-2">
                <button class="dropdown-toggle button px-2 box text-gray-700">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                </button>
                <div class="dropdown-box mt-10 absolute w-40 top-0 left-0 z-20">
                    <div class="dropdown-box__content box p-2">
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print </a>
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </a>
                    </div>
                </div>
            </div>
            <a href="{{route('keuangan-perusahaan.create')}}"><button class="button text-white bg-theme-1 shadow-md ">Add New</button></a>
        </div>
    </div>

    {{-- <livewire:filter-keuangan-perusahaans />
    <livewire:show-keuangan-perusahaans /> --}}
    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <livewire:keuangan-perusahaans-table/>
    </div>

@endsection
