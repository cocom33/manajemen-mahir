@extends('layouts.app')
@section('title', 'Project')

@section('content')
    <!-- BEGIN: Content -->
    <x-card title="Project List" :route="route('project.create')">

        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">PROJECT NAME</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">CLIENT</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">PROJECT CATEGORY</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        {{-- <td class="border-b hidden">
                            <div class="font-medium whitespace-no-wrap">{{ $project->id }}</div>
                        </td> --}}
                        <td class="border-b">
                            <a class="font-medium whitespace-no-wrap" href="{{ route('project.detail', $project->slug) }}">{{ $project->name }}</a>
                        </td>
                        <td class="w-40 border-b">
                            <div class="flex items-center sm:justify-center">
                                {{ $project->client->name }}
                            </div>
                        </td>

                        <td class="text-center border-b">{{ $project->projectType->name }}</td>
                        <td class="text-center border-b">
                            @switch($project->status)
                                @case('penawaran')
                                    <span class="text-theme-12">{{ $project->status }}</span>
                                @break

                                @case('deal')
                                    <span class="text-theme-40">{{ $project->status }}</span>
                                @break

                                @case('finish')
                                    <span class="text-theme-9">{{ $project->status }}</span>
                                @break

                                @case('cancel')
                                    <span class="text-theme-6">{{ $project->status }}</span>
                                @break
                            @endswitch
                        </td>
                        <td class="border-b w-5">
                            <div class="flex sm:justify-center items-center gap-2">
                                <a href="{{ route('project.edit', $project->slug) }}"
                                    class="button inline-block text-white bg-theme-9 shadow-md">
                                    <i data-feather="edit-2" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('project.detail', $project->slug) }}"
                                    class="button inline-block text-white bg-theme-1 rounded-md">
                                    <i data-feather="eye" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('project.delete', $project->slug) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="show-alert-delete-box button inline-block text-theme-6 bg-theme-6 rounded-md">
                                        <i data-feather="trash-2" class="w-4 h-4 text-white"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-card>
    <!-- END: Content -->
@endsection
