@extends('layouts.app')
@section('title', 'Project')

@section('content')
 <!-- BEGIN: Content -->
 <x-card title="Project List" :route="route('project.create')">
    <div class="relative w-full">
        <livewire:project-table />
    </div>
 </x-card>
<!-- END: Content -->
@endsection
