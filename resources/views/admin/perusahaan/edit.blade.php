@extends('layouts.app')
@section('title', 'Create Note')

@push('styles')
    <link href="{{ asset('dist/css/summernote-lite.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="flex items-center mt-8 intro-y">
    <h2 class="mr-auto text-lg font-medium">Edit Perusahaan</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
    <div class="col-span-12 intro-y lg:col-span-12">
        <!-- BEGIN: Form Layout -->
        <div class="p-5 intro-y box">
          <form method="POST" action="{{ route('perusahaan.update', $data->id) }}">
            @csrf 
            @method('PUT')

            <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">Nama Pemilik</label>
            <input type="text" name="pemilik" value="{{ $data->pemilik }}" class="input w-full border mt-2" placeholder="Input Nama Pemilik">
            </div>

            <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" value="{{ $data->nama_perusahaan }}" class="input w-full border mt-2 @error('nama_perusahaan') border-theme-6 @enderror" placeholder="Input Nama Perusahaan">
            
            @error('nama_perusahaan')
                <div class="mt-2 text-theme-6">{{ $message }}</div>
            @enderror
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-medium mb-2">Email Perusahaan</label>
                <input type="text" name="email" value="{{ $data->email }}" class="input w-full border mt-2 @error('email') border-theme-6 @enderror" placeholder="Input Nama Email Perusahaan">
                
                @error('email')
                    <div class="mt-2 text-theme-6">{{ $message }}</div>
                @enderror
                </div>

            <div class="mb-5">
                <label>Alamat Perusahaan</label>
                <textarea type="text" name="alamat" class="input w-full border mt-2 @error('alamat') border-theme-6 @enderror" placeholder="Alamat"></textarea>
                @error('alamat')
                    <div class="text-theme-6 mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-right">
            <a href="{{ route('perusahaan.index') }}"><button type="button" class="w-24 mr-1 text-gray-700 border button">Cancel</button></a>
            <button type="submit" class="button bg-theme-1 text-white">Save</button> 
            </div>
            </form>
        </div>
        <!-- END: Form Layout -->
    </div>
    </div>
@endsection