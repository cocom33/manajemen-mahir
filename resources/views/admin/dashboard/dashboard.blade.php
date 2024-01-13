@extends('layouts.app')

@section('content')
    <!-- BEGIN: Content -->
    <div class="">
        <div class="grid grid-cols-12 col-span-12 gap-6 xxl:col-span-12">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="flex items-center h-10 intro-y">
                    <h2 class="mr-5 text-lg font-medium truncate">
                        General Report
                    </h2>
                    <a href="" class="flex ml-auto text-theme-1"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i>
                        Reload Data </a>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="p-5 box">
                                <div class="flex">
                                    <i data-feather="user" class="report-box__icon text-theme-10"></i>
                                </div>
                                <div class="mt-6 text-3xl font-bold leading-8">{{ $clients->count() }}</div>
                                <div class="mt-1 text-base text-gray-600">Total Client</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="p-5 box">
                                <div class="flex">
                                    <i data-feather="briefcase" class="report-box__icon text-theme-11"></i>
                                </div>
                                <div class="mt-6 text-3xl font-bold leading-8">{{ $projects->count() }}</div>
                                <div class="mt-1 text-base text-gray-600">Total Project</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="p-5 box">
                                <div class="flex">
                                    <i data-feather="users" class="report-box__icon text-theme-12"></i>
                                </div>
                                <div class="mt-6 text-3xl font-bold leading-8">{{ $teams->count() }}</div>
                                <div class="mt-1 text-base text-gray-600">Total Team</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="p-5 box">
                                <div class="flex">
                                    <i data-feather="user" class="report-box__icon text-theme-9"></i>
                                </div>
                                <div class="mt-6 text-3xl font-bold leading-8">-</div>
                                <div class="mt-1 text-base text-gray-600">-</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: General Report -->
            <!-- BEGIN: Weekly Best Sellers -->
            <div class="col-span-12 mt-8 xl:col-span-4">
                <div class="flex items-center h-10 intro-y">
                    <h2 class="mr-5 text-lg font-medium truncate">
                        List Client
                    </h2>
                </div>
                <div class="mt-5">
                    <div id="data-wrapper-client">
                        @if ($clientsLoad->count() > 0)
                            @include('admin.dashboard.components.dataClients')
                        @endif
                    </div>

                    <button @if ($clientsLoad->count() <= 0) disabled @endif
                        class="block w-full py-4 text-center border border-dotted rounded-md intro-y border-theme-15 text-theme-16 load-more-data-client">@if ($clientsLoad->count() <= 0) Tidak Ada Data @else View More @endif</button>

                    <!-- Data Loader -->
                    <div class="flex justify-center auto-load-client" style="display: none;">
                        <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="60" viewBox="0 0 100 100"
                            enable-background="new 0 0 0 0" xml:space="preserve">
                            <path fill="#000"
                                d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                <animateTransform attributeName="transform" attributeType="XML" type="rotate"
                                    dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <!-- END: Weekly Best Sellers -->
            <!-- BEGIN: Data Tagihan -->
            <div class="col-span-12 mt-8 xl:col-span-4">
                <div class="flex items-center h-10 intro-y">
                    <h2 class="mr-5 text-lg font-medium truncate">
                        List Tagihan
                    </h2>
                </div>
                <div class="mt-5">
                    <div id="data-wrapper-tagihan">
                        @if ($tagihansLoad->count() > 0)
                            @include('admin.dashboard.components.dataTagihans')
                        @endif
                    </div>

                    <button @if ($tagihansLoad->count() <= 0) disabled @endif
                        class="block w-full py-4 text-center border border-dotted rounded-md intro-y border-theme-15 text-theme-16 load-more-data-tagihan">@if ($tagihansLoad->count() <= 0) Tidak Ada Data @else View More @endif</button>

                    <!-- Data Loader -->
                    <div class="flex justify-center auto-load-tagihan" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" height="60"><circle fill="#20B7FF" stroke="#20B7FF" stroke-width="15" r="15" cx="40" cy="100"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.4"></animate></circle><circle fill="#20B7FF" stroke="#20B7FF" stroke-width="15" r="15" cx="100" cy="100"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.2"></animate></circle><circle fill="#20B7FF" stroke="#20B7FF" stroke-width="15" r="15" cx="160" cy="100"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="0"></animate></circle></svg>
                    </div>
                </div>
            </div>
            <!-- END: Data Tagihan -->
            <!-- BEGIN: Data Piutang -->
            <div class="col-span-12 mt-8 xl:col-span-4">
                <div class="flex items-center h-10 intro-y">
                    <h2 class="mr-5 text-lg font-medium truncate">
                        List Piutang
                    </h2>
                </div>
                <div class="mt-5">
                    <div id="data-wrapper-piutang">
                        @if ($piutangsLoad->count() > 0)
                            @include('admin.dashboard.components.dataPiutangs')
                        @endif
                    </div>

                    <button @if ($piutangsLoad->count() <= 0) disabled @endif
                        class="block w-full py-4 text-center border border-dotted rounded-md intro-y border-theme-15 text-theme-16 load-more-data-piutang">@if ($piutangsLoad->count() <= 0) Tidak Ada Data @else View More @endif</button>

                    <!-- Data Loader -->
                    <div class="flex justify-center auto-load-piutang" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" height="60"><circle fill="#20B7FF" stroke="#20B7FF" stroke-width="15" r="15" cx="40" cy="100"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.4"></animate></circle><circle fill="#20B7FF" stroke="#20B7FF" stroke-width="15" r="15" cx="100" cy="100"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.2"></animate></circle><circle fill="#20B7FF" stroke="#20B7FF" stroke-width="15" r="15" cx="160" cy="100"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="0"></animate></circle></svg>
                    </div>
                </div>
            </div>
            <!-- END: Data Piutang -->
        </div>
        <!-- BEGIN: Chart Keuangan -->
        <div class="col-span-12 mt-6">
            <div class="items-center block h-10 intro-y sm:flex">
                <h2 class="mr-5 text-lg font-medium truncate">
                    Keuangan Umum
                </h2>
                <div class="flex items-center mt-3 sm:ml-auto sm:mt-0">
                    <a href="{{ route('keuangan-umum.index') }}"><button class="flex items-center text-gray-700 button box"> <i data-feather="file-text"
                            class="hidden w-4 h-4 mr-2 sm:block"></i> Detail Keuangan </button></a>
                </div>
            </div>
            <div class="p-5 mt-12 intro-y box sm:mt-5">
                <canvas id="pengeluaranPemasukan"></canvas>
            </div>
        </div>
        <!-- END: Chart Keuangan -->
    </div>
    <!-- END: Content -->
