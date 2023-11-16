@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}">
        <x-tab-detail page="fee" slug="{{ $project->slug }}" />
        <div class="mt-5">
            <div class="flex justify-end">
                <a href="{{ route('project.edit', $project->slug) }}" class="button flex align-center text-white bg-theme-1 shadow-md">
                  <i data-feather="plus" class=" w-4 h-4 font-bold mr-2"></i> <span>Tambah Pembayaran</span>
                </a>
            </div>

        </div>
    </x-card>
@endsection
