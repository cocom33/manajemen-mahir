@extends('layouts.app')
@section('title', 'Banks')

@section('content')
<div class="flex flex-col items-center mt-8 intro-y sm:flex-row">
    <h2 class="mr-auto text-lg font-medium">List Bank</h2>
    <div class="flex w-full mt-4 sm:w-auto sm:mt-0">
        <a href="{{ route('banks.create') }}"><button class="mr-2 text-white shadow-md button bg-theme-1">Add New banks</button></a>
    </div>
</div>
<!-- BEGIN: Datatable -->
<div class="p-5 mt-5 intro-y datatable-wrapper box">
    <table id="example" class="table w-full table-report table-report--bordered display datatable">
        <thead>
            <tr>
                <th class="whitespace-no-wrap border-b-2">NAMA BANK</th>
                <th class="text-center whitespace-no-wrap border-b-2">NO REKENING</th>
                <th class="text-center whitespace-no-wrap border-b-2">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
                <tr>
                    <td class="border-b">{{ $data->name }}</td>
                    <td class="text-center border-b ">{{ $data->rekening }}</td>
                    <td class="w-5 border-b">
                        <div class="flex items-center sm:justify-center">
                            <a class="flex items-center mr-3" href="{{ route('banks.edit', $data->id) }}">
                                <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                            </a>
                            <a class="flex items-center mr-3 text-theme-3" href="{{ route('banks.show', $data->id) }}">
                                <i data-feather="eye" class="w-4 h-4 mr-1"></i> Show
                            </a>
                            <form method="POST" action="{{ route('banks.destroy', $data->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center text-theme-6 show-alert-delete-box" data-toggle="tooltip" title='Delete'><i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- END: Datatable -->
@endsection

