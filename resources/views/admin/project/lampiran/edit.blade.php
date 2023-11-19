@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}">
        <x-tab-detail page="lampiran" slug="{{ $project->slug }}" />
        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mt-5" role="alert">
            <div class="flex">
            <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
            <div>
                <p class="font-bold">Edit Lampiran {{ $single->name }}</p>
                <p class="text-sm">Ini adalah halaman untuk mengedit lampiran</p>
            </div>
            </div>
        </div>
        <form class="mt-5" method="POST" action="{{ route('project.lampiran.update', ['slug' => $project->slug, 'id' => $single->id]) }}">
            @csrf
            @method('PUT')
            <div>
                <label>Nama</label>

                <input type="text" name="name" class="input w-full border mt-2 @error('name') border-theme-6 @enderror" value="{{ $single->name }}" placeholder="Nama">
                @error('name')
                    <div class="text-theme-6 mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-4">
                <label>Link</label>
                <input type="text" name="link" class="input w-full border mt-2 @error('link') border-theme-6 @enderror" value="{{ $single->link }}" placeholder="Link">
                @error('link')
                    <div class="text-theme-6 mt-2">{{ $message }}</div>
                @enderror
            </div>
            <a href="{{ route('project.lampiran', $project->slug) }}"><button type="button" class="button bg-theme-9 text-white mt-5">Back</button></a>
            <button type="submit" class="button bg-theme-1 text-white mt-5">Save</button>
        </form>
    </x-card>

    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <table class="table table-hover table-striped table-bordered dt-responsive nowrap w-full">
            <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">Nama</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Link</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
            @foreach($lampiran->where('project_id', $project->id) as $item)
                <tr>
                    <td class="border-b">{{ $item->name }}</td>
                    <td class="text-center border-b">{{ $item->link }}</td>
                    <td class="border-b w-5">
                        <div class="flex sm:justify-center items-center">
                            <div class="dropdown relative">
                                <button class="dropdown-toggle button inline-block bg-theme-1 text-white" type="button" id="actionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="more-vertical" class="w-4 h-4"></i>
                                </button>
                                <div class="dropdown-box mt-10 absolute w-48 top-0 left-0 z-20">
                                    <div class="dropdown-box__content box p-2">
                                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                                            <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> Edit
                                        </a>
                                        <form action="{{ route('project.lampiran.destroy', ['slug' => $project->slug, 'id' => $item->id]) }}" method="POST">
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
    </div>
@endsection
