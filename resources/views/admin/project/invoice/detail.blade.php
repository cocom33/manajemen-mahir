@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}" :project="$detail">
        <x-tab-detail page="invoice" slug="{{ $project->slug }}" />
        <div class="mt-5">
            <div class="w-full flex justify-between align-center">
                <h3 class="font-bold text-xl">
                    Edit Detail Invoice
                </h3>
            </div>

            @if ($project->invoice->type == 'system')
                <form action="{{ route('project.invoice.system.create', $project->slug) }}" method="post" class="mt-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="invoice_id" value="{{ $project->invoice->id }}">
                    <input type="hidden" name="id" value="{{ $invoice->id }}">
                    <x-form-input label="Deskripsi" name="description" placeholder="masukkan nama" value="{{ $invoice->description }}" />
                    <div class="flex w-full gap-3">
                        <x-form-input label="Harga" name="price" placeholder="masukkan jumlah uang" type="number" addon="w-full" value="{{ $invoice->price }}" />
                        <x-form-input label="Masukkan Jumlah" name="total" value="1" placeholder="masukkan total barang" type="number" addon="w-full" value="{{ $invoice->total }}" />
                    </div>
                    <div class="flex w-full gap-3">
                        <x-form-input label="Masukkan Lama waktu" name="date" placeholder="ex: 1" addon="w-full" value="{{ $invoice->date }}" />
                        <div class="w-full">
                            <label for="date_type">Pilih Type Tanggal</label>
                            <select name="date_type" id="date_type" class="input w-full border mt-2">
                                <option value="year" @if ($invoice->date_type == 'year') selected @endif >tahunan</option>
                                <option value="month" @if ($invoice->date_type == 'month') selected @endif>bulanan</option>
                                <option value="week" @if ($invoice->date_type == 'week') selected @endif>mingguan</option>
                                <option value="day" @if ($invoice->date_type == 'day') selected @endif>harian</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-1">
                        <a href="{{ route('project.invoice', $project->slug) }}" class="button flex align-center text-white bg-theme-1 shadow-md mt-3">
                            <i data-feather="arrow-left" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Kembali</span>
                        </a>
                        <button class="button flex align-center text-white bg-theme-9 shadow-md mt-3">
                            <i data-feather="edit-2" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Edit</span>
                        </button>
                    </div>
                    <hr class="my-4">
                </form>
            @endif
            @if ($project->invoice->type == 'other')
                <form action="{{ route('project.invoice.other.create', $project->slug) }}" method="post" class="mt-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="invoice_id" value="{{ $project->invoice->id }}">
                    <input type="hidden" name="id" value="{{ $invoice->id }}">
                    <x-form-input label="Deskripsi" name="description" placeholder="masukkan nama" value="{{ $invoice->description }}" />
                    <div class="flex w-full gap-3">
                        <x-form-input label="Harga" name="price" placeholder="masukkan jumlah uang" type="number" addon="w-full" value="{{ $invoice->price }}" />
                        <x-form-input label="Masukkan Jumlah" name="total" value="1" placeholder="masukkan total barang" type="number" addon="w-full" value="{{ $invoice->total }}" />
                    </div>

                    <div class="flex justify-end gap-1">
                        <a href="{{ route('project.invoice', $project->slug) }}" class="button flex align-center text-white bg-theme-1 shadow-md mt-3">
                            <i data-feather="arrow-left" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Kembali</span>
                        </a>
                        <button class="button flex align-center text-white bg-theme-9 shadow-md mt-3">
                            <i data-feather="edit-2" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Edit</span>
                        </button>
                    </div>
                    <hr class="my-4">
                </form>
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
