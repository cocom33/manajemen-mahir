@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}">
        <x-tab-detail page="detail" slug="{{ $project->slug }}" />
        <div class="mt-8">
            <div class="flex justify-end">
                <a href="{{ route('project.edit', $project->slug) }}" class="button flex align-center text-white bg-theme-1 shadow-md">
                  <i data-feather="edit-2" class=" w-4 h-4 font-bold mr-2"></i> Edit
                </a>
            </div>
            <x-form-input class="font-bold" label="name project" name="" value="{{ $project->name }}" readonly="readonly" required="false" />
            <x-form-input class="font-bold" label="name client" name="" value="{{ $project->client->name }}" readonly="readonly" required="false" />
            <x-form-input class="font-bold" label="type project" name="" value="{{ $project->projectType->name }}" readonly="readonly" required="false" />
            {{-- <x-form-input class="font-bold" label="description" name="" value="{{ $project->description }}" readonly="readonly" required="false" /> --}}
            <x-form-textarea class="font-bold" label="description" name="" value="{{ $project->description }}" readonly="readonly" required="false" />
            <x-form-input class="font-bold" label="status" name="" value="{{ $project->status }}" readonly="readonly" required="false" />

            <x-form-input class="font-bold" label="start date" name="" value="{{ $project->start_date ?? '' }}" readonly="readonly" required="false" />
            <x-form-input class="font-bold" label="deadline date" name="" value="{{ $project->deadline_date ?? '' }}" readonly="readonly" required="false" />
            <x-form-input class="font-bold" label="harga penawaran" name="" value="{{ $project->harga_penawaran ?? '-' }}" readonly="readonly" required="false" />
            <x-form-input class="font-bold" label="harga deal" name="" value="{{ $project->harga_deal ?? '-' }}" readonly="readonly" required="false" />
            <x-form-input class="font-bold" label="status server" name="" value="{{ $project->status_server ?? '-' }}" readonly="readonly" required="false" />
        </div>
    </x-card>
@endsection