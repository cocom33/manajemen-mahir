@extends('layouts.app')
@section('title', 'Create Project')

@section('content')
    <x-card title="Buat Project Baru" :routeBack="route('projects')" >
        <form action="{{ $route }}" method="post">
            @if ($model)
                @method('PUT')
            @endif
            @csrf
            <x-form-input
                label="Project Name"
                name="name"
                value="{{ $model->name ?? '' }}"
                placeholder="Masukkan Nama"
            />
            <x-form-select
                label="Pilih Client"
                name="client_id"
                :default="[
                    'label' => $model->client->name ?? '',
                    'value' => $model->client->id ?? '',
                ]"
                :options="$clients"
            />
            <x-form-select
                label="Type Proejct"
                name="project_type_id"
                :default="[
                    'label' => $model->projectType->name ?? '',
                    'value' => $model->projectType->id ?? '',
                ]"
                :options="$projectType"
            />
            <x-form-textarea
                label="Deskripsi"
                name="description"
                value="{{ $model->description ?? '' }}"
                placeholder="Masukkan Deskripsi"
            />
            <x-form-select
                label="Status Project"
                name="status"
                :default="[
                    'label' => $model->status ?? '',
                    'value' => $model->status ?? '',
                ]"
                :options="[
                    'penawaran' => 'Penawaran',
                    'deal'      => 'Deal',
                    'finish'    => 'Finish',
                    'cancel'    => 'Cancel'
                ]"
            />
            <x-form-input
                label="Tanggal Mulai"
                name="start_date"
                value="{{ $model->start_date ?? '' }}"
                type="date"
                required="false"
            />
            <x-form-input
                label="Target Selesai"
                name="deadline_date"
                value="{{ $model->deadline_date ?? '' }}"
                type="date"
                required="false"
            />
            <x-form-input
                label="Harga Penawaran"
                name="harga_penawaran"
                value="{{ ($model->harga_penawaran ?? 0) }}"
                required="false"
            />
            <x-form-input
                label="Harga Deal"
                name="harga_deal"
                value="{{ ($model->harga_deal ?? 0) }}"
                required="false"
            />
            @php
                if ($model && $model->type_pajak == 1) {
                    $type = 'penambahan';
                    $val = 1;
                }
                if ($model && $model->type_pajak == 0) {
                    $type = 'pengurangan';
                    $val = 0;
                }
            @endphp
            <x-form-select
                label="Type Pajak"
                name="type_pajak"
                :default="[
                    'label' => $type ?? '',
                    'value' => $val ?? '',
                ]"
                :options="[
                    '2' => 'tidak ada', '0' => 'pengurangan', '1' => 'penambahan'
                ]"
                required="false"
            />
            <x-form-input
                label="Rasio Pajak"
                name="pajak"
                type="number"
                max="100"
                min="0"
                value="{{ ($model->pajak ?? null) }}"
                required="false"
                pesan="Masukkan persen"
            />
            <div class="flex justify-end">
                <button class="button text-white bg-theme-1 shadow-md">@if ($model) Edit @else Tambah @endif Data</button>
            </div>
        </form>
    </x-card>
@endsection

@push('scripts')
    <script>
        var penawaran = document.getElementById('Harga Penawaran');
        penawaran.addEventListener('keyup', function(e) {
            penawaran.value = formatRupiah(this.value, 'Rp. ');
        });
        var deal = document.getElementById('Harga Deal');
        deal.addEventListener('keyup', function(e) {
            deal.value = formatRupiah(this.value, 'Rp. ');
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
