@extends('layouts.app')

@section('title', 'perusahaan')

@section('content')

  <!-- BEGIN: Content -->
  <x-card title="Perusahaan List" :route="route('perusahaan.create')">

    <table class="table table-report table-report--bordered display datatable w-full">
      <thead>
        <tr>
          <th class="border-b-2 whitespace-no-wrap">ID</th>
          <th class="border-b-2 text-center whitespace-no-wrap">Nama Perusahaan</th>
          <th class="border-b-2 text-center whitespace-no-wrap">Actions</th>
        </tr>
      </thead>

      <tbody>
        @foreach ($perusahaan as $key => $perusahaans)
          <tr>
            <td class="border-b"><span class="hidden"></span>{{ $perusahaans->id }}</td>
            <td class="border-b">{{ $perusahaans->nama_perusahaan }}</td>
            <td class="border-b">
              <div class="flex justify-center gap-2">
                <a href="{{ route('perusahaan.show', $perusahaans) }}" class="button inline-block text-white bg-theme-1 shadow-md">
                  <i data-feather="eye" class=" w-4 h-4 font-bold"></i>
                </a>
                <a href="{{ route('perusahaan.edit', $perusahaans) }}" class="button inline-block text-white bg-theme-9 shadow-md">
                  <i data-feather="edit" class=" w-4 h-4 font-bold"></i>
                </a>
                <form action="{{ route('perusahaan.destroy', $perusahaans) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="button inline-block text-white bg-theme-6 shadow-md show-alert-delete-box">
                    <i data-feather="trash" class=" w-4 h-4 font-bold"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

  </x-card>
  <!-- END: Content -->

@endsection
