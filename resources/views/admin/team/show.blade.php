@extends('layouts.app')
@section('content')
<!-- BEGIN: Vertical Form -->
<div class="intro-y box">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
        <h2 class="font-medium text-base mr-auto">
            Show {{ $team->name }}
        </h2>
        <div class="flex justify-end">
            <a href="{{ route('teams.edit', $team) }}" class="button flex align-center text-white bg-theme-1 shadow-md">
              <i data-feather="edit-2" class=" w-4 h-4 font-bold mr-2"></i> Edit
            </a>
        </div>
    </div>
    <div class="p-5" id="vertical-form">
        <div class="preview grid grid-cols-2">
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
                    <a href="{{ route('teams.index') }}"><button class="button bg-theme-1 text-white mt-5">Back</button></a>
                </div>
                <div>
                    <div class="mb-6">
                        <span class="font-semibold">Status</span>
                        <div class="mt-3">
                            <span class="inline-flex items-center rounded-md bg-green-200 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ $team->status }}</span>
                        </div>
                    </div>
                    <div class="mb-6">
                        <span class="font-semibold">Skill</span>
                        <div class="flex flex-wrap gap-2">
                            @if ($skill_team != null)
                            @foreach ($skill_team as $item)
                            <div class="mt-3">
                                <span class="inline-flex items-center rounded-md bg-blue-200 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                    {{ $item->name }}
                                </span>
                            </div>
                            @endforeach
                            @else
                            <div class="mt-3">
                                <span class="inline-flex items-center rounded-md bg-blue-200 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
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

<div class="intro-y box mt-5">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
        <h2 class="font-medium text-base mr-auto">
            List Project {{ $team->name }}
        </h2>
    </div>
    <div class="p-5" id="vertical-form">
        <div class="intro-y datatable-wrapper box p-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">PROJECT NAME</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">CLIENT</th>
                    {{-- <th class="border-b-2 text-center whitespace-no-wrap">PROJECT CATEGORY</th> --}}
                    <th class="border-b-2 text-center whitespace-no-wrap">FEE</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
            @if (!$projects == null)
                @foreach($projects as $key => $project)
                    <tr>
                        <td class="border-b">
                            <div class="font-medium whitespace-no-wrap">{{ $project->name }}</div>
                            <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $project->name }}</div>
                        </td>
                        <td class="w-40 border-b">
                            <div class="flex items-center sm:justify-center">
                                {{ $project->client->name }}
                            </div>
                        </td>

                        {{-- <td class="text-center border-b">{{ $project->projectType->name }}</td> --}}
                        <td class="text-center border-b">
                            @php
                                $projectTeam = App\Models\ProjectTeam::where('project_id', $project->id)
                                             ->where('team_id', $team->id)
                                             ->first();
                                $langsung = App\Models\Langsung::where('project_team_id', $projectTeam->id)->get();
                                $termin = App\Models\TerminFee::where('project_team_id', $projectTeam->id)->get();

                                $totalFeeLangsung = 0;
                                $totalFeeTermin = 0;

                                foreach ($langsung as $item) {
                                    $totalFeeLangsung += $item->fee;
                                }

                                foreach ($termin as $item) {
                                    $totalFeeTermin += $item->fee;
                                }
                            @endphp

                            @if($project->keuangan_project->type == 'langsung')
                                @if($projectTeam->fee - $totalFeeLangsung <= 0)
                                    <span class="font-medium text-theme-40">Lunas</span>
                                    <div class="text-gray-600 text-xs whitespace-no-wrap">
                                        Rp. {{ number_format($projectTeam->fee) }}
                                    </div>
                                @else
                                    <div class="font-medium whitespace-no-wrap text-theme-6">Belum Lunas</div>
                                    <div class="text-gray-600 text-xs whitespace-no-wrap">
                                        tersisa Rp. {{ number_format($projectTeam->fee - $totalFeeLangsung) }} dari {{ number_format($projectTeam->fee) }}
                                    </div>
                                @endif
                            @elseif($project->keuangan_project->type == 'termin')
                                @if($projectTeam->fee - $totalFeeTermin <= 0)
                                    <span class="font-medium text-theme-40">Lunas</span>
                                    <div class="text-gray-600 text-xs whitespace-no-wrap">
                                        Rp. {{ number_format($projectTeam->fee) }}
                                    </div>
                                @else
                                    <div class="font-medium whitespace-no-wrap text-theme-6">Belum Lunas</div>
                                    <div class="text-gray-600 text-xs whitespace-no-wrap">
                                        tersisa Rp. {{ number_format($projectTeam->fee - $totalFeeTermin) }} dari {{ number_format($projectTeam->fee) }}
                                    </div>
                                @endif
                            @else
                                -
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
                        <td class="border-b w-5">
                            <a class="flex items-center text-theme-3 mr-3" href="{{ route('project.detail', $project->slug) }}">
                                <i data-feather="eye" class="w-4 h-4 mr-1"></i> Show
                            </a>
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
<!-- END: Vertical Form -->
@endsection
