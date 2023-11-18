@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}">
        <x-tab-detail page="team" slug="{{ $project->slug }}" />
            <form action="{{route('project.add.team', $project->slug)}}" method="POST">
                @csrf
                @method('POST')
                <div class="mt-5 flex flex-wrap sm:flex-no-wrap">
                    <select data-placeholder="Pilih Team" name="team_id" class="select2 w-full" multiple>
                        @foreach ($teams as $team)
                        <option value="1"> {{ $team->name }} </option>
                        @endforeach
                    </select>
                    <button type="submit" class="button bg-theme-1 text-white mx-5">Submit</button>
                </div>
            </form>
                
    
    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">ID</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Team ID</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
            @foreach($projectTeams as $team)
                <tr>
                    <td class="border-b">
                        <div class="font-medium whitespace-no-wrap">{{ $team->id }}</div>
                    </td>
                    <td class="text-center border-b">{{$team->team->name}}  </td>
                    <td class="border-b w-5">
                        <div class="flex sm:justify-center items-center">
                            <div class="dropdown relative">
                                <button class="dropdown-toggle button inline-block bg-theme-1 text-white" type="button" id="actionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="more-vertical" class="w-4 h-4"></i>
                                </button>
                                <div class="dropdown-box mt-10 absolute w-48 top-0 left-0 z-20">
                                    <div class="dropdown-box__content box p-2">
                                        <form action="{{ route('project.delete.team', $team->id) }}" method="POST">
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
            
        </div>
    </x-card>
@endsection
