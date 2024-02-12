@extends('layouts.app')
@section('title')

@section('content')

<x-card title="Detail {{ $project->name }}" :project="$detail">
    <x-tab-detail page="team" slug="{{ $project->slug }}" />
    <div class="mt-5">
        <div class="flex justify-between w-full align-center">
            <h3 class="text-xl font-bold">
                Detail Fee {{ $team->team->name }}
            </h3>
            <div class="flex">
                <h4 class="mr-5 text-lg font-bold">Total Fee : Rp. {{ number_format($team->fee) }}</h4>
                <h4 class="text-lg font-bold">Total Dibayar : Rp. {{ number_format($team->project_team_fee->where('status', 1)->sum('fee')) }}</h4>
            </div>
        </div>

        <div class="mt-8">
            <form action="{{ route('project.team.fee.update', [$project->slug, $team->id]) }}"
                enctype="multipart/form-data" method="POST" class="mt-3" id="formteam" x-data="activateImagePreview()">
                @csrf
                @method('PUT')
                <input type="hidden" name="team_id" value="{{ $team->id }}">
                <input type="hidden" name="detail_team_id" value="{{ $team->team_id }}">
                <input type="hidden" name="project_id" value="{{$project->id}}">
                <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
                    <x-form-input label="fee" name="fee" placeholder="masukkan fee" />
                    <x-form-input label="Tanggal Pemberian" name="tenggat" type="date" placeholder="" />
                    <div class="">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            for="single_file">Upload Bukti Pembayaran</label>
                        <input name="photo"
                            class="block w-full h-10.5 leading-9 rounded overflow-hidden text-sm text-gray-900 bg-gray-50 border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            id="single_file" accept="image/*" @change="showPreview(event, $refs.previewSingle)"
                            type="file">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG or JPG.</p>
                    </div>
                    <div class="mb-4">
                        <label for="nasabah_kantor" class="block mb-2 font-medium text-gray-700">Rekening Kantor*</label>
                        {{-- <input type="text" id="nasabah_kantor" name="nasabah_kantor" class="w-full p-2 border border-gray-400 rounded"> --}}
                        <select name="nasabah_kantor" data-hide-search="true" class="w-full select2 border-theme-6" required>
                            <option disabled>Pilih Rekening</option>
                            @foreach ($banks as $skill)
                            <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                            @endforeach
                        </select>
                      </div>

                      <div class="mb-4">
                        <label for="nasabah_team" class="block mb-2 font-medium text-gray-700">Rekening Team @if (!$team->team->nasabah)*@endif</label>
                        <input type="text" id="nasabah_team" name="nasabah_team" class="w-full p-2 border border-gray-400 rounded" @if (!$team->team->nasabah) required *@endif>
                        @if ($team->team->nasabah)
                        <small>jikalau tidak diisi akan terisi {{ $team->team->nasabah }}</small>
                        @else
                        <small>Wajib Diisi</small>
                        @endif
                      </div>
                </div>

                <div class="flex justify-end mt-3">
                    <div class="flex items-center justify-end mr-3">
                        <input type="checkbox" name="lunas" id="lunas" class="mr-1">
                        <label for="lunas">Tandai Lunas</label>
                    </div>
                    <button type="submit" class="flex text-white shadow-md button align-center bg-theme-1">
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
                        <th class="text-center whitespace-no-wrap border-b-2">Tanggal Pemberian</th>
                        <th class="text-center whitespace-no-wrap border-b-2">Status</th>
                        <th class="text-center whitespace-no-wrap border-b-2">Nasabah Kantor</th>
                        <th class="text-center whitespace-no-wrap border-b-2">Nasabah Team</th>
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
                        <td class="text-center border-b">{{ $team->tenggat }}  </td>
                        <td class="text-center border-b">{{ $team->status == 1 ? 'Lunas' : 'Belum Lunas' }}  </td>
                        <td class="text-center border-b">{{ optional(App\Models\Bank::find($team->nasabah_kantor))->name }}</td>
                        <td class="text-center border-b">{{ $team->nasabah_team  }} </td>
                        <td class="text-center border-b">
                            @if ($team->status)
                                @if ($team->photo)
                                    <a href="{{ asset('storage/' . $team->photo) }}" target="_blank" class="inline-block text-white button bg-theme-1" type="button">
                                        Lihat Bukti
                                    </a>
                                @else
                                    Tidak ada bukti
                                @endif
                            @else
                                <span id="none{{ $team->id }}">-</span>
                                <form action="{{ route('project.team.lunas', [$project->slug, $team->id]) }}" id="formLunas{{ $team->id }}" enctype="multipart/form-data" style="max-width: 140px" class="hidden" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                                    <input type="file" name="photo" id="image{{ $team->id }}" accept="image/png, image/jpeg, image/jpg, image/gif" class="block w-full h-10.5 leading-9 rounded overflow-hidden text-sm text-gray-900 bg-gray-50 border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                                </form>
                            @endif
                        </td>
                        <td class="w-5 border-b">
                            <div class="flex items-center sm:justify-center">
                                <div class="relative flex gap-1 dropdown">
                                    @if (!$team->status)
                                        <a id="key{{ $team->id }}" onclick="showForm{{ $team->id }}()" class="inline-block text-white shadow-md button bg-theme-1">
                                            <i data-feather="key" class="w-4 h-4 font-bold "></i>
                                        </a>
                                        <button id="store{{ $team->id }}" class="hidden inline-block text-white shadow-md button bg-theme-1" form="formLunas{{ $team->id }}">
                                            <i data-feather="check" class="w-4 h-4 font-bold "></i>
                                        </button>
                                    @endif
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
</x-card>
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

    @foreach($fee as $key => $team)
        function showForm{{ $team->id }}() {
            document.getElementById("store{{ $team->id }}").classList.remove('hidden')
            document.getElementById("key{{ $team->id }}").classList.add('hidden')
            document.getElementById("none{{ $team->id }}").classList.add('hidden')
            document.getElementById("formLunas{{ $team->id }}").classList.remove('hidden')
        }
    @endforeach

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
