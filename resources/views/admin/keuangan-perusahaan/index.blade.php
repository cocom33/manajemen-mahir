@extends('layouts.app')
@section('title', 'Keuangan Perusahaan')

@section('content')
 <!-- BEGIN: Content -->
 <div class="content">
    {{ $data->tahun }}
    @foreach ($data->bulan as $item)
        <p>{{ $item }}</p>
        <p>{{ $item->detail }}</p>
        <br>
    @endforeach
    {{-- {{ $data->bulan }} --}}
</div>
<!-- END: Content -->
@endsection
