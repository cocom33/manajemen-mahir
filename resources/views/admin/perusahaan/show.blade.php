@extends('layouts.app')

@section('title', 'Show Perusahaan')

@section('content')
<div class="grid grid-cols-12 gap-6 mt-5">

    <div class="col-span-12 intro-y lg:col-span-8">
      <div class="box p-5">

        <div class="flex items-center py-5">
          <i data-feather="clock" class="w-4 h-4 mr-2"></i>
          <div class="font-medium text-gray-600">Nama Pemilik</div>
          <div class="ml-auto">{{ $perusahaan->pemilik ?? "-" }}</div>
      </div>

        <div class="flex items-center py-5">
            <i data-feather="clock" class="w-4 h-4 mr-2"></i>
            <div class="font-medium text-gray-600">Nama Perusahaan</div>
            <div class="ml-auto">{{ $perusahaan->nama_perusahaan }}</div>
        </div>

        <div class="flex items-center py-5">
          <i data-feather="clock" class="w-4 h-4 mr-2"></i>
          <div class="font-medium text-gray-600">Email Perusahaan</div>
          <div class="ml-auto">{{ $perusahaan->email ?? "-" }}</div>
      </div>

        <div class="flex items-center py-5">
            <i data-feather="clock" class="w-4 h-4 mr-2"></i>
            <div class="font-medium text-gray-600">Alamat Perusahaan</div>
            <div class="ml-auto">{{ $perusahaan->alamat }}</div>
        </div>

        <div class="flex justify-end mt-5">
            <a href="{{ route('perusahaan.index') }}" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Back</a>
            <a href="{{ route('perusahaan.edit', $perusahaan) }}" class="button text-white bg-theme-1 mr-2">Edit</a>
        </div>
      </div>
    </div>

  </div>
  <div class="intro-y box mt-5">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
        <h2 class="font-medium text-base mr-auto">
            List Project Client
        </h2>
    </div>
    <div class="p-5" id="vertical-form">
        <div class="intro-y datatable-wrapper box p-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">CLIENT NAME</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">SHOW</th>
                </tr>
            </thead>
            <tbody>
            @if (!$clients == null)
                @foreach($clients->where('nama_perusahaan', $perusahaan->id) as $project)
                    <tr>
                        <td class="border-b">
                            <div class="font-medium whitespace-no-wrap">{{ $project->name }}</div>
                        </td>
                        <td class="border-b">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('client.show', $project->id) }}" class="button inline-block text-white bg-theme-1 shadow-md">
                                  <i data-feather="eye" class=" w-4 h-4 font-bold"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else

            @endif
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
