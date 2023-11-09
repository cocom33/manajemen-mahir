@extends('layouts.app')

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Add New Keuangan Umum</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-6">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box p-5">
            <form method="post" action="{{ route('keuangan-umum.store') }}">
                @csrf
                <div>
                    <label>Description</label>
                    <input type="text" name="description" class="input w-full border mt-2 @error('description') border-theme-6 @enderror" placeholder="Description">
                    @error('description')
                        <div class="text-theme-6 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Status</label>
                    <div class="mt-2">
                        <select name="status" data-hide-search="true" class="select2 w-full @error('status') border-theme-6 @enderror">
                            <option selected disabled>Pilih Status</option>
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                        @error('status')
                        <div class="text-theme-6 mt-2">{{ $message }}</div>
                    @enderror
                    </div>
                </div>
                <div class="mt-3">
                    <label>Total</label>
                    <input type="text" name="total" class="input w-full border mt-2 @error('total') border-theme-6 @enderror" placeholder="Total">
                    @error('total')
                        <div class="text-theme-6 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="text-right mt-5">
                    <a href="{{ route('keuangan-umum.index') }}"><button type="button" class="button w-24 border text-gray-700 mr-1">Cancel</button></a>
                    <button type="submit" class="button w-24 bg-theme-1 text-white">Save</button>
                </div>
            </form>
        </div>
        <!-- END: Form Layout -->
    </div>
</div>
@endsection
