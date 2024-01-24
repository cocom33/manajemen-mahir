@extends('layouts.app')

@section('content')
<div class="flex items-center mt-8 intro-y">
    <h2 class="mr-auto text-lg font-medium">Add New Bank</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="col-span-12 intro-y lg:col-span-12">
        <!-- BEGIN: Form Layout -->
        <div class="p-5 intro-y box">
            <form method="post" action="{{ route('banks.store') }}">
                @csrf
                <div>
                    <label>Nama Bank*</label>
                    <input type="text" name="name" class="input w-full border mt-2 @error('name') border-theme-6 @enderror" placeholder="Masukkan Nama Bank">
                    @error('name')
                        <div class="mt-2 text-theme-6">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Nomer Rekening*</label>
                    <input type="number" name="rekening" class="input w-full border mt-2 @error('rekening') border-theme-6 @enderror" placeholder="Masukkan Nomer Rekening">
                    @error('rekening')
                        <div class="mt-2 text-theme-6">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Catatan</label>
                    <textarea type="number" name="note" class="input w-full border mt-2 @error('note') border-theme-6 @enderror" placeholder="Catatan"></textarea>
                    @error('note')
                        <div class="mt-2 text-theme-6">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-5 text-right">
                    <a href="{{ route('suppliers.index') }}"><button type="button" class="w-24 mr-1 text-gray-700 border button">Cancel</button></a>
                    <button type="submit" class="w-24 text-white button bg-theme-1">Save</button>
                </div>
            </form>
        </div>
        <!-- END: Form Layout -->
    </div>
</div>
@endsection
