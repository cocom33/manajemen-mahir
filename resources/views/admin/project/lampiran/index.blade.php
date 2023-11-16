@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}">
        <x-tab-detail page="lampiran" slug="{{ $project->slug }}" />
        <form class="mt-5" method="POST" action="@if ($lampiran === null) {{ route('project.lampiran.upload', $project->slug) }} @else {{ route('project.lampiran.update', $lampiran->project_id) }} @endif">
            @csrf
            @if ($lampiran === null) @method('POST') @else @method('PUT') @endif
            @if ($lampiran === null)  @else <input type="text" value="{{ $lampiran->id }}" hidden> @endif
            <div>
                <label>Nama</label>

                {{ isset($lampiran) ? $lampiran->name : 'Tidak ada lampiran' }}

                <input type="text" name="name" class="input w-full border mt-2 @error('name') border-theme-6 @enderror" value="{{ isset($lampiran) ? $lampiran->name : '' }}" placeholder="Nama">
                @error('name')
                    <div class="text-theme-6 mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-4">
                <label>Link</label>
                <input type="text" name="link" class="input w-full border mt-2 @error('link') border-theme-6 @enderror" value="{{ isset($lampiran) ? $lampiran->link : '' }}" placeholder="Link">
                @error('link')
                    <div class="text-theme-6 mt-2">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="button bg-theme-1 text-white mt-5">Submit</button>
        </form>
    </x-card>
@endsection
