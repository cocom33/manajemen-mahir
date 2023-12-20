@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}" :project="$detail">
        <x-tab-detail page="pengeluaran" slug="{{ $project->slug }}" />
        <div class="mt-5">
            <div class="w-full flex justify-between align-center">
                <h3 class="font-bold text-xl">
                    Pengeluaran Project
                </h3>
                <div>
                    <a href="{{ route('project.pengeluaran', $project->slug) }}" class="button flex align-center text-white bg-theme-1 shadow-md">
                       <span> Kembali</span>
                    </a>
                </div>
            </div>

            <form action="{{ route('project.pengeluaran.store', $project->slug) }}" method="post" class="mt-3" id="formOther">
                @csrf

                <x-form-input label="Deskripsi" name="" value="{{ $pengeluaran->title ?? '-' }}" readonly="readonly" />
                <div class="flex w-full gap-3">
                    <x-form-input label="Harga" name="" addon="w-full" value="Rp. {{ number_format($pengeluaran->price) ?? '-' }}" readonly="readonly" />
                    <x-form-input label="Masukkan Tanggal" name="" addon="w-full" value="{{ $pengeluaran->date ?? '-' }}" readonly="readonly" />
                </div>

                <div class="mb-3">
                    <label>Tambahkan deskripsi</label>
                    <textarea rows="5" class="mt-3 input w-full border" readonly="readonly">{{ $pengeluaran->description ?? '-' }}</textarea>
                </div>
            </form>
        </div>
    </x-card>
@endsection
