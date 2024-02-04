@extends('layouts.app')

@section('content')
 <!-- BEGIN: Content -->
<div class="flex flex-wrap items-center justify-between col-span-12 mt-5 intro-y space-around sm:flex-no-wrap">
    <b class="text-xl">Team Lists</b>
    <div class="flex">
        <a href="{{route('teams.create')}}"><button class="mr-2 text-white shadow-md button bg-theme-1">Add New Team</button></a>
        <div class="relative dropdown">
            <button class="px-2 text-gray-700 dropdown-toggle button box">
                <span class="flex items-center justify-center w-5 h-5"> <i class="w-4 h-4" data-feather="plus"></i> </span>
            </button>
            <div class="absolute top-0 left-0 z-20 w-40 mt-10 dropdown-box">
                <div class="p-2 dropdown-box__content box">
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white rounded-md hover:bg-gray-200"> <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print </a>
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white rounded-md hover:bg-gray-200"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white rounded-md hover:bg-gray-200"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="p-5 mt-5 intro-y datatable-wrapper box">
    <table class="table w-full table-report table-report--bordered display datatable">
        <thead>
            <tr>
                <th class="whitespace-no-wrap border-b-2">TEAM NAME</th>
                <th class="text-center whitespace-no-wrap border-b-2">STATUS</th>
                <th class="text-center whitespace-no-wrap border-b-2">WHATSAPP</th>
                <th class="text-center whitespace-no-wrap border-b-2">EMAIL</th>
                <th class="text-center whitespace-no-wrap border-b-2">ALAMAT</th>
                <th class="text-center whitespace-no-wrap border-b-2">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
        @foreach($teams as $key => $team)
            <tr>
                <td class="border-b">
                    <a href="{{ route('teams.show', $team) }}" class="font-medium whitespace-no-wrap"><span class="hidden">{{ $key }}</span>{{ $team->name }}</a>
                    <div class="text-xs text-gray-600 whitespace-no-wrap">{{ $team->name }}</div>
                </td>
                <td class="w-40 border-b">
                    <div class="flex items-center sm:justify-center {{ $team->status == 'TETAP' ? 'text-theme-12' : 'text-theme-9' }}">
                        {{ ucfirst($team->status) }}
                    </div>
                </td>

                <td class="text-center border-b">{{ $team->wa }}</td>
                <td class="text-center border-b">{{ $team->email }}</td>
                <td class="text-center border-b">{{ $team->alamat }}</td>
                <td class="w-5 border-b">
                    <div class="flex items-center sm:justify-center">
                        <div class="relative dropdown">
                            <button class="inline-block text-white dropdown-toggle button bg-theme-1" type="button" id="actionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="more-vertical" class="w-4 h-4"></i>
                            </button>
                            <div class="absolute top-0 left-0 z-20 w-48 mt-10 dropdown-box">
                                <div class="p-2 dropdown-box__content box">
                                    <a href="{{ route('teams.edit', $team) }}" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white rounded-md hover:bg-gray-200">
                                        <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> Edit
                                    </a>
                                    <a href="{{ route('teams.show', $team) }}" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white rounded-md text-theme-3 hover:bg-gray-200">
                                        <i data-feather="eye" class="w-4 h-4 mr-2"></i> Show
                                    </a>
                                    <form action="{{ route('teams.destroy', $team->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white rounded-md show-alert-delete-box text-theme-6 hover:bg-gray-200">
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
<!-- END: Content -->
@endsection