@endsection

@push('scripts')`
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Skrip untuk memuat data client -->
    <script>
        var CLIENT_ENDPOINT = "{{ route('dashboard') }}";
        var clientPage = 1;

        $(".load-more-data-client").click(function() {
            clientPage++;
            loadMoreDataClient(clientPage, CLIENT_ENDPOINT, 'client', '.auto-load-client', '#data-wrapper-client');
        });

        function loadMoreDataClient(page, endpoint, dataType, autoLoadClass, dataWrapperId) {
            $.ajax({
                    url: endpoint + "?page=" + page,
                    datatype: dataType,
                    type: "get",
                    beforeSend: function() {
                        $(autoLoadClass).show();
                    }
                })
                .done(function(response) {
                    if (response[dataType] == '') {
                        iziToast.error({
                            title: 'List Client',
                            position: 'topRight',
                            message: 'Tidak ada lagi data client yang tersedia :(',
                        });
                        $(autoLoadClass).hide();
                        return;
                    }
                    $(autoLoadClass).hide();
                    $(dataWrapperId).append(response[dataType]);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occurred');
                });
        }
    </script>

    <!-- Skrip untuk memuat data tagihan -->
    <script>
        var TAGIHAN_ENDPOINT = "{{ route('dashboard') }}";
        var tagihanPage = 1;

        $(".load-more-data-tagihan").click(function() {
            tagihanPage++;
            loadMoreDataTagihan(tagihanPage, TAGIHAN_ENDPOINT, 'tagihan', '.auto-load-tagihan', '#data-wrapper-tagihan');
        });

        function loadMoreDataTagihan(page, endpoint, dataType, autoLoadClass, dataWrapperId) {
            $.ajax({
                    url: endpoint + "?page=" + page,
                    datatype: dataType,
                    type: "get",
                    beforeSend: function() {
                        $(autoLoadClass).show();
                    }
                })
                .done(function(response) {
                    if (response[dataType] == '') {
                        iziToast.error({
                            title: 'List Tagihan',
                            position: 'topRight',
                            message: 'Tidak ada lagi data tagihan yang tersedia :(',
                        });
                        $(autoLoadClass).hide();
                        return;
                    }
                    $(autoLoadClass).hide();
                    $(dataWrapperId).append(response[dataType]);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occurred');
                });
        }
    </script>

    <!-- Skrip untuk memuat data tagihan -->
    <script>
        var PIUTANG_ENDPOINT = "{{ route('dashboard') }}";
        var piutangPage = 1;

        $(".load-more-data-piutang").click(function() {
            piutangPage++;
            loadMoreDataPiutang(piutangPage, PIUTANG_ENDPOINT, 'piutang', '.auto-load-piutang', '#data-wrapper-piutang');
        });

        function loadMoreDataPiutang(page, endpoint, dataType, autoLoadClass, dataWrapperId) {
            $.ajax({
                    url: endpoint + "?page=" + page,
                    datatype: dataType,
                    type: "get",
                    beforeSend: function() {
                        $(autoLoadClass).show();
                    }
                })
                .done(function(response) {
                    if (response[dataType] == '') {
                        iziToast.error({
                            title: 'List Piutang',
                            position: 'topRight',
                            message: 'Tidak ada lagi data piutang yang tersedia :(',
                        });
                        $(autoLoadClass).hide();
                        return;
                    }
                    $(autoLoadClass).hide();
                    $(dataWrapperId).append(response[dataType]);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occurred');
                });
        }
    </script>

    <script>
        const ctx = document.getElementById('pengeluaranPemasukan');

        new Chart(ctx, {
            type: 'line',
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
