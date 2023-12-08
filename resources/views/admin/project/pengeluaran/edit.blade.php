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
            </div>

            <form action="{{ route('project.pengeluaran.update', [$project->slug, $pengeluaran->id]) }}" method="post" class="mt-3" id="formOther">
                @csrf
                @method('PUT')

                <x-form-input label="Deskripsi" name="title" value="{{ $pengeluaran->title ?? '-' }}" />
                <div class="flex w-full gap-3">
                    <x-form-input label="Harga" name="price" addon="w-full" value="{{ $pengeluaran->price ?? '-' }}" />
                    <x-form-input label="Masukkan Tanggal" name="date" addon="w-full" value="{{ $pengeluaran->date ?? '-' }}" />
                </div>

                <div class="mb-3">
                    <label>Tambahkan deskripsi</label>
                    <textarea name="description" rows="5" class="mt-3 input w-full border">{{ $pengeluaran->description ?? '-' }}</textarea>
                </div>

                <div class="flex justify-end align-center mt-3 gap-3">
                    <a href="{{ route('project.pengeluaran', $project->slug) }}" class="button flex align-center text-white bg-theme-1 shadow-md">
                       <span> Kembali</span>
                    </a>
                    <button class="button flex align-center text-white bg-theme-9 shadow-md">
                        <i data-feather="edit-2" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Edit</span>
                    </button>
                </div>
            </form>
        </div>
    </x-card>
@endsection
