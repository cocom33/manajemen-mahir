@extends('layouts.app')

@section('content')

 <!-- BEGIN: Content -->
<x-card title="List Tagihan" route="{{ route('users.create') }}">
    <table class="table table-report table-report--bordered display datatable w-full">
        <thead>
            <tr>
                <th class="border-b-2 whitespace-no-wrap">NAME</th>
                <th class="border-b-2 text-center whitespace-no-wrap">EMAIL</th>
                <th class="border-b-2 text-center whitespace-no-wrap">DIBUAT PADA</th>
                <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td class="border-b">
                    <div class="font-medium whitespace-no-wrap">{{ $user->name }}</div>
                    <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $user->name }}</div>
                </td>

                <td class="text-center border-b">{{ $user->email }}</td>
                <td class="text-center border-b">{{ $user->created_at->format('d / m / Y') }}</td>
                <td class="border-b w-5">
                    <div class="flex sm:justify-center items-center">
                        <div class="dropdown relative">
                            <button class="dropdown-toggle button inline-block bg-theme-1 text-white" type="button" id="actionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="more-vertical" class="w-4 h-4"></i>
                            </button>
                            <div class="dropdown-box mt-10 absolute w-48 top-0 left-0 z-20">
                                <div class="dropdown-box__content box p-2">
                                    <a href="{{ route('users.edit', $user) }}" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                                        <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> Edit
                                    </a>
                                    <a href="{{ route('users.show', $user) }}" class="flex text-theme-3 items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                                        <i data-feather="eye" class="w-4 h-4 mr-2"></i> Show
                                    </a>
                                    @if (Auth::user()->id != $user->id)
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="show-alert-delete-box flex items-center text-theme-6 block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                            </button>
                                        </form>
                                    @endif
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
