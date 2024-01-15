@extends('layouts.app')
@section('content')
    <!-- BEGIN: Vertical Form -->
    <div class="intro-y box">
        <div class="flex flex-col items-center p-5 border-b border-gray-200 sm:flex-row">
            <h2 class="mr-auto text-base font-medium">
                Show {{ $team->name }}
            </h2>
            <div class="flex justify-end">
                <a href="{{ route('teams.edit', $team) }}" class="flex text-white shadow-md button align-center bg-theme-1">
                    <i data-feather="edit-2" class="w-4 h-4 mr-2 font-bold "></i> Edit
                </a>
            </div>
        </div>
        <div class="p-5" id="vertical-form">
            <div class="grid grid-cols-2 preview">
                <div>
                    <div class="mb-6">
                        <span class="font-semibold">Nama</span>
                        <p class="mt-3">{{ $team->name }}</p>
                    </div>
                    <div class="mb-6">
                        <span class="font-semibold">Email</span>
                        <p class="mt-3">{{ $team->email }}</p>
                    </div>
                    <div class="mb-6">
                        <span class="font-semibold">Phone</span>
                        <p class="mt-3">{{ $team->wa }}</p>
                    </div>
                    <a href="{{ route('teams.index') }}"><button class="mt-5 text-white button bg-theme-1">Back</button></a>
                </div>
                <div>
                    <div class="mb-6">
                        <span class="font-semibold">Status</span>
                        <div class="mt-3">
                            <span
                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-200 rounded-md ring-1 ring-inset ring-green-600/20">{{ $team->status }}</span>
                        </div>
                    </div>
                    <div class="mb-6">
                        <span class="font-semibold">Skill</span>
                        <div class="flex flex-wrap gap-2">
                            @if ($skill_team != null)
                                @foreach ($skill_team as $item)
                                    <div class="mt-3">
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-200 rounded-md ring-1 ring-inset ring-blue-700/10">
                                            {{ $item->name }}
                                        </span>
                                    </div>
                                @endforeach
                            @else
                                <div class="mt-3">
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-200 rounded-md ring-1 ring-inset ring-blue-700/10">
                                        <- BELUM PUNYA SKILL ->
                                    </span>
                                </div>
                            @endif
                        </div>

                    </div>
                    <div class="mb-6">
                        <span class="font-semibold">Alamat</span>
                        <p class="mt-3">{{ $team->alamat }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 intro-y box">
        <div class="flex flex-col items-center p-5 border-b border-gray-200 sm:flex-row">
            <h2 class="mr-auto text-base font-medium">
                List Project {{ $team->name }}
            </h2>
        </div>
        <div class="p-5" id="vertical-form">
            <div class="p-5 intro-y datatable-wrapper box">
                <table class="table w-full table-report table-report--bordered display datatable">
                    <thead>
                        <tr>
                            <th class="whitespace-no-wrap border-b-2">PROJECT NAME</th>
                            <th class="text-center whitespace-no-wrap border-b-2">CLIENT</th>
                            {{-- <th class="text-center whitespace-no-wrap border-b-2">PROJECT CATEGORY</th> --}}
                            <th class="text-center whitespace-no-wrap border-b-2">FEE</th>
                            <th class="text-center whitespace-no-wrap border-b-2">STATUS</th>
                            <th class="text-center whitespace-no-wrap border-b-2">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$projects == null)
                            @foreach ($projects as $key => $project)
                                <tr>
                                    <td class="border-b">
                                        <div class="font-medium whitespace-no-wrap">{{ $project->name }}</div>
                                        <div class="text-xs text-gray-600 whitespace-no-wrap">{{ $project->name }}</div>
                                    </td>
                                    <td class="w-40 border-b">
                                        <div class="flex items-center sm:justify-center">
                                            {{ $project->client->name }}
                                        </div>
                                    </td>

                                    <td class="text-center border-b">
                                        @php
                                            $projectTeam = $project->projectTeams->where('team_id', $team->id)->first();
                                        @endphp
                                        @if($projectTeam->fee - $projectTeam->project_team_fee->sum('fee') <= 0)
                                            <span class="font-medium text-theme-40">Lunas</span>
                                            <div class="text-xs text-gray-600 whitespace-no-wrap">
                                                Rp. {{ number_format($projectTeam->fee) }}
                                            </div>
                                        @endif
                                        @php
                                            $data = $team->projectTeam->where('project_id', $project->id)->first();
                                        @endphp
                                        @if($data->fee - $data->project_team_fee->sum('fee') <= 0)
                                            <span class="font-medium text-theme-40">Lunas</span>
                                            <div class="text-xs text-gray-600 whitespace-no-wrap">
                                                Rp. {{ number_format($data->fee) }}
                                            </div>
                                        @else
                                            <div class="font-medium whitespace-no-wrap text-theme-6">Belum Lunas</div>
                                            <div class="text-xs text-gray-600 whitespace-no-wrap">
                                                tersisa Rp. {{ number_format($data->fee - $data->project_team_fee->sum('fee')) }} dari {{ number_format($data->fee) }}
                                            </div>
                                        @endif
                                    </td>
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
                                    <td class="border-b">
                                        <div class="flex sm:justify-center items-center">
                                            <a class="flex items-center mr-3 text-theme-3"
                                                href="{{ route('project.detail', $project->slug) }}">
                                                <i data-feather="eye" class="w-4 h-4 mr-1"></i> Show
                                            </a>
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

    <div class="mt-5 intro-y box">
        <div class="flex flex-col items-center p-5 border-b border-gray-200 sm:flex-row">
            <h2 class="mr-auto text-base font-medium">
                List Keuangan Team
            </h2>
        </div>
        <div class="p-5" id="vertical-form">
                <livewire:keuangan-team id="{{ $team->id }}" />
        </div>
    </div>
    <!-- END: Vertical Form -->
@endsection
