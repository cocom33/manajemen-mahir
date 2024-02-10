@extends('layouts.app')
@section('title', 'Keuangan Perusahaan')

@push('styles')
    <style>
        option {
            font-family: 'Roboto' !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
    <!-- BEGIN: Content -->
    <div class="flex flex-wrap items-center justify-between col-span-12 mt-5 mb-10 intro-y space-around sm:flex-no-wrap">
        <b class="text-xl">Keuangan Perusahaan</b>
        <div class="flex">
            <div class="relative mr-2 dropdown">
                <button class="px-2 text-gray-700 dropdown-toggle button box">
                    <span class="flex items-center justify-center w-5 h-5"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                </button>
                <div class="absolute top-0 left-0 z-20 w-40 mt-10 dropdown-box">
                    <div class="p-2 dropdown-box__content box">
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white rounded-md hover:bg-gray-200"> <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print </a>
                        <form method="GET" action="{{ url('/export-excel') }}">
                            <button class="submit">
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white rounded-md   hover:bg-gray-200"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                            </button>
                        </form>
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white rounded-md hover:bg-gray-200"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to CSV </a>
                    </div>
                </div>
            </div>
            <a href="{{route('keuangan-umum.create')}}"><button class="text-white shadow-md button bg-theme-1 ">Add New</button></a>
        </div>
    </div>

    <div class="p-5 mt-5 intro-y datatable-wrapper box">
        <livewire:keuangan />
    </div>

    <div class="mt-10">
        <div class="items-center block h-10 intro-y sm:flex">
            <h2 class="mr-5 text-lg font-medium truncate">
                Chart Keuangan
            </h2>
            <div class="flex items-center gap-3 mt-3 sm:ml-auto sm:mt-0">
                <form method="get" action="{{ route('keuangan-umum.index', $request) }}">
                    <select name="year" id="year" class="w-full select2">
                        <option value="" selected disabled>Filter Tahun</option>
                        @for ($i = date('Y'); $i >= 2023; $i--)
                            <option value="{{ $i }}" {{ $i == request('year') ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="text-white shadow-md w-19 button bg-theme-7">Filter</button>
                </form>
            </div>
        </div>
        <div class="p-5 mt-12 intro-y box sm:mt-5">
            <canvas id="pengeluaranPemasukan"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('pengeluaranPemasukan');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: {!! json_encode($datasets) !!}
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
