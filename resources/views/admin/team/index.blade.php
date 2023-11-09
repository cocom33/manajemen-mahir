@extends('layouts.app')

@section('content')
 <!-- BEGIN: Content -->
 <div class="content">
    <div class="intro-y space-around col-span-12 flex flex-wrap sm:flex-no-wrap items-center justify-between mt-5">
        <b class="text-xl">Team Lists</b>
        <div class="flex">
            <a href="{{route('teams.create')}}"><button class="button text-white bg-theme-1 shadow-md mr-2">Add New Team</button></a>
            <div class="dropdown relative">
                <button class="dropdown-toggle button px-2 box text-gray-700">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                </button>
                <div class="dropdown-box mt-10 absolute w-40 top-0 left-0 z-20">
                    <div class="dropdown-box__content box p-2">
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print </a>
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </a>
                    </div>
                </div>
            </div>
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
                    <th class="border-b-2 text-center whitespace-no-wrap">ALAMAT</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
            @foreach($teams as $team)
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
                    <td class="text-center border-b">{{ $team->alamat }}</td>
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
                                        <form action="{{ route('teams.destroy', $team->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center text-theme-6 block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
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
</div>
<script>
    $(document).ready( function () {
        $('#teams-table').DataTable();
    } );
</script>
<!-- END: Content -->
@endsection
