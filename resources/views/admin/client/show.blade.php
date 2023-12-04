@extends('layouts.app')
@section('content')
<!-- BEGIN: Vertical Form -->
<div class="intro-y box">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
        <h2 class="font-medium text-base mr-auto">
            Show {{ $client->name }}
        </h2>
        <div class="flex justify-end">
            <a href="{{ route('client.edit', $client) }}" class="button flex align-center text-white bg-theme-1 shadow-md">
              <i data-feather="edit-2" class=" w-4 h-4 font-bold mr-2"></i> Edit
            </a>
        </div>
    </div>
    <div class="p-5" id="vertical-form">
        <div class="preview grid grid-cols-2">
                <div>
                    <div class="mb-6">
                        <span class="font-semibold">Nama</span>
                        <p class="mt-3">{{ $client->name }}</p>
                    </div>
                    <div class="mb-6">
                        <span class="font-semibold">Email</span>
                        <p class="mt-3">{{ $client->email }}</p>
                    </div>
                    <div class="mb-6">
                        <span class="font-semibold">Phone</span>
                        <p class="mt-3">{{ $client->wa }}</p>
                    </div>
                    <a href="{{ route('client.index') }}"><button class="button bg-theme-1 text-white mt-5">Back</button></a>
                </div>
                <div>
                    <div class="mb-6">
                        <span class="font-semibold">Sumber</span>
                        <div class="mt-3">
                            <span class="inline-flex items-center rounded-md bg-green-200 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                {{ $client->sumber ? $client->sumber : 'Belum di isi' }}
                            </span>
                        </div>
                    </div>
                    <div class="mb-6">
                        <span class="font-semibold">Alamat</span>
                        <p class="mt-3">{{ $client->alamat }}</p>
                    </div>
                </div>
        </div>
    </div>
</div>

<div class="intro-y box mt-5">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
        <h2 class="font-medium text-base mr-auto">
            List Project Client {{ $client->name }}
        </h2>
    </div>
    <div class="p-5" id="vertical-form">
        <div class="intro-y datatable-wrapper box p-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">PROJECT NAME</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">CLIENT</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">PROJECT CATEGORY</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">CREATED</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
            @if (!$projects == null)
                @foreach($projects as $project)
                    <tr>
                        <td class="border-b">
                            <div class="font-medium whitespace-no-wrap">{{ $project->name }}</div>
                            <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $project->name }}</div>
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
                        <td class="w-40 border-b">
                            <div class="flex items-center sm:justify-center">
                                <span class="inline-flex items-center rounded-md bg-green-200 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                    {{ date($project->created_at) }}
                                </span>
                            </div>
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
            @else

            @endif
            </tbody>
        </table>
        </div>
    </div>
</div>
<!-- END: Vertical Form -->
@endsection
