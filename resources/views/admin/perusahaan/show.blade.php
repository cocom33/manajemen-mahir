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
            <div class="font-medium text-gray-600">Alamat</div>
            <div class="ml-auto">{{ $perusahaan->alamat }}</div>
        </div>
        
        <div class="flex justify-end mt-5"> 
            <a href="{{ route('perusahaan.index') }}" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Back</a>
            <a href="{{ route('perusahaan.edit', $perusahaan) }}" class="button text-white bg-theme-1 mr-2">Edit</a>
        </div>
      </div>
    </div>

    

  </div>
@endsection
