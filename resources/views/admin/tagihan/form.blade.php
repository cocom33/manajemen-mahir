@extends('layouts.app')
@section('title', $tagihan->title ?? 'Buat Tagihan')

@section('content')
    <x-card title="{{ $tagihan ? 'Edit Tagihan' : 'Buat Tagihan' }}">
        <div class="mt-5">
            <div class="w-full flex justify-between align-center">
                <h3 class="font-bold text-xl">
                    {{ $tagihan ? 'Edit' : 'Buat' }} Tagihan
                </h3>
            </div>

            <form action="{{ $route }}" method="post" class="mt-3">
                @csrf
                @if ($tagihan)
                    @method('PUT')
                @endif

                <input type="hidden" name="tagihan_id" value="{{ $tagihan->id ?? '' }}">
                <x-form-input label="Nama" name="title" placeholder="masukkan nama" value="{{ $tagihan->title ?? '' }}" />
                <x-form-select
                    label="Client"
                    name="client_id"
                    placeholder="Pilih Client"
                    :default="[
                        'value' => $tagihan->client_id ?? '',
                        'label' => $tagihan->client->name ?? '',
                    ]"
                    :options="$clients"
                />
                <div class="flex w-full gap-3">
                    <x-form-input label="Harga Jual" name="harga_jual" placeholder="masukkan jumlah uang" addon="w-full" value="{{ $tagihan->harga_jual ?? '' }}" />
                    <x-form-input label="Harga Beli" name="harga_beli" placeholder="masukkan jumlah uang" addon="w-full" value="{{ $tagihan->harga_beli ?? '' }}" />
                    <x-form-input label="Masukkan Jumlah" name="total" placeholder="masukkan total barang" type="number" addon="w-full" value="{{ $tagihan->total ?? '1' }}" />
                </div>

                <div class="flex w-full gap-3">
                    <x-form-input label="Masukkan waktu Pembelian" name="date_start" type="date" addon="w-full" value="{{ $tagihan->date_start ?? '' }}" />
                    <x-form-input label="Masukkan waktu Jatuh Tempo" name="date_end" type="date" addon="w-full" value="{{ $tagihan->date_start ?? '' }}" />
                </div>

                <div class="mt-3">
                    <label for="description">Masukkan deskripsi/catatan Tagihan</label>
                    <textarea name="description" id="description" rows="8" class="mt-3 input w-full border">{{ $tagihan->description ?? '' }}</textarea>
                </div>
                <div class="flex items-center mt-3 justify-end">
                    <input type="checkbox" name="lunas" id="lunas" class="mr-1">
                    <label for="lunas">Tandai Lunas</label>
                </div>

                <div class="flex justify-end gap-2 mt-3">
                    @php
                        $route = route('tagihan');
                        if ($tagihan) {
                            $route = route('tagihan.show', $tagihan->id);
                        }
                    @endphp
                    <a href="{{ $route }}" class="button flex align-center text-white {{ $tagihan ? 'bg-theme-1' : 'bg-theme-9' }} shadow-md ">
                        <span>Kembali</span>
                    </a>
                    <button class="button flex align-center text-white {{ $tagihan ? 'bg-theme-9' : 'bg-theme-1' }} shadow-md ">
                        <i data-feather="edit-2" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>{{ $tagihan ? 'Edit' : 'Buat' }}</span>
                    </button>
                </div>
                <hr class="my-4">
            </form>
        </div>
    </x-card>
@endsection

@push('scripts')
    <script>
        var fee = document.getElementById('Harga Jual');
        fee.addEventListener('keyup', function(e) {
            fee.value = formatRupiah(this.value, 'Rp. ');
        });

        var asli = document.getElementById('Harga Beli');
        asli.addEventListener('keyup', function(e) {
            asli.value = formatRupiah(this.value, 'Rp. ');
        });

        function formatRupiah(number, prefix) {
          var number_string = number.replace(/[^,\d]/g, '').toString(),
              split = number_string.split(','),
              remainder = split[0].length % 3,
              rupiah = split[0].substr(0, remainder),
              ribuan = split[0].substr(remainder).match(/\d{3}/gi);

          if (ribuan) {
              separator = remainder ? '.' : '';
              rupiah += separator + ribuan.join('.');
          }

          rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
          return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>
@endpush
