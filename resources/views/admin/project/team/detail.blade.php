@extends('layouts.app')
@section('title')

@section('content')
<x-card title="Detail {{ $project->name }}" :project="$detail">
    <x-tab-detail page="team" slug="{{ $project->slug }}" />
</x-card>
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
