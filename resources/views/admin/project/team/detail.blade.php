@extends('layouts.app')
@section('title')

@section('content')

    <x-card title="Detail {{ $project->name }}" :project="$detail">
        <x-tab-detail page="team" slug="{{ $project->slug }}" />
        <div class="mt-5">
            <div class="w-full flex justify-between align-center">
                <h3 class="font-bold text-xl">
                    Detail {{ $team->name }}
                </h3>
            </div>

            <div class="mt-8">
                <form action="{{ route('project.team.fee.update', [$project->slug, $team->id]) }}"
                    enctype="multipart/form-data" method="POST" class="mt-3" id="formteam" x-data="activateImagePreview()">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="team_id" value="{{ $team->id }}">
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        {{-- <x-form-input label="Nama team" name="name" value="{{ $team->name }}"
                        placeholder="masukkan nama team" /> --}}
                        @if (!$show)
                            <x-form-input label="fee" name="fee" type="number" placeholder="masukkan fee" />
                            <x-form-input type="date" label="Tanggal Penagihan" name="tanggal_bayar" />
                        @else
                            <x-form-input label="fee" name="fee" type="number" value="{{ $show->fee }}"
                                placeholder="masukkan fee" />
                            <x-form-input type="date" label="Tanggal Penagihan" value="{{ $show->tanggal_bayar }}"
                                name="tanggal_bayar" />
                        @endif

                    </div>

                    @if ($show->photo == null)
                        <div class="mt-3 ">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                for="single_file">Upload Bukti Pembayaran</label>
                            <input name="photo"
                                class="block w-full h-10.5 leading-9 rounded overflow-hidden text-sm text-gray-900 bg-gray-50 border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                id="single_file" accept="image/*" @change="showPreview(event, $refs.previewSingle)"
                                type="file">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG or JPG.</p>
                        </div>
                        <div x-ref="previewSingle" class="mt-2">
                        </div>
                    @endif

                    <div class="flex justify-end">
                        <button type="submit" class="button flex align-center text-white bg-theme-1 shadow-md mt-3">
                            <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Update</span>
                        </button>
                    </div>
                    <hr class="my-4">
                </form>
                @if ($show->photo != null)
                    <h3 class="font-bold text-xl">
                        Bukti Pembayaran {{ $show->name }}
                    </h3>
                    <div class="relative inline-block mt-3 shadow-lg border-2 border-gray-500">
                        <form action="{{ route('project.team.fee.destroy', [$project->slug, $team->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="show-alert-delete-box absolute cursor-pointer top-0 right-0 px-2 py-1 text-white bg-red-500">&times;</button>
                        </form>
                        <img src="{{ asset('bukti-pembayaran-fee/' . $show->photo) }}" alt="file"
                            class="aspect-auto h-48 shadow">
                    </div>
                @endif
            </div>
        </div>
    </x-card>

    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">ID</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Team Name</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Team Fee</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($projectTeams as $key => $team)
                    <tr>
                        <td class="border-b">
                            <div class="font-medium whitespace-no-wrap">{{ $key + 1 }}</div>
                        </td>
                        <td class="text-center border-b">{{ $team->team->name }} </td>
                        <td class="text-center border-b">
                            <span
                                id="fee{{ $key }}">{{ $team->fee ? 'Rp. ' . number_format($team->fee) : '-' }}</span>
                            <form action="{{ route('project.edit.team', $project->slug) }}" method="post"
                                id="formEdit{{ $key }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $team->id }}" label="">
                                <input name="fee" id="inputFee{{ $key }}" class="hidden input w-full border"
                                    value="{{ $team->fee ?? 0 }}">
                            </form>
                        </td>
                        <td class="border-b w-5">
                            <div class="flex sm:justify-center items-center">
                                <div class="dropdown relative flex gap-1">
                                    <a href="{{ route('project.teams.show', [$project->slug, $team->team_id]) }}">
                                        <button class="button inline-block bg-theme-10 text-white" type="button"
                                            id="actionMenu" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i data-feather="eye" class="w-4 h-4"></i>
                                        </button>
                                    </a>

                                    <form action="{{ route('project.delete.team', [$project->slug, $team->team_id]) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button id="delete{{ $key }}" type="submit"
                                            class="button inline-block text-white bg-theme-6 shadow-md show-alert-delete-box"
                                            data-toggle="tooltip" title='Delete'>
                                            <i data-feather="trash" class=" w-4 h-4 font-bold"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        function activateImagePreview() {
            return {
                previews: [],

                showPreview(event, previewBox) {
                    previewBox.replaceChildren();
                    this.previews = [];

                    for (const i in event.target.files) {
                        const file = event.target.files[i];
                        const isImage = file.type.startsWith('image/');
                        const isPdf = file.type === 'application/pdf';

                        if (isImage || isPdf) {
                            this.createPreview(file, previewBox);
                        }
                    }
                },

                createPreview(file, previewBox) {
                    let previewItem = document.createElement('div');
                    previewItem.className = 'relative inline-block';

                    if (file.type.startsWith('image/')) {
                        let img = document.createElement('img');
                        img.className = 'aspect-auto h-32 shadow';
                        img.src = URL.createObjectURL(file);
                        previewItem.appendChild(img);
                    } else if (file.type === 'application/pdf') {
                        let iframe = document.createElement('iframe');
                        iframe.className = 'aspect-auto h-32 shadow';
                        iframe.src = URL.createObjectURL(file);
                        previewItem.appendChild(iframe);
                    }

                    let removeButton = document.createElement('button');
                    removeButton.innerHTML = '&times;';
                    removeButton.className = 'absolute top-0 right-0 px-2 py-1 text-white bg-red-500';
                    removeButton.addEventListener('click', () => this.removePreview(previewItem));
                    previewItem.appendChild(removeButton);

                    previewBox.appendChild(previewItem);
                    this.previews.push(previewItem);
                },

                removePreview(previewItem) {
                    this.previews = this.previews.filter(item => item !== previewItem);
                    previewItem.remove();
                }
            };
        }
    </script>
@endpush
