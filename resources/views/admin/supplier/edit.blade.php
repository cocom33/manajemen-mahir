@extends('layouts.app')

@section('content')
<div class="flex items-center mt-8 intro-y">
    <h2 class="mr-auto text-lg font-medium">Edit Supplier</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="col-span-12 intro-y lg:col-span-12">
        <!-- BEGIN: Form Layout -->
        <div class="p-5 intro-y box">
            <form method="post" action="{{ route('suppliers.update', $data->id) }}">
                @csrf
                @method('PUT')
                <div>
                    <label>Nama*</label>
                    <input type="text" name="name" value="{{ $data->name }}" class="input w-full border mt-2 @error('name') border-theme-6 @enderror" placeholder="Masukkan Nama">
                    @error('name')
                        <div class="mt-2 text-theme-6">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Link</label>
                    <input type="text" name="link" value="{{ $data->link }}"  class="input w-full border mt-2 @error('link') border-theme-6 @enderror" placeholder="Masukkan Link">
                    @error('link')
                        <div class="mt-2 text-theme-6">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Catatan</label>
                    <textarea name="note" class="input w-full border mt-2 @error('note') border-theme-6 @enderror" placeholder="Catatan">{{ $data->note ? $data->note : '-' }}</textarea>
                    @error('note')
                        <div class="mt-2 text-theme-6">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Email</label>
                    <input type="text" name="email" value="{{ $data->email }}" class="input w-full border mt-2 @error('email') border-theme-6 @enderror" placeholder="Masukkan Email">
                    @error('email')
                        <div class="mt-2 text-theme-6">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Telephone</label>
                    <input type="number" name="telephone" value="{{ $data->telephone }}" class="input w-full border mt-2 @error('telephone') border-theme-6 @enderror" placeholder="Masukkan Telephone">
                    @error('telephone')
                        <div class="mt-2 text-theme-6">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="input w-full border mt-2 @error('alamat') border-theme-6 @enderror" placeholder="Alamat">{{ $data->alamat ? $data->alamat : '-' }}</textarea>
                    @error('alamat')
                        <div class="mt-2 text-theme-6">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-5 text-right">
                    <a href="{{ route('banks.index') }}"><button type="button" class="w-24 mr-1 text-gray-700 border button">Cancel</button></a>
                    <button type="submit" class="w-24 text-white button bg-theme-1">Save</button>
                </div>
            </form>
        </div>
        <!-- END: Form Layout -->
    </div>
</div>
@endsection

@push('scripts')
    <script>
        var fee = document.getElementById('price');
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
    </script>
@endpush
