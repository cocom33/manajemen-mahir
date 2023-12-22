@extends('layouts.app')
@section('title')

@section('content')
<x-card title="Detail {{ $project->name }}" :project="$detail">
    <x-tab-detail page="team" slug="{{ $project->slug }}" />
        <div class="mt-5">
            <div class="w-full flex justify-between align-center">
                <h3 class="font-bold text-xl">
                    Detail Team {{$team->name}}
                </h3>
            </div>

            <div class="mt-8">
                <form action="{{ route('project.fee.termin.detail.store', [$project->slug, $team->id]) }}" method="post" class="mt-3" id="formFee">
                  @csrf 
                  @method('PUT')
                  
                  <input type="hidden" name="id" value="">
                  
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <x-form-input label="Fee" name="fee" value="" placeholder="masukkan jumlah fee"/>  
                    <x-form-input type="date" label="Tanggal Pembayaran" value="" name="tanggal"/>
                  </div>
                  
                  <div class="flex justify-end">
                    <button class="button flex align-center text-white bg-theme-1 shadow-md mt-3">
                      <i data-feather="plus" class="w-4 h-4 mt-1 font-bold mr-2"></i> 
                      <span>Edit</span>
                    </button>
                  </div>
                  
                  <hr class="my-4">
                  
                </form>
              </div>
        </div>
</x-card>
</div>

@endsection

@push('scripts')
    {{-- <script>
        @foreach($projectTeams as $key => $team)
            function editTeam{{ $key }}() {
                document.getElementById('fee{{ $key }}').classList.toggle('hidden')
                document.getElementById('inputFee{{ $key }}').classList.toggle('hidden')
                document.getElementById('save{{ $key }}').classList.toggle('hidden')
                document.getElementById('x{{ $key }}').classList.toggle('hidden')
                document.getElementById('editButton{{ $key }}').classList.toggle('hidden')
                document.getElementById('delete{{ $key }}').classList.toggle('hidden')
            }
        @endforeach

        @foreach($projectTeams as $key => $team)
            var fee{{ $key }} = document.getElementById('inputFee{{ $key }}');
            fee{{ $key }}.addEventListener('keyup', function(e) {
                fee{{ $key }}.value = formatRupiah(this.value, 'Rp. ');
            });
        @endforeach --}}
<script>
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
