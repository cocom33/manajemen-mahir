@extends('layouts.app')

@section('content')
    <!-- BEGIN: Content -->
    <div class="grid grid-cols-12 gap-6">
        <div class="grid grid-cols-12 col-span-12 gap-6 xxl:col-span-9">
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
            <div class="col-span-12 mt-8 xl:col-span-6">
                <div class="flex items-center h-10 intro-y">
                    <h2 class="mr-5 text-lg font-medium truncate">
                        List Clients
                    </h2>
                </div>
                <div class="mt-5">
                    <div id="data-wrapper-client">
                        @include('admin.dashboard.components.dataClients')
                    </div>

                    <button
                        class="block w-full py-4 text-center border border-dotted rounded-md intro-y border-theme-15 text-theme-16 load-more-data-client">View
                        More</button>

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
            <div class="col-span-12 mt-8 xl:col-span-6">
                <div class="flex items-center h-10 intro-y">
                    <h2 class="mr-5 text-lg font-medium truncate">
                        List Tagihan
                    </h2>
                </div>
                <div class="mt-5">
                    <div id="data-wrapper-tagihan">
                        @if ($tagihansLoad->count() > 0)
                            @include('admin.dashboard.components.dataTagihans')
                        @else

                        @endif
                    </div>

                    <button @if ($tagihansLoad->count() <= 0) disabled @endif
                        class="block w-full py-4 text-center border border-dotted rounded-md intro-y border-theme-15 text-theme-16 load-more-data-tagihan">@if ($tagihansLoad->count() <= 0) No Data @else View More @endif</button>

                    <!-- Data Loader -->
                    <div class="flex justify-center auto-load-tagihan" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" height="60"><circle fill="#20B7FF" stroke="#20B7FF" stroke-width="15" r="15" cx="40" cy="100"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.4"></animate></circle><circle fill="#20B7FF" stroke="#20B7FF" stroke-width="15" r="15" cx="100" cy="100"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.2"></animate></circle><circle fill="#20B7FF" stroke="#20B7FF" stroke-width="15" r="15" cx="160" cy="100"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="0"></animate></circle></svg>
                    </div>
                </div>
            </div>
            <!-- END: Data Tagihan -->
            <!-- BEGIN: Data Piutang -->
            {{-- <div class="col-span-12 mt-8 xl:col-span-4">
                <div class="flex items-center h-10 intro-y">
                    <h2 class="mr-5 text-lg font-medium truncate">
                        List Piutang
                    </h2>
                </div>
                <div class="mt-5">
                    <div id="data-wrapper-tagihan">
                        @if ($piutangsLoad->count() > 0)
                            @include('admin.dashboard.components.dataPiutangs')
                        @else

                        @endif
                    </div>

                    <button @if ($piutangsLoad->count() <= 0) disabled @endif
                        class="block w-full py-4 text-center border border-dotted rounded-md intro-y border-theme-15 text-theme-16 load-more-data-tagihan">@if ($tagihansLoad->count() <= 0) No Data @else View More @endif</button>

                    <!-- Data Loader -->
                    <div class="flex justify-center auto-load-tagihan" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" height="60"><circle fill="#20B7FF" stroke="#20B7FF" stroke-width="15" r="15" cx="40" cy="100"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.4"></animate></circle><circle fill="#20B7FF" stroke="#20B7FF" stroke-width="15" r="15" cx="100" cy="100"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.2"></animate></circle><circle fill="#20B7FF" stroke="#20B7FF" stroke-width="15" r="15" cx="160" cy="100"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="0"></animate></circle></svg>
                    </div>
                </div>
            </div> --}}
            <!-- END: Data Piutang -->
            <!-- BEGIN: Chart Keuangan -->
            <div class="col-span-12 mt-6 xl:col-span-12">
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
            <!-- BEGIN: General Report -->
            {{-- <div class="grid grid-cols-12 col-span-12 gap-6 mt-8">
                <div class="col-span-12 sm:col-span-6 xxl:col-span-3 intro-y">
                    <div class="p-5 mini-report-chart box zoom-in">
                        <div class="flex items-center">
                            <div class="flex-none w-2/4">
                                <div class="text-lg font-medium truncate">Target Sales</div>
                                <div class="mt-1 text-gray-600">300 Sales</div>
                            </div>
                            <div class="relative flex-none ml-auto">
                                <canvas id="report-donut-chart-1" width="90" height="90"></canvas>
                                <div
                                    class="absolute top-0 left-0 flex items-center justify-center w-full h-full font-medium">
                                    20%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xxl:col-span-3 intro-y">
                    <div class="p-5 mini-report-chart box zoom-in">
                        <div class="flex">
                            <div class="mr-3 text-lg font-medium truncate">Social Media</div>
                            <div
                                class="px-2 py-1 ml-auto text-xs text-gray-600 truncate bg-gray-200 rounded-full cursor-pointer">
                                320 Followers</div>
                        </div>
                        <div class="mt-4">
                            <canvas class="-ml-1 simple-line-chart-1" height="60"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xxl:col-span-3 intro-y">
                    <div class="p-5 mini-report-chart box zoom-in">
                        <div class="flex items-center">
                            <div class="flex-none w-2/4">
                                <div class="text-lg font-medium truncate">New Products</div>
                                <div class="mt-1 text-gray-600">1450 Products</div>
                            </div>
                            <div class="relative flex-none ml-auto">
                                <canvas id="report-donut-chart-2" width="90" height="90"></canvas>
                                <div
                                    class="absolute top-0 left-0 flex items-center justify-center w-full h-full font-medium">
                                    45%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xxl:col-span-3 intro-y">
                    <div class="p-5 mini-report-chart box zoom-in">
                        <div class="flex">
                            <div class="mr-3 text-lg font-medium truncate">Posted Ads</div>
                            <div
                                class="px-2 py-1 ml-auto text-xs text-gray-600 truncate bg-gray-200 rounded-full cursor-pointer">
                                180 Campaign</div>
                        </div>
                        <div class="mt-4">
                            <canvas class="-ml-1 simple-line-chart-1" height="60"></canvas>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- END: General Report -->
            <!-- BEGIN: Weekly Top Seller -->
            {{-- <div class="col-span-12 mt-6">
                <div class="items-center block h-10 intro-y sm:flex">
                    <h2 class="mr-5 text-lg font-medium truncate">
                        Weekly Top Seller
                    </h2>
                    <div class="flex items-center mt-3 sm:ml-auto sm:mt-0">
                        <button class="flex items-center text-gray-700 button box"> <i data-feather="file-text"
                                class="hidden w-4 h-4 mr-2 sm:block"></i> Export to Excel </button>
                        <button class="flex items-center ml-3 text-gray-700 button box"> <i data-feather="file-text"
                                class="hidden w-4 h-4 mr-2 sm:block"></i> Export to PDF </button>
                    </div>
                </div>
                <div class="mt-8 overflow-auto intro-y lg:overflow-visible sm:mt-0">
                    <table class="table table-report sm:mt-2">
                        <thead>
                            <tr>
                                <th class="whitespace-no-wrap">IMAGES</th>
                                <th class="whitespace-no-wrap">PRODUCT NAME</th>
                                <th class="text-center whitespace-no-wrap">STOCK</th>
                                <th class="text-center whitespace-no-wrap">STATUS</th>
                                <th class="text-center whitespace-no-wrap">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="intro-x">
                                <td class="w-40">
                                    <div class="flex">
                                        <div class="w-10 h-10 image-fit zoom-in">
                                            <img alt="Midone Tailwind HTML Admin Template" class="rounded-full tooltip"
                                                src="dist/images/preview-2.jpg" title="Uploaded at 6 August 2022">
                                        </div>
                                        <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                            <img alt="Midone Tailwind HTML Admin Template" class="rounded-full tooltip"
                                                src="dist/images/preview-8.jpg" title="Uploaded at 1 May 2021">
                                        </div>
                                        <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                            <img alt="Midone Tailwind HTML Admin Template" class="rounded-full tooltip"
                                                src="dist/images/preview-11.jpg" title="Uploaded at 10 October 2020">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="" class="font-medium whitespace-no-wrap">Apple MacBook Pro 13</a>
                                    <div class="text-xs text-gray-600 whitespace-no-wrap">PC &amp; Laptop</div>
                                </td>
                                <td class="text-center">77</td>
                                <td class="w-40">
                                    <div class="flex items-center justify-center text-theme-9"> <i
                                            data-feather="check-square" class="w-4 h-4 mr-2"></i> Active </div>
                                </td>
                                <td class="w-56 table-report__action">
                                    <div class="flex items-center justify-center">
                                        <a class="flex items-center mr-3" href=""> <i data-feather="check-square"
                                                class="w-4 h-4 mr-1"></i> Edit </a>
                                        <a class="flex items-center text-theme-6" href=""> <i
                                                data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="intro-x">
                                <td class="w-40">
                                    <div class="flex">
                                        <div class="w-10 h-10 image-fit zoom-in">
                                            <img alt="Midone Tailwind HTML Admin Template" class="rounded-full tooltip"
                                                src="dist/images/preview-7.jpg" title="Uploaded at 21 July 2020">
                                        </div>
                                        <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                            <img alt="Midone Tailwind HTML Admin Template" class="rounded-full tooltip"
                                                src="dist/images/preview-13.jpg" title="Uploaded at 31 December 2021">
                                        </div>
                                        <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                            <img alt="Midone Tailwind HTML Admin Template" class="rounded-full tooltip"
                                                src="dist/images/preview-2.jpg" title="Uploaded at 9 September 2020">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="" class="font-medium whitespace-no-wrap">Dell XPS 13</a>
                                    <div class="text-xs text-gray-600 whitespace-no-wrap">PC &amp; Laptop</div>
                                </td>
                                <td class="text-center">100</td>
                                <td class="w-40">
                                    <div class="flex items-center justify-center text-theme-9"> <i
                                            data-feather="check-square" class="w-4 h-4 mr-2"></i> Active </div>
                                </td>
                                <td class="w-56 table-report__action">
                                    <div class="flex items-center justify-center">
                                        <a class="flex items-center mr-3" href=""> <i data-feather="check-square"
                                                class="w-4 h-4 mr-1"></i> Edit </a>
                                        <a class="flex items-center text-theme-6" href=""> <i
                                                data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="intro-x">
                                <td class="w-40">
                                    <div class="flex">
                                        <div class="w-10 h-10 image-fit zoom-in">
                                            <img alt="Midone Tailwind HTML Admin Template" class="rounded-full tooltip"
                                                src="dist/images/preview-9.jpg" title="Uploaded at 5 January 2021">
                                        </div>
                                        <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                            <img alt="Midone Tailwind HTML Admin Template" class="rounded-full tooltip"
                                                src="dist/images/preview-6.jpg" title="Uploaded at 18 November 2021">
                                        </div>
                                        <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                            <img alt="Midone Tailwind HTML Admin Template" class="rounded-full tooltip"
                                                src="dist/images/preview-13.jpg" title="Uploaded at 1 June 2021">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="" class="font-medium whitespace-no-wrap">Oppo Find X2 Pro</a>
                                    <div class="text-xs text-gray-600 whitespace-no-wrap">Smartphone &amp; Tablet</div>
                                </td>
                                <td class="text-center">50</td>
                                <td class="w-40">
                                    <div class="flex items-center justify-center text-theme-9"> <i
                                            data-feather="check-square" class="w-4 h-4 mr-2"></i> Active </div>
                                </td>
                                <td class="w-56 table-report__action">
                                    <div class="flex items-center justify-center">
                                        <a class="flex items-center mr-3" href=""> <i data-feather="check-square"
                                                class="w-4 h-4 mr-1"></i> Edit </a>
                                        <a class="flex items-center text-theme-6" href=""> <i
                                                data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="intro-x">
                                <td class="w-40">
                                    <div class="flex">
                                        <div class="w-10 h-10 image-fit zoom-in">
                                            <img alt="Midone Tailwind HTML Admin Template" class="rounded-full tooltip"
                                                src="dist/images/preview-11.jpg" title="Uploaded at 22 April 2020">
                                        </div>
                                        <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                            <img alt="Midone Tailwind HTML Admin Template" class="rounded-full tooltip"
                                                src="dist/images/preview-10.jpg" title="Uploaded at 12 December 2020">
                                        </div>
                                        <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                            <img alt="Midone Tailwind HTML Admin Template" class="rounded-full tooltip"
                                                src="dist/images/preview-12.jpg" title="Uploaded at 7 May 2020">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="" class="font-medium whitespace-no-wrap">Apple MacBook Pro 13</a>
                                    <div class="text-xs text-gray-600 whitespace-no-wrap">PC &amp; Laptop</div>
                                </td>
                                <td class="text-center">50</td>
                                <td class="w-40">
                                    <div class="flex items-center justify-center text-theme-9"> <i
                                            data-feather="check-square" class="w-4 h-4 mr-2"></i> Active </div>
                                </td>
                                <td class="w-56 table-report__action">
                                    <div class="flex items-center justify-center">
                                        <a class="flex items-center mr-3" href=""> <i data-feather="check-square"
                                                class="w-4 h-4 mr-1"></i> Edit </a>
                                        <a class="flex items-center text-theme-6" href=""> <i
                                                data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-wrap items-center mt-3 intro-y sm:flex-row sm:flex-no-wrap">
                    <ul class="pagination">
                        <li>
                            <a class="pagination__link" href=""> <i class="w-4 h-4"
                                    data-feather="chevrons-left"></i> </a>
                        </li>
                        <li>
                            <a class="pagination__link" href=""> <i class="w-4 h-4"
                                    data-feather="chevron-left"></i> </a>
                        </li>
                        <li> <a class="pagination__link" href="">...</a> </li>
                        <li> <a class="pagination__link" href="">1</a> </li>
                        <li> <a class="pagination__link pagination__link--active" href="">2</a> </li>
                        <li> <a class="pagination__link" href="">3</a> </li>
                        <li> <a class="pagination__link" href="">...</a> </li>
                        <li>
                            <a class="pagination__link" href=""> <i class="w-4 h-4"
                                    data-feather="chevron-right"></i> </a>
                        </li>
                        <li>
                            <a class="pagination__link" href=""> <i class="w-4 h-4"
                                    data-feather="chevrons-right"></i> </a>
                        </li>
                    </ul>
                    <select class="w-20 mt-3 input box sm:mt-0">
                        <option>10</option>
                        <option>25</option>
                        <option>35</option>
                        <option>50</option>
                    </select>
                </div>
            </div> --}}
            <!-- END: Weekly Top Seller -->
        </div>
        <div class="col-span-12 pb-10 -mb-10 xxl:col-span-3 xxl:border-l border-theme-5">
            <div class="grid grid-cols-12 gap-6 xxl:pl-6">
                <!-- BEGIN: Transactions -->
                <div class="col-span-12 mt-3 md:col-span-6 xl:col-span-4 xxl:col-span-12 xxl:mt-8">
                    <div class="flex items-center h-10 intro-x">
                        <h2 class="mr-5 text-lg font-medium truncate">
                            Transactions
                        </h2>
                    </div>
                    <div class="mt-5">
                        <div class="intro-x">
                            <div class="flex items-center px-5 py-3 mb-3 box zoom-in">
                                <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                    <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-14.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Leonardo DiCaprio</div>
                                    <div class="text-xs text-gray-600">6 August 2022</div>
                                </div>
                                <div class="text-theme-9">+$23</div>
                            </div>
                        </div>
                        <div class="intro-x">
                            <div class="flex items-center px-5 py-3 mb-3 box zoom-in">
                                <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                    <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-10.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Tom Cruise</div>
                                    <div class="text-xs text-gray-600">21 July 2020</div>
                                </div>
                                <div class="text-theme-9">+$83</div>
                            </div>
                        </div>
                        <div class="intro-x">
                            <div class="flex items-center px-5 py-3 mb-3 box zoom-in">
                                <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                    <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-12.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Al Pacino</div>
                                    <div class="text-xs text-gray-600">5 January 2021</div>
                                </div>
                                <div class="text-theme-9">+$199</div>
                            </div>
                        </div>
                        <div class="intro-x">
                            <div class="flex items-center px-5 py-3 mb-3 box zoom-in">
                                <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                    <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-6.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Russell Crowe</div>
                                    <div class="text-xs text-gray-600">22 April 2020</div>
                                </div>
                                <div class="text-theme-9">+$43</div>
                            </div>
                        </div>
                        <div class="intro-x">
                            <div class="flex items-center px-5 py-3 mb-3 box zoom-in">
                                <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                    <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-15.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Al Pacino</div>
                                    <div class="text-xs text-gray-600">8 October 2022</div>
                                </div>
                                <div class="text-theme-9">+$112</div>
                            </div>
                        </div>
                        <a href=""
                            class="block w-full py-3 text-center border border-dotted rounded-md intro-x border-theme-15 text-theme-16">View
                            More</a>
                    </div>
                </div>
                <!-- END: Transactions -->
                <!-- BEGIN: Recent Activities -->
                <div class="col-span-12 mt-3 md:col-span-6 xl:col-span-4 xxl:col-span-12">
                    <div class="flex items-center h-10 intro-x">
                        <h2 class="mr-5 text-lg font-medium truncate">
                            Recent Activities
                        </h2>
                        <a href="" class="ml-auto truncate text-theme-1">See all</a>
                    </div>
                    <div class="relative mt-5 report-timeline">
                        <div class="relative flex items-center mb-3 intro-x">
                            <div class="report-timeline__image">
                                <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                    <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-9.jpg">
                                </div>
                            </div>
                            <div class="flex-1 px-5 py-3 ml-4 box zoom-in">
                                <div class="flex items-center">
                                    <div class="font-medium">Johnny Depp</div>
                                    <div class="ml-auto text-xs text-gray-500">07:00 PM</div>
                                </div>
                                <div class="mt-1 text-gray-600">Has joined the team</div>
                            </div>
                        </div>
                        <div class="relative flex items-center mb-3 intro-x">
                            <div class="report-timeline__image">
                                <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                    <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-10.jpg">
                                </div>
                            </div>
                            <div class="flex-1 px-5 py-3 ml-4 box zoom-in">
                                <div class="flex items-center">
                                    <div class="font-medium">Brad Pitt</div>
                                    <div class="ml-auto text-xs text-gray-500">07:00 PM</div>
                                </div>
                                <div class="text-gray-600">
                                    <div class="mt-1">Added 3 new photos</div>
                                    <div class="flex mt-2">
                                        <div class="w-8 h-8 mr-1 tooltip image-fit zoom-in" title="Apple MacBook Pro 13">
                                            <img alt="Midone Tailwind HTML Admin Template"
                                                class="border border-white rounded-md" src="dist/images/preview-8.jpg">
                                        </div>
                                        <div class="w-8 h-8 mr-1 tooltip image-fit zoom-in" title="Dell XPS 13">
                                            <img alt="Midone Tailwind HTML Admin Template"
                                                class="border border-white rounded-md" src="dist/images/preview-14.jpg">
                                        </div>
                                        <div class="w-8 h-8 mr-1 tooltip image-fit zoom-in" title="Oppo Find X2 Pro">
                                            <img alt="Midone Tailwind HTML Admin Template"
                                                class="border border-white rounded-md" src="dist/images/preview-5.jpg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-4 text-xs text-center text-gray-500 intro-x">12 November</div>
                        <div class="relative flex items-center mb-3 intro-x">
                            <div class="report-timeline__image">
                                <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                    <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-4.jpg">
                                </div>
                            </div>
                            <div class="flex-1 px-5 py-3 ml-4 box zoom-in">
                                <div class="flex items-center">
                                    <div class="font-medium">Al Pacino</div>
                                    <div class="ml-auto text-xs text-gray-500">07:00 PM</div>
                                </div>
                                <div class="mt-1 text-gray-600">Has changed <a class="text-theme-1" href="">Sony
                                        Master Series A9G</a> price and description</div>
                            </div>
                        </div>
                        <div class="relative flex items-center mb-3 intro-x">
                            <div class="report-timeline__image">
                                <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                    <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-12.jpg">
                                </div>
                            </div>
                            <div class="flex-1 px-5 py-3 ml-4 box zoom-in">
                                <div class="flex items-center">
                                    <div class="font-medium">Sylvester Stallone</div>
                                    <div class="ml-auto text-xs text-gray-500">07:00 PM</div>
                                </div>
                                <div class="mt-1 text-gray-600">Has changed <a class="text-theme-1" href="">Sony
                                        Master Series A9G</a> description</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Recent Activities -->
                <!-- BEGIN: Important Notes -->
                <div
                    class="col-span-12 mt-3 md:col-span-6 xl:col-span-12 xxl:col-span-12 xl:col-start-1 xl:row-start-1 xxl:col-start-auto xxl:row-start-auto">
                    <div class="flex items-center h-10 intro-x">
                        <h2 class="mr-auto text-lg font-medium truncate">
                            Important Notes
                        </h2>
                        <button data-carousel="important-notes" data-target="prev"
                            class="flex items-center px-2 mr-2 text-gray-700 border border-gray-400 slick-navigator button">
                            <i data-feather="chevron-left" class="w-4 h-4"></i> </button>
                        <button data-carousel="important-notes" data-target="next"
                            class="flex items-center px-2 text-gray-700 border border-gray-400 slick-navigator button"> <i
                                data-feather="chevron-right" class="w-4 h-4"></i> </button>
                    </div>
                    <div class="mt-5 intro-x">
                        <div class="slick-carousel box zoom-in" id="important-notes">
                            <div class="p-5">
                                <div class="text-base font-medium truncate">Lorem Ipsum is simply dummy text</div>
                                <div class="mt-1 text-gray-500">20 Hours ago</div>
                                <div class="mt-1 text-justify text-gray-600">Lorem Ipsum is simply dummy text of the
                                    printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                    text ever since the 1500s.</div>
                                <div class="flex mt-5 font-medium">
                                    <button type="button" class="text-gray-600 bg-gray-200 button button--sm">View
                                        Notes</button>
                                    <button type="button"
                                        class="ml-auto text-gray-600 border border-gray-300 button button--sm">Dismiss</button>
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="font-medium truncate">Lorem Ipsum is simply dummy text</div>
                                <div class="mt-1 text-gray-500">20 Hours ago</div>
                                <div class="mt-1 text-justify text-gray-600">Lorem Ipsum is simply dummy text of the
                                    printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                    text ever since the 1500s.</div>
                                <div class="flex mt-5 font-medium">
                                    <button type="button" class="text-gray-600 bg-gray-200 button button--sm">View
                                        Notes</button>
                                    <button type="button"
                                        class="ml-auto text-gray-600 border border-gray-300 button button--sm">Dismiss</button>
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="font-medium truncate">Lorem Ipsum is simply dummy text</div>
                                <div class="mt-1 text-gray-500">20 Hours ago</div>
                                <div class="mt-1 text-justify text-gray-600">Lorem Ipsum is simply dummy text of the
                                    printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                    text ever since the 1500s.</div>
                                <div class="flex mt-5 font-medium">
                                    <button type="button" class="text-gray-600 bg-gray-200 button button--sm">View
                                        Notes</button>
                                    <button type="button"
                                        class="ml-auto text-gray-600 border border-gray-300 button button--sm">Dismiss</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Important Notes -->
                <!-- BEGIN: Schedules -->
                <div
                    class="col-span-12 mt-3 md:col-span-6 xl:col-span-4 xxl:col-span-12 xl:col-start-1 xl:row-start-2 xxl:col-start-auto xxl:row-start-auto">
                    <div class="flex items-center h-10 intro-x">
                        <h2 class="mr-5 text-lg font-medium truncate">
                            Schedules
                        </h2>
                        <a href="" class="flex items-center ml-auto truncate text-theme-1"> <i data-feather="plus"
                                class="w-4 h-4 mr-1"></i> Add New Schedules </a>
                    </div>
                    <div class="mt-5">
                        <div class="intro-x box">
                            <div class="p-5">
                                <div class="flex">
                                    <i data-feather="chevron-left" class="w-5 h-5 text-gray-600"></i>
                                    <div class="mx-auto font-medium">April</div>
                                    <i data-feather="chevron-right" class="w-5 h-5 text-gray-600"></i>
                                </div>
                                <div class="grid grid-cols-7 gap-4 mt-5 text-center">
                                    <div class="font-medium">Su</div>
                                    <div class="font-medium">Mo</div>
                                    <div class="font-medium">Tu</div>
                                    <div class="font-medium">We</div>
                                    <div class="font-medium">Th</div>
                                    <div class="font-medium">Fr</div>
                                    <div class="font-medium">Sa</div>
                                    <div class="relative py-1 text-gray-600 rounded">29</div>
                                    <div class="relative py-1 text-gray-600 rounded">30</div>
                                    <div class="relative py-1 text-gray-600 rounded">31</div>
                                    <div class="relative py-1 rounded">1</div>
                                    <div class="relative py-1 rounded">2</div>
                                    <div class="relative py-1 rounded">3</div>
                                    <div class="relative py-1 rounded">4</div>
                                    <div class="relative py-1 rounded">5</div>
                                    <div class="relative py-1 rounded bg-theme-18">6</div>
                                    <div class="relative py-1 rounded">7</div>
                                    <div class="relative py-1 text-white rounded bg-theme-1">8</div>
                                    <div class="relative py-1 rounded">9</div>
                                    <div class="relative py-1 rounded">10</div>
                                    <div class="relative py-1 rounded">11</div>
                                    <div class="relative py-1 rounded">12</div>
                                    <div class="relative py-1 rounded">13</div>
                                    <div class="relative py-1 rounded">14</div>
                                    <div class="relative py-1 rounded">15</div>
                                    <div class="relative py-1 rounded">16</div>
                                    <div class="relative py-1 rounded">17</div>
                                    <div class="relative py-1 rounded">18</div>
                                    <div class="relative py-1 rounded">19</div>
                                    <div class="relative py-1 rounded">20</div>
                                    <div class="relative py-1 rounded">21</div>
                                    <div class="relative py-1 rounded">22</div>
                                    <div class="relative py-1 rounded bg-theme-17">23</div>
                                    <div class="relative py-1 rounded">24</div>
                                    <div class="relative py-1 rounded">25</div>
                                    <div class="relative py-1 rounded">26</div>
                                    <div class="relative py-1 rounded bg-theme-14">27</div>
                                    <div class="relative py-1 rounded">28</div>
                                    <div class="relative py-1 rounded">29</div>
                                    <div class="relative py-1 rounded">30</div>
                                    <div class="relative py-1 text-gray-600 rounded">1</div>
                                    <div class="relative py-1 text-gray-600 rounded">2</div>
                                    <div class="relative py-1 text-gray-600 rounded">3</div>
                                    <div class="relative py-1 text-gray-600 rounded">4</div>
                                    <div class="relative py-1 text-gray-600 rounded">5</div>
                                    <div class="relative py-1 text-gray-600 rounded">6</div>
                                    <div class="relative py-1 text-gray-600 rounded">7</div>
                                    <div class="relative py-1 text-gray-600 rounded">8</div>
                                    <div class="relative py-1 text-gray-600 rounded">9</div>
                                </div>
                            </div>
                            <div class="p-5 border-t border-gray-200">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 mr-3 rounded-full bg-theme-11"></div>
                                    <span class="truncate">UI/UX Workshop</span>
                                    <div class="flex-1 h-px mx-3 border border-r border-gray-300 border-dashed xl:hidden">
                                    </div>
                                    <span class="font-medium xl:ml-auto">23th</span>
                                </div>
                                <div class="flex items-center mt-4">
                                    <div class="w-2 h-2 mr-3 rounded-full bg-theme-1"></div>
                                    <span class="truncate">VueJs Frontend Development</span>
                                    <div class="flex-1 h-px mx-3 border border-r border-gray-300 border-dashed xl:hidden">
                                    </div>
                                    <span class="font-medium xl:ml-auto">10th</span>
                                </div>
                                <div class="flex items-center mt-4">
                                    <div class="w-2 h-2 mr-3 rounded-full bg-theme-12"></div>
                                    <span class="truncate">Laravel Rest API</span>
                                    <div class="flex-1 h-px mx-3 border border-r border-gray-300 border-dashed xl:hidden">
                                    </div>
                                    <span class="font-medium xl:ml-auto">31th</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Schedules -->
            </div>
        </div>
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
