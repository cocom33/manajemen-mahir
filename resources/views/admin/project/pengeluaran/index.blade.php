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
                <div class="flex gap-2">
                    <button class="button flex align-center text-white bg-theme-1 shadow-md" onclick="formSystem()">
                        <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span> Buat Tagihan</span>
                    </button>
                    <button class="button flex align-center text-white bg-theme-1 shadow-md" onclick="formOther()">
                        <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span> Buat Pengeluaran</span>
                    </button>
                </div>
            </div>

            <form action="{{ route('project.pengeluaran.store', $project->slug) }}" method="post" class="hidden mt-3" id="formOther">
                @csrf
                <h3 class="font-bold text-lg mb-3">Buat Pengeluaran</h3>

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

            <form action="{{ route('project.tagihan.store', $project->slug) }}" method="post" class="hidden mt-3" id="formSystem">
                @csrf
                <h3 class="font-bold text-lg mb-3">Buat Tagihan</h3>

                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <x-form-input label="Nama" name="title" placeholder="masukkan nama" />
                <div class="flex w-full gap-3">
                    <x-form-input label="Harga Jual" name="harga_jual" placeholder="masukkan jumlah uang" addon="w-full" pesan="jumlah harga yang diberikan ke client" />
                    <x-form-input label="Harga Beli" name="harga_beli" placeholder="masukkan jumlah uang" addon="w-full" pesan="jumlah harga yang dikeluarkan" />
                    <x-form-input label="Masukkan Jumlah" name="total" value="1" placeholder="masukkan total barang" type="number" addon="w-full" />
                </div>

                <div class="flex w-full gap-3">
                    <x-form-input label="Masukkan waktu Pembelian" name="date_start" type="date" addon="w-full" />
                    <x-form-input label="Masukkan waktu Jatuh Tempo" name="date_end" type="date" addon="w-full" />
                </div>

                <div class="mt-3">
                    <label for="description">Masukkan deskripsi/catatan Tagihan</label>
                    <textarea name="description" id="description" rows="8" class="mt-3 input w-full border"></textarea>
                </div>

                <div class="flex justify-end items-center gap-2 mt-3">
                    <div class="flex items-center mr-3">
                        <input type="checkbox" name="lunas" id="lunas" class="mr-1">
                        <label for="lunas">Tandai Lunas</label>
                    </div>
                    <button class="button flex align-center text-white bg-theme-1 shadow-md ">
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
                    @foreach($pengeluaran as $key => $item)
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-no-wrap"><span class="hidden">{{ $key }}</span>{{ $item->title }}</div>
                            </td>
                            <td class="text-center border-b">
                                @if ($item->tagihan_id)
                                    <div class="font-medium text-xs whitespace-no-wrap">Beli : Rp. {{ number_format($item->tagihan->harga_beli) }}</div>
                                    <div class="font-medium text-xs whitespace-no-wrap">Jual : Rp. {{ number_format($item->tagihan->harga_jual) }}</div>
                                @else
                                    Rp. {{ number_format($item->price) }}
                                @endif
                            </td>
                            <td class="text-center border-b">
                                @if ($item->tagihan_id)
                                    <div class="font-medium whitespace-no-wrap">Tagihan</div>
                                    @if ($item->tagihan->is_lunas == 0)
                                        <span class="text-xs whitespace-no-wrap">status : <span class="text-theme-6">belum lunas</span> </span>
                                    @else
                                        <span class="text-xs whitespace-no-wrap">status : <span class="text-theme-1">lunas</span></span>
                                    @endif
                                @elseif ($item->project_team_fee_id)
                                    <div class="font-medium">
                                        Fee Team
                                    </div>
                                @else
                                    <div class="font-medium">
                                        Pengeluaran
                                    </div>
                                @endif
                            </td>
                            <td class="text-center border-b">
                                @if ($item->tagihan_id)
                                    <div class="font-medium text-xs whitespace-no-wrap">Tanggal Beli : {{ date('d M Y', strtotime($item->tagihan->date_start)) }}</div>
                                    <div class="font-medium text-xs whitespace-no-wrap">Jatuh Tempo : {{ date('d M Y', strtotime($item->tagihan->date_end)) }}</div>
                                @else
                                    {{ date('d M Y', strtotime($item->date)) }}
                                @endif
                            </td>
                            <td class="border-b w-5">
                                <div class="flex sm:justify-center items-center">
                                    <div class="dropdown relative flex items-center gap-1">
                                        @if ($item->tagihan_id == null && $item->project_team_fee_id  == null)
                                            <a href="{{ route('project.pengeluaran.edit', [$project->slug, $item->id]) }}" class="button inline-block text-white bg-theme-9 shadow-md">
                                              <i data-feather="edit-2" class=" w-4 h-4 font-bold"></i>
                                            </a>
                                        @endif
                                        @if ($item->tagihan_id)
                                            <a href="{{ route('project.tagihan.detail', [$project->slug, $item->tagihan->id]) }}" class="button inline-block text-white bg-theme-1 shadow-md">
                                              <i data-feather="eye" class=" w-4 h-4 font-bold"></i>
                                            </a>
                                        @elseif ($item->project_team_fee_id)
                                            <a href="{{ route('project.teams.show', [$project->slug, $item->projectTeamFee->projectTeam->team_id]) }}" class="button inline-block text-white bg-theme-1 shadow-md">
                                              <i data-feather="eye" class=" w-4 h-4 font-bold"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('project.pengeluaran.show', [$project->slug, $item->id]) }}" class="button inline-block text-white bg-theme-1 shadow-md">
                                              <i data-feather="eye" class=" w-4 h-4 font-bold"></i>
                                            </a>
                                        @endif
                                        @if ($item->tagihan_id == null && $item->project_team_fee_id == null)
                                            <form action="{{ route('project.pengeluaran.delete', [$project->slug, $item->id]) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="button inline-block text-white bg-theme-6 shadow-md show-alert-delete-box" data-toggle="tooltip" title='Delete'>
                                                    <i data-feather="trash-2" class=" w-4 h-4 font-bold"></i>
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
        var pengeluaran = document.getElementById('formOther');
        var form = document.getElementById('formSystem');
        function formOther() {
            pengeluaran.classList.toggle('hidden')
            form.classList.add('hidden')
        }
        function formSystem() {
            form.classList.toggle('hidden')
            pengeluaran.classList.add('hidden')
        }

        var harga = document.getElementById('Harga');
        harga.addEventListener('keyup', function(e) {
            harga.value = formatRupiah(this.value, 'Rp. ');
        });
        var fee = document.getElementById('Harga Beli');
        fee.addEventListener('keyup', function(e) {
            fee.value = formatRupiah(this.value, 'Rp. ');
        });

        var asli = document.getElementById('Harga Jual');
        asli.addEventListener('keyup', function(e) {
            asli.value = formatRupiah(this.value, 'Rp. ');
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
