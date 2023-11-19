@extends('layouts.app')
@section('title', 'Create Project')

@section('content')
    <x-card title="Buat Project Baru" :routeBack="route('projects')">
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
                value="{{ $model->harga_penawaran ?? '' }}"
                type="number"
                required="false"
            />
            <x-form-input
                label="Harga deal"
                name="harga_deal"
                value="{{ $model->harga_deal ?? '' }}"
                type="number"
                required="false"
            />
            <x-form-select
                label="Status Server"
                name="status_server"
                :default="[
                    'label' => $model->status_server ?? '',
                    'value' => $model->status_server ?? '',
                ]"
                :options="[
                    'mahir', 'mandiri'
                ]"
                required="false"
                pesan="bisa dikosongkan"
            />
            <div class="flex justify-end">
                <button class="button text-white bg-theme-1 shadow-md">@if ($model) Edit @else Tambah @endif Data</button>
            </div>
        </form>
    </x-card>
@endsection
