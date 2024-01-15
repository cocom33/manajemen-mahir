@extends('layouts.app')
@section('title')

@section('content')

<x-card title="Detail {{ $project->name }}" :project="$detail">
    <x-tab-detail page="team" slug="{{ $project->slug }}" />
    <div class="mt-5">
        <div class="flex justify-between w-full align-center">
            <h3 class="text-xl font-bold">
                Detail Fee {{ $team->name }}
            </h3>
            <div class="flex">
                <h4 class="mr-5 text-lg font-bold">Total Fee : Rp. {{ number_format($team->fee) }}</h4>
                <h4 class="text-lg font-bold">Total Dibayar : Rp. {{ number_format($team->project_team_fee->sum('fee')) }}</h4>
            </div>
        </div>

        <div class="mt-8">
            <form action="{{ route('project.team.fee.update', [$project->slug, $team->id]) }}"
                enctype="multipart/form-data" method="POST" class="mt-3" id="formteam" x-data="activateImagePreview()">
                @csrf
                @method('PUT')
                <input type="hidden" name="team_id" value="{{ $team->id }}">
                <input type="hidden" name="project_id" value="{{$project->id}}">
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <x-form-input label="fee" name="fee" placeholder="masukkan fee" />
                    <div class="">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            for="single_file">Upload Bukti Pembayaran</label>
                        <input name="photo"
                            class="block w-full h-10.5 leading-9 rounded overflow-hidden text-sm text-gray-900 bg-gray-50 border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            id="single_file" accept="image/*" @change="showPreview(event, $refs.previewSingle)"
                            type="file">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG or JPG.</p>
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
                        <button type="submit" class="flex mt-3 text-white shadow-md button align-center bg-theme-1">
                            <i data-feather="plus" class="w-4 h-4 mt-1 mr-2 font-bold "></i> <span>Update</span>
                        </button>
                    </div>
                    <hr class="my-4">
                </form>
                @if ($show->photo != null)
                    <h3 class="text-xl font-bold">
                        Bukti Pembayaran {{ $show->name }}
                    </h3>
                    <div class="relative inline-block mt-3 border-2 border-gray-500 shadow-lg">
                        <form action="{{ route('project.team.fee.destroy', [$project->slug, $team->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="absolute top-0 right-0 px-2 py-1 text-white bg-red-500 cursor-pointer show-alert-delete-box">&times;</button>
                        </form>
                        <img src="{{ asset('bukti-pembayaran-fee/' . $show->photo) }}" alt="file"
                            class="h-48 shadow aspect-auto">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="flex mt-3 text-white shadow-md button align-center bg-theme-1">
                        <span>Tambah</span>
                    </button>
                </div>
                <hr class="my-4">
            </form>
        </div>

        <div class="p-5 mt-5 intro-y datatable-wrapper box">
                <table class="table w-full table-report table-report--bordered display datatable">
                    <thead>
                        <tr>
                            <th class="whitespace-no-wrap border-b-2">Tahap</th>
                            <th class="text-center whitespace-no-wrap border-b-2">Total Fee</th>
                            <th class="text-center whitespace-no-wrap border-b-2">Tanggal Dibayar</th>
                            <th class="text-center whitespace-no-wrap border-b-2">Photo</th>
                            <th class="text-center whitespace-no-wrap border-b-2">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($team->project_team_fee as $key => $team)
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-no-wrap">{{ $key + 1 }}</div>
                            </td>
                            <td class="text-center border-b">Rp. {{ number_format($team->fee) }}  </td>
                            <td class="text-center border-b">{{ $team->created_at->format('d / m / Y') }}  </td>
                            <td class="text-center border-b">
                                @if ($team->photo)
                                    <a href="{{ asset('images/' . $team->photo) }}" target="_blank" class="inline-block text-white button bg-theme-1" type="button">
                                        Lihat Bukti
                                    </a>
                                @else
                                    Tidak ada bukti
                                @endif
                            </td>
                            <td class="w-5 border-b">
                                <div class="flex items-center sm:justify-center">
                                    <div class="relative flex gap-1 dropdown">
                                        <form action="{{ route('project.team-fee-delete', $team->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="inline-block text-white shadow-md button bg-theme-6">
                                                <i data-feather="trash" class="w-4 h-4 font-bold "></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
    </div>
@endsection

@push('scripts')
<script>
    var fee = document.getElementById('fee');
    fee.addEventListener('keyup', function(e) {
        fee.value = formatRupiah(this.value, 'Rp. ');
    });
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
