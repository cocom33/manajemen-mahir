@extends('layouts.app')
@section('content')
<div class="intro-y mt-5 col-span-12 lg:col-span-6">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                Detail Pengeluaran
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
                        <label>Title</label>
                        <input value="{{ $data->description }}" class="input w-full border mt-2" readonly>
                    </div>

                    <div class="mt-3">
                        <label>Total</label>
                        <input value="{{ number_format($data->total) }}" class="input w-full border mt-2" readonly>
                    </div>

                    <div class="mt-3">
                        <label>Status</label>
                        <input value="{{ $data->status == 'pemasukan' ? 'pemasukan' : 'pengeluaran' }}" class="input w-full border mt-2" readonly>
                    </div>

                    <div class="mt-3">
                        <label for="supplier_id">Supplier</label>
                        <input value="{{ $data->supplier->name ?? '' }}" class="input w-full border mt-2" readonly>
                    </div>

                    <div class="mt-3">
                        <label for="bank_id">Bank</label>
                        <input value="{{ $data->bank->name ?? '' }}" class="input w-full border mt-2" readonly>
                    </div>

                    <div class="mt-3 mb-5">
                        <label>Tanggal</label>
                        <input value="{{ $data->tanggal }} / {{ $data->keuanganPerusahaan->bulan }} / {{ $data->keuanganPerusahaan->tahun }}" class="input w-full border mt-2" readonly>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('keuangan-umum.index') }}" class="button bg-theme-1 text-white mt-5">Kembali</a>
                    </div>
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
