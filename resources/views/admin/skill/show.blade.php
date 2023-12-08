@extends('layouts.app')

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Show Skill {{ $skill->name }}</h2>
    <div class="flex justify-end">
        <a href="{{ route('skill.edit', $skill) }}" class="button flex align-center text-white bg-theme-1 shadow-md">
          <i data-feather="edit-2" class=" w-4 h-4 font-bold mr-2"></i> Edit
        </a>
    </div>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-6">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box p-5">
                <div>
                    <label>Name</label>
                    <input type="text" name="name" value="{{ $skill->name }}" class="input w-full border mt-2 @error('name') border-theme-6 @enderror" readonly>
                    @error('name')
                        <div class="text-theme-6 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="text-right mt-5">
                    <a href="{{ route('skill.index') }}"><button type="button" class="button w-24 border text-gray-700 mr-1">Back</button></a>
                </div>
        </div>
        <!-- END: Form Layout -->
    </div>
</div>
<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table class="table table-report table-report--bordered display datatable w-full">
        <thead>
            <tr>
                <th class="border-b-2 whitespace-no-wrap">TEAM NAME</th>
                <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                <th class="border-b-2 text-center whitespace-no-wrap">WHATSAPP</th>
                <th class="border-b-2 text-center whitespace-no-wrap">EMAIL</th>
                {{-- <th class="border-b-2 text-center whitespace-no-wrap">ALAMAT</th> --}}
                <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
        @foreach($team as $team)
            <tr>
                <td class="border-b">
                    <div class="font-medium whitespace-no-wrap">{{ $team->name }}</div>
                    <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $team->name }}</div>
                </td>
                <td class="w-40 border-b">
                    <div class="flex items-center sm:justify-center {{ $team->status == 'TETAP' ? 'text-theme-12' : 'text-theme-9' }}">
                        {{ ucfirst($team->status) }}
                    </div>
                </td>

                <td class="text-center border-b">{{ $team->wa }}</td>
                <td class="text-center border-b">{{ $team->email }}</td>
                {{-- <td class="text-center border-b">{{ $team->alamat }}</td> --}}
                <td class="border-b w-5">
                    <div class="flex sm:justify-center items-center">
                        <div class="dropdown relative">
                            <button class="dropdown-toggle button inline-block bg-theme-1 text-white" type="button" id="actionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="more-vertical" class="w-4 h-4"></i>
                            </button>
                            <div class="dropdown-box mt-10 absolute w-48 top-0 left-0 z-20">
                                <div class="dropdown-box__content box p-2">
                                    <a href="{{ route('teams.edit', $team) }}" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                                        <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> Edit
                                    </a>
                                    <a href="{{ route('teams.show', $team) }}" class="flex text-theme-3 items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                                        <i data-feather="eye" class="w-4 h-4 mr-2"></i> Show
                                    </a>
                                    <form action="{{ route('teams.destroy', $team->id) }}" method="POST">
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
