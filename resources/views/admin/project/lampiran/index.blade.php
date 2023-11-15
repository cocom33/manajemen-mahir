@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}">
        <x-tab-detail page="lampiran" slug="{{ $project->slug }}" />
        <form class="mt-5" method="POST" action="{{ route('project.lampiran.upload', $project->slug) }}">
            @csrf
            @method('POST')
            <div>
                <label>Nama</label>
                <input type="text" name="name" class="input w-full border mt-2 @error('name') border-theme-6 @enderror" value="{{ $project->projectDocuments }}" placeholder="Nama Client">
                @error('name')
                    <div class="text-theme-6 mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-4">
                <label>Link</label>
                <input type="text" name="link" class="input w-full border mt-2 @error('link') border-theme-6 @enderror" placeholder="Nama Client">
                @error('link')
                    <div class="text-theme-6 mt-2">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="button bg-theme-1 text-white mt-5">Submit</button>
        </form>
    </x-card>
@endsection
