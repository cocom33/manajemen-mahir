@extends('layouts.app')
@section('title', 'Project')

@section('content')
 <!-- BEGIN: Content -->
 <x-card title="Project List" :route="route('project.create')">

    <table class="table table-report table-report--bordered display datatable w-full">
        <thead>
            <tr>
                <th class="border-b-2 whitespace-no-wrap">PROJECT NAME</th>
                <th class="border-b-2 text-center whitespace-no-wrap">CLIENT NAME</th>
                <th class="border-b-2 text-center whitespace-no-wrap">PROJECT TYPE</th>
                <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td class="border-b">
                    <div class="font-medium whitespace-no-wrap">{{ $project->name }}</div>
                    <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $project->name }}</div>
                </td>
                <td class="w-40 border-b">
                    <div class="flex items-center sm:justify-center">
                        {{ ucfirst($project->client->name) }}
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
                    <div class="flex sm:justify-center items-center">
                        <div class="dropdown relative">
                            <button class="dropdown-toggle button inline-block bg-theme-1 text-white" type="button" id="actionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="more-vertical" class="w-4 h-4"></i>
                            </button>
                            <div class="dropdown-box mt-10 absolute w-48 top-0 left-0 z-20">
                                <div class="dropdown-box__content box p-2">
                                    <a href="{{ route('project.edit', $project->slug) }}" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                                        <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> Edit
                                    </a>
                                    <a href="{{ route('project.detail', $project->slug) }}" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                                        <i data-feather="eye" class="w-4 h-4 mr-2"></i> Show
                                    </a>
                                    <form action="{{ route('project.delete', $project->slug) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="show-alert-delete-box flex items-center text-theme-6 block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                                            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
 </x-card>
<!-- END: Content -->
@endsection
