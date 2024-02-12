@extends('layouts.app')
@section('title', 'Keuangan Perusahaan')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        option {
            font-family: 'Roboto' !important;
        }

        .listdata {
            padding: 0.25rem 0.75rem;
            cursor: pointer;
            z-index: 999;
        }
        .listdata:hover {
            color: white;
            background-color: rgb(28,63,170);
        }
    </style>

@endpush

@section('content')
    <!-- BEGIN: Content -->
    <div class="flex flex-wrap items-center justify-between col-span-12 mt-5 mb-10 intro-y space-around sm:flex-no-wrap">
        <b class="text-xl">Keuangan Perusahaan</b>
        <div class="flex">
            <a href="{{route('keuangan-umum.create')}}"><button class="text-white shadow-md button bg-theme-1 ">Add New</button></a>
        </div>
    </div>

    <div class="p-5 mt-5 intro-y datatable-wrapper box">
        <livewire:keuangan />
    </div>

    <div class="mt-10">
        <div class="items-center block p-4 bg-gray-200 md:h-20 intro-y sm:flex" style="z-index: 20">
            <h2 class="mr-5 text-lg font-medium truncate">
                Chart Keuangan
            </h2>
            <div class="flex items-center gap-3 mt-3 sm:ml-auto sm:mt-0">
                    <form method="get" class="flex gap-3" action="{{ route('dashboard', $request) }}">
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
        <div class="p-5 mt-12 intro-y box sm:mt-5" style="z-index: 20">
            <canvas id="pengeluaranPemasukan"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
  <script>
    function changeText(id, text) {
        id = document.getElementById(id);
        id.innerHTML = text;
    }
    function showData(id, parent) {
        document.getElementById(id).classList.toggle('hidden');
        document.getElementById(parent).classList.toggle('border-blue-300');
    }
    function removeHover(id, classFriend) {
        parent = document.getElementById(id);
        friend = document.getElementsByClassName(classFriend);
        friend[0].classList.remove('border-blue-300');
        friend[1].classList.remove('border-blue-300');
        parent.classList.add('border-blue-300');
    }
  </script>

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
