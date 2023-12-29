@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}" :project="$detail">
        <x-tab-detail page="pengeluaran" slug="{{ $project->slug }}" />
        <div class="mt-5">
            <div class="w-full flex justify-between align-center">
                <h3 class="font-bold text-xl">
                    Pengeluaran Project
                </h3>
                <div>
                    <button class="button flex align-center text-white bg-theme-1 shadow-md" onclick="formOther()">
                        <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span> Tambah Pengeluaran</span>
                    </button>
                </div>
            </div>

            <form action="{{ route('project.pengeluaran.store', $project->slug) }}" method="post" class="hidden mt-3" id="formOther">
                @csrf

                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <x-form-input label="Deskripsi" name="title" placeholder="masukkan nama" />
                <div class="flex w-full gap-3">
                    <x-form-input label="Harga" name="price" placeholder="masukkan jumlah uang" addon="w-full" />
                    <x-form-input label="Masukkan Tanggal" name="date" type="date" addon="w-full" />
                </div>

                <div class="mb-3">
                    <label for="description">Tambahkan deskripsi</label>
                    <textarea name="description" placeholder="Tambahkan Deskripsi" id="description" rows="5" class="mt-3 input w-full border"></textarea>
                </div>

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
                            <th class="border-b-2 text-center whitespace-no-wrap">DETAIL NAME</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">BIAYA</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">TANGGAL PENGELUARAN</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($pengeluaran as $item)
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-no-wrap">{{ $item->title ?? '' }}</div>
                            </td>

                            <td class="text-center border-b">Rp. {{ number_format($item->price) }}</td>
                            <td class="text-center border-b">
                                @if ($item->tagihan_id)
                                    Tagihan
                                @elseif ($item->project_team_fee_id)
                                    Fee Team
                                @else
                                    Pengeluaran
                                @endif
                            </td>
                            <td class="text-center border-b">{{ date('d M Y', strtotime($item->date)) }}</td>
                            <td class="border-b w-5">
                                <div class="flex sm:justify-center items-center">
                                    <div class="dropdown relative flex items-center gap-1">
                                        @if ($item->tagihan_id == null && $item->project_team_fee_id  == null)
                                            <a href="{{ route('project.pengeluaran.edit', [$project->slug, $item->id]) }}" class="button inline-block text-white bg-theme-9 shadow-md">
                                              <i data-feather="edit-2" class=" w-4 h-4 font-bold"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('project.pengeluaran.show', [$project->slug, $item->id]) }}" class="button inline-block text-white bg-theme-1 shadow-md">
                                          <i data-feather="eye" class=" w-4 h-4 font-bold"></i>
                                        </a>
                                        @if ($item->tagihan_id == null && $item->project_team_fee_id == null)
                                            <form action="{{ route('project.pengeluaran.delete', [$project->slug, $item->id]) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="button inline-block text-white bg-theme-6 shadow-md show-alert-delete-box" data-toggle="tooltip" title='Delete'>
                                                    <i data-feather="trash" class=" w-4 h-4 font-bold"></i>
                                                </button>
                                            </form>
                                        @endif
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
        function formOther() {
            var form = document.getElementById('formOther');
            form.classList.toggle('hidden')
        }

        var harga = document.getElementById('Harga');
        harga.addEventListener('keyup', function(e) {
            harga.value = formatRupiah(this.value, 'Rp. ');
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
    </script>
@endpush
