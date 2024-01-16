@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}" :project="$detail">
        <x-tab-detail page="lampiran" slug="{{ $project->slug }}" />
        <form class="mt-5" method="POST" action="{{ route('project.lampiran.upload', $project->slug) }}">
            @csrf
            @method('POST')
            {{-- @if ($lampiran === null) @method('POST') @else @method('PUT') @endif --}}
            {{-- @if ($lampiran === null)  @else <input type="text" value="{{ $lampiran->id }}" hidden> @endif --}}
            <div>
                <label>Nama</label>

                {{-- {{ isset($lampiran) ? $lampiran->name : 'Tidak ada lampiran' }} --}}

                <input type="text" name="name" class="input w-full border mt-2 @error('name') border-theme-6 @enderror" value="{{ old('name') }}" placeholder="Nama">
                @error('name')
                    <div class="text-theme-6 mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-4">
                <label>Link</label>
                <input type="text" name="link" class="input w-full border mt-2 @error('link') border-theme-6 @enderror" value="{{ old('link') }}" placeholder="Link">
                @error('link')
                    <div class="text-theme-6 mt-2">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="button bg-theme-1 text-white mt-5">Submit</button>
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
            @foreach($lampiran as $item)
                <tr>
                    <td class="border-b">{{ $item->name }}</td>
                    <td class="text-center border-b">
                        <a href="{{ $item->link }}" class="button bg-theme-1 text-white px-5" target="_blank" rel="noopener noreferrer">link disini</a>
                    </td>
                    <td class="border-b w-5">
                        <div class="flex sm:justify-center items-center">
                            <div class="dropdown relative">
                                <button class="dropdown-toggle button inline-block bg-theme-1 text-white" type="button" id="actionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="more-vertical" class="w-4 h-4"></i>
                                </button>
                                <div class="dropdown-box mt-10 absolute w-48 top-0 left-0 z-20">
                                    <div class="dropdown-box__content box p-2">
                                        <a href="{{ route('project.lampiran.edit', ['slug' => $project->slug, 'id' => $item->id]) }}" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
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
