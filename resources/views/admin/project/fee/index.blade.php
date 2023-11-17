@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}">
        <x-tab-detail page="fee" slug="{{ $project->slug }}" />
        <div class="mt-5">
            {{-- <livewire:project.project_fee :data="$project" /> --}}
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
                            pembayaran {{ $fee_type->type = 'langsung' ? 'langsung' : 'per termin' }}
                        </h3>
                        <div>
                            @if ($fee_type->type == 'langsung')
                                <button class="button flex align-center text-white bg-theme-1 shadow-md" onclick="formLangsung()">
                                    <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span> Tambah Fee Team</span>
                                </button>
                            @else
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
                                            <div class="flex items-center sm:justify-center">
                                                Rp. {{ number_format($item->fee) }}
                                            </div>
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
                                                <div class="dropdown relative">
                                                    <button class="dropdown-toggle button inline-block bg-theme-1 text-white" type="button" id="actionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="more-vertical" class="w-4 h-4"></i>
                                                    </button>
                                                    <div class="dropdown-box mt-10 absolute w-48 top-0 left-0 z-20">
                                                        <div class="dropdown-box__content box p-2">
                                                            <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                                                                <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> Edit
                                                            </a>
                                                            <form action="" method="POST">
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
                    @else

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
    </script>
@endpush
