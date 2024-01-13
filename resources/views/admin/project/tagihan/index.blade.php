@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}" :project="$detail">
        <x-tab-detail page="tagihan" slug="{{ $project->slug }}" />
        <div class="mt-5">
            <div class="w-full flex justify-between align-center">
                <h3 class="font-bold text-xl">
                    Tagihan Project
                </h3>
                <div>
                    <button class="button flex align-center text-white bg-theme-1 shadow-md" onclick="formSystem()">
                        <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span> Tambah Tagihan</span>
                    </button>
                </div>
            </div>

            <form action="{{ route('project.tagihan.store', $project->slug) }}" method="post" class="hidden mt-3" id="formSystem">
                @csrf

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
                            <th class="border-b-2 text-center whitespace-no-wrap">NAME</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">HARGA JUAL</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">HARGA BELI</th>
                            {{-- <th class="border-b-2 text-center whitespace-no-wrap">TANGGAL DIBELI</th> --}}
                            <th class="border-b-2 text-center whitespace-no-wrap">JATUH TEMPO</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">PEMBAYARAN</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($project->tagihan as $key => $item)
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-no-wrap">{{ $item->title ?? '' }}</div>
                            </td>

                            <td class="text-center border-b">Rp. {{ number_format($item->harga_jual) }}</td>
                            <td class="text-center border-b">Rp. {{ number_format($item->harga_beli) }}</td>
                            {{-- <td class="text-center border-b">{{ date('d / m / Y', strtotime($item->date_start)) }}</td> --}}
                            <td class="text-center border-b">{{ date('d / m / Y', strtotime($item->date_end)) }}</td>
                            <td class="text-center border-b">
                                @if ($item->is_lunas == 1)
                                    <span class="text-theme-1">Lunas</span>
                                @else
                                    <span class="text-theme-6">Belum Lunas</span>
                                @endif
                            </td>
                            <td class="text-center border-b">
                                @if ($item->is_active == 1)
                                    <span class="text-theme-1">Aktif</span>
                                @else
                                    <span class="text-theme-6">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="border-b w-5">
                                <div class="flex sm:justify-center items-center">
                                    {{-- <div class="dropdown relative">
                                        <button class="dropdown-toggle button inline-block bg-theme-1 text-white" type="button" id="actionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i data-feather="more-vertical" class="w-4 h-4"></i>
                                        </button>
                                        <div class="dropdown-box mt-10 absolute w-48 top-0 left-0 z-20">
                                            <div class="dropdown-box__content box p-2 flex items-center gap-1">
                                                <a href="{{ route('project.tagihan.edit', [$project->slug, $item->id]) }}" class="button inline-block text-white bg-theme-1 shadow-md">
                                                  <i data-feather="eye" class=" w-4 h-4 font-bold"></i>
                                                </a>
                                                <a href="{{ route('project.tagihan.detail', [$project->slug, $item->id]) }}" class="button inline-block text-white bg-theme-9 shadow-md">
                                                  <i data-feather="edit-2" class=" w-4 h-4 font-bold"></i>
                                                </a>
                                                <form action="{{ route('project.tagihan.delete', [$project->slug, $item->id]) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="button inline-block text-white bg-theme-6 shadow-md show-alert-delete-box" data-toggle="tooltip" title='Delete'>
                                                        <i data-feather="trash" class=" w-4 h-4 font-bold"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="p-2 flex items-center gap-1">
                                        <a href="{{ route('project.tagihan.detail', [$project->slug, $item->id]) }}" class="button inline-block text-white bg-theme-1 shadow-md">
                                          <i data-feather="eye" class=" w-4 h-4 font-bold"></i>
                                        </a>
                                        @if ($item->is_finish == 0)
                                            <a href="{{ route('project.tagihan.edit', [$project->slug, $item->id]) }}" class="button inline-block text-white bg-theme-9 shadow-md">
                                              <i data-feather="edit-2" class=" w-4 h-4 font-bold"></i>
                                            </a>
                                            <form action="{{ route('project.tagihan.delete', [$project->slug, $item->id]) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $item->id }}">
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
        function formSystem() {
            var form = document.getElementById('formSystem');
            form.classList.toggle('hidden')
        }
        function formOther() {
            var form = document.getElementById('formOther');
            form.classList.toggle('hidden')
        }

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
