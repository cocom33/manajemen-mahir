@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}">
        <x-tab-detail page="invoice" slug="{{ $project->slug }}" />
        <div class="mt-5">
            project invoice page
        </div>
    </x-card>
@endsection