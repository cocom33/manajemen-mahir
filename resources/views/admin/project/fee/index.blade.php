@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}">
        <x-tab-detail page="fee" slug="{{ $project->slug }}" />
        <div class="mt-5">
            <div>
                @if (!$fee_type)
                    <form action="{{ route('project.fee.create', $project->slug) }}" method="post">
                        @csrf
                        <div class="w-full">
                            <label for="">Pilih Type Pembayaran</label>
                            <select name="type" class="input w-full border mt-2">
                                <option value="termin">Termin</option>
                                <option value="langsung">Langsung</option>
                            </select>

                            <input type="hidden" name="project_id" value="{{ $project->id }}" />
                        </div>
                        <div class="flex justify-end mt-3">
                            <button class="button flex align-center text-white bg-theme-1 shadow-md">
                                <i data-feather="plus" class=" w-4 h-4 font-bold mr-2"></i> <span>Tambah Pembayaran</span>
                            </button>
                        </div>
                    </form>
                @else
                    <div class="w-full flex justify-between align-center">
                        <h3 class="font-bold text-xl">
                            pembayaran {{ $fee_type->type == 'langsung' ? 'langsung' : 'per termin' }}
                        </h3>
                        <div>
                            @if ($fee_type->type == 'langsung')
                                <button class="button flex align-center text-white bg-theme-1 shadow-md" onclick="formLangsung()">
                                    <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span> Tambah Fee Team</span>
                                </button>
                            @else
                                <button class="button flex align-center text-white bg-theme-1 shadow-md" onclick="formTermin()">
                                    <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span> Tambah Termin</span>
                                </button>
                            @endif
                        </div>
                    </div>
                    @if ($fee_type->type == 'langsung')
                        <form action="{{ route('project.fee.langsung.store', $project->slug) }}" method="post" class="hidden mt-3" id="form">
                            @csrf
                            <input type="hidden" name="keuangan_project_id" value="{{ $fee_type->id }}">
                            <label for="project_team_id">Pilih Team</label>
                            <select name="project_team_id" id="project_team_id" class="input w-full border mt-2 mb-3">
                                @foreach ($project_teams as $item)
                                    <option value="{{ $item->id }}">{{ $item->team->name }}</option>
                                @endforeach
                            </select>
                            <x-form-input label="Fee" name="fee" placeholder="masukkan fee" type="number" />

                            <div class="flex justify-end">
                                <button class="button flex align-center text-white bg-theme-1 shadow-md mt-3">
                                    <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Tambah</span>
                                </button>
                            </div>
                            <hr class="my-4">
                        </form>

                        <div class="mt-8">
                            <table class="table table-report table-report--bordered display datatable w-full">
                                <thead>
                                    <tr>
                                        <th class="border-b-2 text-center whitespace-no-wrap">TEAM NAME</th>
                                        <th class="border-b-2 text-center whitespace-no-wrap">FEE</th>
                                        <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                                        <th class="border-b-2 text-center whitespace-no-wrap">TANGGAL</th>
                                        <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($fee_langsung as $item)
                                    <tr>
                                        <td class="border-b">
                                            <div class="font-medium whitespace-no-wrap">{{ $item->projectTeam->team->name ?? '' }}</div>
                                        </td>
                                        <td class="w-40 border-b">
                                            <div id="fieldFee{{ $item->id }}" class="flex items-center sm:justify-center">
                                                Rp. {{ number_format($item->fee) }}
                                            </div>
                                            <form action="{{ route('project.fee.langsung.store', $project->slug) }}" method="POST" id="edit_fee{{ $item->id }}">
                                                @csrf
                                                @method('PUT')
                                                <input id="inputFee{{ $item->id }}" type="number" name="fee" class="hidden input w-full border" value="{{ $item->fee }}">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                            </form>
                                        </td>

                                        <td class="text-center border-b">
                                            @if ($item->fee > $item->projectTeam->fee)
                                                <span class="text-theme-40">Lunas</span>
                                            @else
                                                <span class="text-theme-6">Tidak</span>
                                            @endif
                                        </td>
                                        <td class="text-center border-b">{{ $item->created_at->format('d M Y') }}</td>
                                        <td class="border-b w-5">
                                            <div class="flex sm:justify-center items-center">
                                                <div class="dropdown relative flex items-center gap-1">
                                                    <button id="buttonEdit{{ $item->id }}" form="edit_fee{{ $item->id }}" type="submit" class="hidden button inline-block text-white bg-theme-1 shadow-md">
                                                      <i data-feather="save" class="w-4 h-4 font-bold"></i>
                                                    </button>
                                                    <a id="edit{{ $item->id }}" onclick="EditFee{{ $item->id }}()" type="button" class="button inline-block text-white bg-theme-9 shadow-md">
                                                      <i data-feather="edit-2" class="w-4 h-4 font-bold"></i>
                                                    </a>
                                                    <a id="close{{ $item->id }}" onclick="EditFee{{ $item->id }}()" type="button" class="hidden button inline-block text-white bg-theme-6 shadow-md">
                                                      <i data-feather="x" class=" w-4 h-4 font-bold"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <form action="{{ route('project.fee.termin.store', $project->slug) }}" method="post" class="hidden mt-3" id="formTermin">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="keuangan_project_id" value="{{ $fee_type->id }}">
                            <x-form-input label="Nama Termin" name="name" placeholder="masukkan nama termin" />

                            <div class="flex justify-end">
                                <button class="button flex align-center text-white bg-theme-1 shadow-md mt-3">
                                    <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Tambah</span>
                                </button>
                            </div>
                            <hr class="my-4">
                        </form>

                        <div class="mt-8">
                            <table class="table table-report table-report--bordered display datatable w-full">
                                <thead>
                                    <tr>
                                        <th class="border-b-2 text-center whitespace-no-wrap">TERMIN NAME</th>
                                        <th class="border-b-2 text-center whitespace-no-wrap">TOTAL FEE</th>
                                        <th class="border-b-2 text-center whitespace-no-wrap">TANGGAL</th>
                                        <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($termin as $item)
                                    <tr>
                                        <td class="border-b">
                                            <div id="fieldFeeTermin{{ $item->id }}" class="font-medium whitespace-no-wrap">{{ $item->name ?? '' }}</div>
                                            <form action="{{ route('project.fee.termin.store', $project->slug) }}" method="POST" id="edit_feeTermin{{ $item->id }}">
                                                @csrf
                                                @method('PUT')
                                                <input id="inputFeeTermin{{ $item->id }}" name="name" class="hidden input w-full border" value="{{ $item->name }}">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                            </form>
                                        </td>

                                        <td class="text-center border-b">Rp. {{ number_format($item->termin_fee->sum('fee')) }}</td>
                                        <td class="text-center border-b">{{ $item->created_at->format('d M Y') }}</td>
                                        <td class="border-b w-5">
                                            <div class="flex sm:justify-center items-center">
                                                <div class="dropdown relative flex items-center gap-1">
                                                    <button id="buttonEditTermin{{ $item->id }}" form="edit_feeTermin{{ $item->id }}" type="submit" class="hidden button inline-block text-white bg-theme-1 shadow-md">
                                                      <i data-feather="save" class="w-4 h-4 font-bold"></i>
                                                    </button>
                                                    <a id="editTermin{{ $item->id }}" onclick="EditFeeTermin{{ $item->id }}()" type="button" class="button inline-block text-white bg-theme-9 shadow-md">
                                                      <i data-feather="edit-2" class="w-4 h-4 font-bold"></i>
                                                    </a>
                                                    <a id="closeTermin{{ $item->id }}" onclick="EditFeeTermin{{ $item->id }}()" type="button" class="hidden button inline-block text-white bg-theme-6 shadow-md">
                                                      <i data-feather="x" class=" w-4 h-4 font-bold"></i>
                                                    </a>
                                                    <a id="showTermin{{ $item->id }}" href="{{ route('project.fee.termin.detail', [$project->slug, $item->slug]) }}" type="button" class="button inline-block text-white bg-theme-1 shadow-md">
                                                      <i data-feather="eye" class=" w-4 h-4 font-bold"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </x-card>
