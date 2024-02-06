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
            </div>

            <form action="{{ route('project.pengeluaran.update', [$project->slug, $pengeluaran->id]) }}" method="post" class="mt-3" id="formOther">
                @csrf
                @method('PUT')

                <x-form-input label="Deskripsi" name="title" value="{{ $pengeluaran->title ?? '-' }}" />
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <x-form-input label="Harga" name="price" placeholder="masukkan jumlah uang" addon="w-full" value="{{ $pengeluaran->price }}" />
                    <x-form-input label="Masukkan Tanggal" name="date" type="date" addon="w-full" value="{{ $pengeluaran->date }}" />
                    <div>
                        <label for="bank_id">Pilih Bank*</label>
                        <select name="bank_id" id="bank_id" class="input w-full border mt-2">
                            <option value="{{ $pengeluaran->bank_id }}" class="hidden">{{ $pengeluaran->bank->name }}</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}">
                                    {{ $bank->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Tambahkan deskripsi</label>
                    <textarea name="description" rows="5" class="mt-3 input w-full border">{{ $pengeluaran->description ?? '-' }}</textarea>
                </div>

                <div class="flex justify-end align-center mt-3 gap-3">
                    <a href="{{ route('project.pengeluaran', $project->slug) }}" class="button flex align-center text-white bg-theme-1 shadow-md">
                       <span> Kembali</span>
                    </a>
                    <button class="button flex align-center text-white bg-theme-9 shadow-md">
                        <i data-feather="edit-2" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Edit</span>
                    </button>
                </div>
            </form>
        </div>
    </x-card>
@endsection

@push('scripts')
    <script>
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
