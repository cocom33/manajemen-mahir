@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}" :project="$detail">
        <x-tab-detail page="team" slug="{{ $project->slug }}" />
            <form action="{{route('project.add.team', $project->slug)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="mt-5 flex flex-wrap sm:flex-no-wrap gap-3 w-full mb-3">
                    <div class="flex flex-col w-full">
                        <select data-placeholder="Pilih Team" name="team_id[]" class="select2 w-full border" multiple>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}"> {{ $team->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="button bg-theme-1 text-white px-5">Submit</button>
                </div>
                <div class="flex justify-end">
                </div>
            </form>


            <div class="intro-y datatable-wrapper box p-5 mt-5">
                <table class="table table-report table-report--bordered display datatable w-full">
                    <thead>
                        <tr>
                            <th class="border-b-2 whitespace-no-wrap">No</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">Team Name</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">Total Fee</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">Jumlah Dibayar</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($projectTeams as $key => $team)
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-no-wrap">{{ $key + 1 }}</div>
                            </td>
                            <td class="text-center border-b">{{ $team->team->name }}  </td>
                            <td class="text-center border-b">
                                <span id="fee{{ $key }}">{{ $team->fee ? 'Rp. ' . number_format($team->fee) : '-' }}</span>
                                <form action="{{ route('project.edit.team', $project->slug) }}" method="post" id="formEdit{{ $key }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $team->id }}" label="">
                                    <input name="fee" id="inputFee{{ $key }}" class="hidden input w-full border" value="{{ $team->fee ?? 0 }}">
                                </form>
                            </td>
                            <td class="text-center border-b">Rp. {{ number_format($team->project_team_fee->where('status', 1)->sum('fee')) }}  </td>
                            <td class="border-b w-5">
                                <div class="flex sm:justify-center items-center">
                                    <div class="dropdown relative flex gap-1">
                                        <button id="save{{ $key }}" form="formEdit{{ $key }}" type="submit" class="hidden button inline-block bg-theme-1 text-white" type="button" id="actionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i data-feather="save" class="w-4 h-4"></i>
                                        </button>
                                        <button id="x{{ $key }}" onclick="editTeam{{ $key }}()" class="hidden button inline-block text-white bg-theme-6 shadow-md">
                                            <i data-feather="x" class=" w-4 h-4 font-bold"></i>
                                        </button>
                                        <button id="editButton{{ $key }}" onclick="editTeam{{ $key }}()" class="button inline-block bg-theme-9 text-white" type="button" id="actionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i data-feather="edit-2" class="w-4 h-4"></i>
                                        </button>
                                        <a href="{{ route('project.teams.show', [$project->slug, $team->id]) }}">
                                            <button class="button inline-block bg-theme-10 text-white" type="button" id="actionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i data-feather="eye" class="w-4 h-4"></i>
                                            </button>
                                        </a>
                                        {{-- <a href="{{ route('project.teams.show', [$project->slug, $team->team_id]) }}">
                                            <button class="button inline-block bg-theme-10 text-white" type="button" id="actionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i data-feather="eye" class="w-4 h-4"></i>
                                            </button>
                                          </a>

                                        <form action="{{ route('project.delete.team', [$project->slug, $team->team_id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button id="delete{{ $key }}" type="submit" class="button inline-block text-white bg-theme-6 shadow-md show-alert-delete-box" data-toggle="tooltip" title='Delete'>
                                                <i data-feather="trash" class=" w-4 h-4 font-bold"></i>
                                            </button>
                                        </form> --}}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-no-wrap">{{ $projectTeams->count() + 1 }}</div>
                            </td>
                            <td class="text-center border-b">Perusahaan </td>
                            <td class="text-center border-b"> - </td>
                            <td class="text-center border-b">
                                @if ($project->harga_deal)
                                    @if ($project->type_pajak === 0)
                                        Rp. {{ number_format($project->harga_deal - $detail['belanja'] - ($project->pajak * $project->harga_deal / 100)) }}
                                    @elseif ($project->type_pajak === 1)
                                        Rp. {{ number_format($project->harga_deal - $detail['belanja'] + ($project->pajak * $project->harga_deal / 100)) }}
                                    @else
                                        Rp. {{ number_format($project->harga_deal - $detail['belanja']) }}
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td class="border-b w-5 text-center">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </x-card>
@endsection

@push('scripts')
    <script>
        @foreach($projectTeams as $key => $team)
            function editTeam{{ $key }}() {
                document.getElementById('fee{{ $key }}').classList.toggle('hidden')
                document.getElementById('inputFee{{ $key }}').classList.toggle('hidden')
                document.getElementById('save{{ $key }}').classList.toggle('hidden')
                document.getElementById('x{{ $key }}').classList.toggle('hidden')
                document.getElementById('editButton{{ $key }}').classList.toggle('hidden')
                document.getElementById('delete{{ $key }}').classList.toggle('hidden')
            }
        @endforeach

        @foreach($projectTeams as $key => $team)
            var fee{{ $key }} = document.getElementById('inputFee{{ $key }}');
            fee{{ $key }}.addEventListener('keyup', function(e) {
                fee{{ $key }}.value = formatRupiah(this.value, 'Rp. ');
            });
        @endforeach

        function formatRupiah(number, prefix) {
          var number_string = number.replace(/[^,\d]/g, '').toString(),
              split = number_string.split(','),
              remainder = split[0].length % 3,
              rupiah = split[0].substr(0, remainder),
              ribuan = split[0].substr(remainder).match(/\d{3}/gi);

          if (ribuan) {
              separator = remainder ? '.' : '';
              rupiah += separator + ribuan.join('.');
          }

          rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
          return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>
@endpush