@endsection

@push('scripts')
    <script>
        function formLangsung() {
            var form = document.getElementById('form');
            form.classList.toggle('hidden')
        }
        function formTermin() {
            var form = document.getElementById('formTermin');
            form.classList.toggle('hidden')
        }

        @if ($fee_type && $fee_type->type == 'langsung')
            @foreach($fee_langsung as $item)
                function EditFee{{ $item->id }}() {
                    var field{{ $item->id }} = document.getElementById('fieldFee{{ $item->id }}');
                    var input{{ $item->id }} = document.getElementById('inputFee{{ $item->id }}');
                    var button{{ $item->id }} = document.getElementById('buttonEdit{{ $item->id }}');
                    var close{{ $item->id }} = document.getElementById('close{{ $item->id }}');
                    var edit{{ $item->id }} = document.getElementById('edit{{ $item->id }}');

                    input{{ $item->id }}.classList.toggle('hidden');
                    field{{ $item->id }}.classList.toggle('hidden');
                    button{{ $item->id }}.classList.toggle('hidden');
                    close{{ $item->id }}.classList.toggle('hidden');
                    edit{{ $item->id }}.classList.toggle('hidden');
                }
            @endforeach
        @endif
        @if ($fee_type && $fee_type->type == 'termin')
            @foreach($termin as $item)
                function EditFeeTermin{{ $item->id }}() {
                    var field{{ $item->id }} = document.getElementById('fieldFeeTermin{{ $item->id }}');
                    var input{{ $item->id }} = document.getElementById('inputFeeTermin{{ $item->id }}');
                    var button{{ $item->id }} = document.getElementById('buttonEditTermin{{ $item->id }}');
                    var close{{ $item->id }} = document.getElementById('closeTermin{{ $item->id }}');
                    var edit{{ $item->id }} = document.getElementById('editTermin{{ $item->id }}');
                    var show{{ $item->id }} = document.getElementById('showTermin{{ $item->id }}');

                    input{{ $item->id }}.classList.toggle('hidden');
                    field{{ $item->id }}.classList.toggle('hidden');
                    button{{ $item->id }}.classList.toggle('hidden');
                    close{{ $item->id }}.classList.toggle('hidden');
                    edit{{ $item->id }}.classList.toggle('hidden');
                    show{{ $item->id }}.classList.toggle('hidden');
                }
            @endforeach
        @endif
    </script>
@endpush
