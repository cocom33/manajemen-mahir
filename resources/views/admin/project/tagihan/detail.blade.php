@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}" :project="$detail">
        <x-tab-detail page="tagihan" slug="{{ $project->slug }}" />
        <div class="mt-5">
            <div class="w-full flex justify-between align-center">
                <div>
                    <h4 class="font-bold text-xl mb-2">Status : <span class="">{{ $tagihan->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}</span></h4>
                    <h4 class="font-bold text-xl">Pembayaran : <span class="">{{ $tagihan->is_lunas == 1 ? 'Lunas' : 'Belum Lunas' }}</span></h4>
                </div>

                <div class="flex gap-2">
                    @if ($tagihan->is_finish == 0)
                        <form action="{{ route('project.tagihan.non-aktif', $project->slug) }}" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="tagihan_id" value="{{ $tagihan->id }}">
                            @if ($tagihan->is_active == 1)
                                <button class="button flex align-center text-white bg-theme-6 shadow-md">
                                    <i data-feather="minus-circle" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Non Aktifkan</span>
                                </button>
                            @else
                                <button class="button flex align-center text-white bg-theme-1 shadow-md">
                                    <i data-feather="plus-circle" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Aktifkan</span>
                                </button>
                            @endif
                        </form>
                        @if ($tagihan->is_active && $tagihan->is_lunas)
                        <form action="{{ route('project.tagihan.clone', $project->slug) }}" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="tagihan_id" value="{{ $tagihan->id }}">
                            <button class="button flex align-center text-white bg-theme-1 shadow-md">
                                <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Buat Tagihan Selanjutnya</span>
                            </button>
                        </form>
                        @endif
                        @if (!$tagihan->is_lunas && $tagihan->is_active)
                            <form action="{{ route('project.tagihan.lunas', $project->slug) }}" method="post">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="tagihan_id" value="{{ $tagihan->id }}">
                                <button class="button flex align-center text-white bg-theme-1 shadow-md">
                                    <i data-feather="check" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Tandai Lunas</span>
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>

            <div class="mt-3">
                <x-form-input label="Nama" name="" value="{{ $tagihan->title }}" readonly="readonly" required="false" />
                <div class="flex w-full gap-3">
                    <x-form-input label="Harga Jual" name="" addon="w-full" value="Rp. {{ number_format($tagihan->harga_jual) }}" readonly="readonly" required="false" />
                    <x-form-input label="Harga Beli" name="" addon="w-full" value="Rp. {{ number_format($tagihan->harga_beli) }}" readonly="readonly" required="false" />
                    <x-form-input label="Masukkan Jumlah" name="" addon="w-full" value="{{ $tagihan->total }}" readonly="readonly" required="false" />
                </div>

                <div class="flex w-full gap-3">
                    <x-form-input label="Tanggal Pembelian" name="" addon="w-full" value="{{ date('d / m / Y', strtotime($tagihan->date_start)) }}" readonly="readonly" required="false" />
                    <x-form-input label="Jatuh Tempo" name="" addon="w-full" value="{{ date('d / m / Y', strtotime($tagihan->date_end)) }}" readonly="readonly" required="false" />
                    {{-- @php
                        switch ($tagihan->date_type) {
                            case 'year':
                                $tempo = date('d / m / Y', strtotime('+'. $tagihan->date .' year', strtotime($tagihan->date_start)));
                                $jarak = 'tahun';
                                break;
                            case 'month':
                                $tempo = date('d / m / Y', strtotime('+'. $tagihan->date .' month', strtotime($tagihan->date_start)));
                                $jarak = 'bulan';
                                break;
                            case 'week':
                                $tempo = date('d / m / Y', strtotime('+'. $tagihan->date .' week', strtotime($tagihan->date_start)));
                                $jarak = 'minggu';
                                break;
                            case 'day':
                                $tempo = date('d / m / Y', strtotime('+'. $tagihan->date .' day', strtotime($tagihan->date_start)));
                                $jarak = 'hari';
                                break;
                        }
                    @endphp
                    <x-form-input label="Lama Waktu" name="" addon="w-full" value="{{ $tagihan->date . ' ' . $jarak }}" readonly="readonly" required="false" />
                    <x-form-input label="Jatuh Tempo" name="" addon="w-full" value="{{ $tempo }}" readonly="readonly" required="false" /> --}}
                </div>

                <div class="mt-3">
                    <label for="description">Masukkan deskripsi/catatan Tagihan</label>
                    <textarea name="description" id="description" rows="8" class="mt-3 input w-full border" readonly>{{ $tagihan->description }}</textarea>
                </div>
            </div>
        </div>
    </x-card>
@endsection
