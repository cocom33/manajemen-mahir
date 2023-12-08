@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}" :project="$detail">
        <x-tab-detail page="invoice" slug="{{ $project->slug }}" />
        @if ($invoice == null)
        <form action="{{ route('project.invoice.store', $project->slug) }}" method="POST" class="mt-5">
            @csrf
            <div class="mb-5">
                <label>Type</label>
                <div class="mt-2">
                    <select name="type" data-hide-search="true" class="select2 w-full">
                        <option selected disabled>Pilih Tipe</option>
                        <option value="system">System</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            <button class="button w-32 mr-2 mb-2 flex items-center justify-center bg-theme-1 text-white">
                <i data-feather="printer" class="w-4 h-4 mr-2"></i> Invoice
            </button>
        </form>
        @else
            @if ($invoice->type == 'system')
            <a href="{{ route('project.invoice.stream', [$project->slug, $invoice->id]) }}" target="__blank">
                <button class="button w-44 mr-2 mb-2 mt-10 flex items-center justify-center bg-theme-1 text-white"> <i data-feather="printer" class="w-4 h-4 mr-2"></i>
                    Invoice System
                </button>
            </a>
            @else
            <a href="{{ route('project.invoice.stream', [$project->slug, $invoice->id]) }}" target="__blank">
                <button class="button w-44 mr-2 mb-2 mt-10 flex items-center justify-center bg-theme-1 text-white"> <i data-feather="printer" class="w-4 h-4 mr-2"></i>
                    Invoice Other
                </button>
            </a>
            @endif
        @endif
        <div class="mt-5">
            @if ($invoice)
                <div class="w-full flex justify-between align-center">
                    <h3 class="font-bold text-xl">
                        Invoice {{ $invoice->type == 'system' ? 'Pembuatan System' : '' }}
                    </h3>
                    <div>
                        @if ($invoice->type == 'system')
                            <button class="button flex align-center text-white bg-theme-1 shadow-md" onclick="formSystem()">
                                <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span> Tambah Detail Invoice</span>
                            </button>
                        @else
                            <button class="button flex align-center text-white bg-theme-1 shadow-md" onclick="formOther()">
                                <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span> Tambah Detail Invoice</span>
                            </button>
                        @endif
                    </div>
                </div>
                @if ($invoice->type == 'system')
                    <form action="{{ route('project.invoice.system.create', $project->slug) }}" method="post" class="hidden mt-3" id="formSystem">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                        <x-form-input label="Deskripsi" name="description" placeholder="masukkan nama" />
                        <div class="flex w-full gap-3">
                            <x-form-input label="Harga" name="price" placeholder="masukkan jumlah uang" type="number" addon="w-full" />
                            <x-form-input label="Masukkan Jumlah" name="total" value="1" placeholder="masukkan total barang" type="number" addon="w-full" />
                        </div>

                        <div class="flex w-full gap-3">
                            <x-form-input label="Masukkan Lama waktu" name="date" placeholder="ex: 1" addon="w-full" />
                            <div class="w-full">
                                <label for="date_type">Pilih Type Tanggal</label>
                                <select name="date_type" id="date_type" class="input w-full border mt-2">
                                    <option class="hidden" selected></option>
                                    <option value="year">tahunan</option>
                                    <option value="month">bulanan</option>
                                    <option value="week">mingguan</option>
                                    <option value="day">harian</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button class="button flex align-center text-white bg-theme-1 shadow-md mt-3">
                                <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Tambah</span>
                            </button>
                        </div>
                        <hr class="my-4">
                    </form>

                    <div class="mt-8">
                        {{-- <div class="flex justify-end mb-5">
                            <a target="_blank" href="{{ route('project.invoice.download', [$project->slug, $invoice->id]) }}" class="button flex align-center text-white bg-theme-1 shadow-md">
                                <i data-feather="download" class=" w-4 h-4 mt-1 font-bold mr-2"></i> Download Invoice
                            </a>
                        </div> --}}
                        <table class="table table-report table-report--bordered display datatable w-full">
                            <thead>
                                <tr>
                                    <th class="border-b-2 text-center whitespace-no-wrap">DETAIL NAME</th>
                                    <th class="border-b-2 text-center whitespace-no-wrap">HARGA</th>
                                    <th class="border-b-2 text-center whitespace-no-wrap">LAMA WAKTU</th>
                                    <th class="border-b-2 text-center whitespace-no-wrap">TOTAL</th>
                                    <th class="border-b-2 text-center whitespace-no-wrap">TOTAL HARGA</th>
                                    <th class="border-b-2 text-center whitespace-no-wrap">TANGGAL DIBUAT</th>
                                    <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($invoice->system as $item)
                                <tr>
                                    <td class="border-b">
                                        <div class="font-medium whitespace-no-wrap">{{ $item->description ?? '' }}</div>
                                    </td>

                                    <td class="text-center border-b">Rp. {{ number_format($item->price) }}</td>
                                    <td class="text-center border-b">
                                        {{ $item->date }}
                                        @if ($item->date_type == 'year')
                                            Tahun
                                        @elseif ($item->date_type == 'month')
                                            Bulan
                                        @elseif ($item->date_type == 'week')
                                            Minggu
                                        @elseif ($item->date_type == 'day')
                                            Hari
                                        @endif
                                    </td>
                                    <td class="text-center border-b">{{ $item->total }}</td>
                                    <td class="text-center border-b">Rp. {{ number_format($item->total * $item->price) }}</td>
                                    <td class="text-center border-b">{{ $item->created_at->format('d M Y') }}</td>
                                    <td class="border-b w-5">
                                        <div class="flex sm:justify-center items-center">
                                            <div class="dropdown relative flex items-center gap-1">
                                                <a href="{{ route('project.invoice.detail', [$project->slug, $item->id]) }}" class="button inline-block text-white bg-theme-9 shadow-md">
                                                  <i data-feather="edit-2" class=" w-4 h-4 font-bold"></i>
                                                </a>
                                                <form action="{{ route('project.invoice.system.delete', [$project->slug, $item->id]) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="button inline-block text-white bg-theme-6 shadow-md show-alert-delete-box" data-toggle="tooltip" title='Delete'>
                                                        <i data-feather="trash" class=" w-4 h-4 font-bold"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if ($invoice->type == 'other')
                    <form action="{{ route('project.invoice.other.create', $project->slug) }}" method="post" class="hidden mt-3" id="formOther">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                        <x-form-input label="Deskripsi" name="description" placeholder="masukkan nama" />
                        <div class="flex w-full gap-3">
                            <x-form-input label="Harga" name="price" placeholder="masukkan jumlah uang" type="number" addon="w-full" />
                            <x-form-input label="Masukkan Jumlah" name="total" value="1" placeholder="masukkan total barang" type="number" addon="w-full" />
                        </div>

                        <div class="flex justify-end">
                            <button class="button flex align-center text-white bg-theme-1 shadow-md mt-3">
                                <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Tambah</span>
                            </button>
                        </div>
                        <hr class="my-4">
                    </form>

                    <div class="mt-8">
                        <table class="table table-report table-report--bordered display datatable w-full">
                            <thead>
                                <tr>
                                    <th class="border-b-2 text-center whitespace-no-wrap">DETAIL NAME</th>
                                    <th class="border-b-2 text-center whitespace-no-wrap">HARGA</th>
                                    <th class="border-b-2 text-center whitespace-no-wrap">TOTAL</th>
                                    <th class="border-b-2 text-center whitespace-no-wrap">TOTAL HARGA</th>
                                    <th class="border-b-2 text-center whitespace-no-wrap">TANGGAL DIBUAT</th>
                                    <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($invoice->other as $item)
                                <tr>
                                    <td class="border-b">
                                        <div class="font-medium whitespace-no-wrap">{{ $item->description ?? '' }}</div>
                                    </td>

                                    <td class="text-center border-b">Rp. {{ number_format($item->price) }}</td>
                                    <td class="text-center border-b">{{ $item->total }}</td>
                                    <td class="text-center border-b">Rp. {{ number_format($item->total * $item->price) }}</td>
                                    <td class="text-center border-b">{{ $item->created_at->format('d M Y') }}</td>
                                    <td class="border-b w-5">
                                        <div class="flex sm:justify-center items-center">
                                            <div class="dropdown relative flex items-center gap-1">
                                                <a href="{{ route('project.invoice.detail', [$project->slug, $item->id]) }}" class="button inline-block text-white bg-theme-9 shadow-md">
                                                  <i data-feather="edit-2" class=" w-4 h-4 font-bold"></i>
                                                </a>
                                                <form action="{{ route('project.invoice.other.delete', [$project->slug, $item->id]) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="button inline-block text-white bg-theme-6 shadow-md show-alert-delete-box" data-toggle="tooltip" title='Delete'>
                                                        <i data-feather="trash" class=" w-4 h-4 font-bold"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endif
        </div>
    </x-card>
@endsection

@push('scripts')
    <script>
        function formSystem() {
            var form = document.getElementById('formSystem');
            form.classList.toggle('hidden')
        }
        function formOther() {
            var form = document.getElementById('formOther');
            form.classList.toggle('hidden')
        }
    </script>
@endpush
