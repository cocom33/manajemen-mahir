@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}">
        <x-tab-detail page="team" slug="{{ $project->slug }}" />
        <div class="mt-5">
            project Team page
        </div>
    </x-card>
@endsection
