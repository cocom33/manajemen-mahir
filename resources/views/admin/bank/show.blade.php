@extends('layouts.app')
@section('content')
<!-- BEGIN: Vertical Form -->
<div class="intro-y box">
    <div class="flex flex-col items-center p-5 border-b border-gray-200 sm:flex-row">
        <h2 class="mr-auto text-base font-medium">
            Show Rekening Bank {{ $data->name }}
        </h2>
        <div class="flex justify-end">
            <a href="{{ route('suppliers.edit', $data) }}" class="flex text-white shadow-md button align-center bg-theme-1">
              <i data-feather="edit-2" class="w-4 h-4 mr-2 font-bold "></i> Edit
            </a>
        </div>
    </div>
    <div class="p-5" id="vertical-form">
        <div class="grid grid-cols-2 preview">
                <div>
                    <div class="mb-6">
                        <span class="font-semibold">Nama</span>
                        <p class="mt-3">{{ $data->name }}</p>
                    </div>
                    <div class="mb-6">
                        <span class="font-semibold">Nomer Rekening</span>
                        <p class="mt-3">{{ $data->rekening }}</p>
                    </div>
                    <div class="mb-6">
                        <span class="font-semibold">Catatan</span>
                        <div class="mt-3">
                            <p class="mt-3">{{ $data->note ? $data->note : '---' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('suppliers.index') }}"><button class="mt-5 text-white button bg-theme-1">Back</button></a>
                </div>
        </div>
    </div>
</div>
<!-- END: Vertical Form -->
@endsection
