@extends('layouts.app')

@section('content')
 <!-- BEGIN: Content -->
<div class="intro-y space-around col-span-12 flex flex-wrap sm:flex-no-wrap items-center justify-between mt-5">
    <b class="text-xl">Client Lists</b>
    <div class="flex">
        <div class="dropdown relative mr-2">
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
        <a href="{{route('client.create')}}"><button class="button text-white bg-theme-1 shadow-md ">Add New Client</button></a>
    </div>
</div>


<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table class="table table-report table-report--bordered display datatable w-full">
        <thead>
            <tr>
                <th class="border-b-2 whitespace-no-wrap">CLIENT NAME</th>
                <th class="border-b-2 text-center whitespace-no-wrap">SUMBER</th>
                <th class="border-b-2 text-center whitespace-no-wrap">WHATSAPP</th>
                <th class="border-b-2 text-center whitespace-no-wrap">EMAIL</th>
                <th class="border-b-2 text-center whitespace-no-wrap">ALAMAT</th>
                <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
        @foreach($clients as $client)
            <tr>
                <td class="border-b">
                    <div class="font-medium whitespace-no-wrap">{{ $client->name }}</div>
                    <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $client->name }}</div>
                </td>
                <td class="w-40 border-b">
                    <div class="flex items-center sm:justify-center">
                        {{ ucfirst($client->sumber) }}
                    </div>
                </td>

                <td class="text-center border-b">{{ $client->wa }}</td>
                <td class="text-center border-b">{{ $client->email }}</td>
                <td class="text-center border-b">{{ $client->alamat }}</td>
                <td class="border-b w-5">
                    <div class="flex sm:justify-center items-center">
                        <div class="dropdown relative">
                            <button class="dropdown-toggle button inline-block bg-theme-1 text-white" type="button" id="actionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="more-vertical" class="w-4 h-4"></i>
                            </button>
                            <div class="dropdown-box mt-10 absolute w-48 top-0 left-0 z-20">
                                <div class="dropdown-box__content box p-2">
                                    <a href="{{ route('client.edit', $client) }}" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                                        <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> Edit
                                    </a>
                                    <form action="{{ route('client.destroy', $client->id) }}" method="POST">
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
<!-- END: Content -->
@endsection
