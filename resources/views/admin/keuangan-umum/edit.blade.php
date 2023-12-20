@extends('layouts.app')
@section('content')
<div class="intro-y mt-5 col-span-12 lg:col-span-6">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                Add New Pengeluaran Perusahaan
            </h2>
            <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-0">
            </div>
        </div>
        <div class="p-5" id="vertical-form">
            <form action="{{route('keuangan-umum.update', $data->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="preview">
                    <div class="mt-3">
                        <label>Description</label>
                        <input type="text" name="description" value="{{ $data->description }}" class="input w-full border mt-2 @error('description') border-theme-6 @enderror">
                        @error('description')
                            <div class="text-theme-6 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label>Total</label>
                        <input id="total" name="total" value="{{ $data->total }}" class="input w-full border mt-2 @error('total') border-theme-6 @enderror">
                        @error('total')
                            <div class="text-theme-6 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" value="{{ $tanggal }}" class="input w-full border mt-2 @error('tanggal') border-theme-6 @enderror">
                        <small>Bisa dikosongkan</small>
                        @error('tanggal')
                            <div class="text-theme-6 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="button bg-theme-1 text-white mt-5">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        var total = document.getElementById('total');
        total.addEventListener('keyup', function(e) {
            total.value = formatRupiah(this.value, 'Rp. ');
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
