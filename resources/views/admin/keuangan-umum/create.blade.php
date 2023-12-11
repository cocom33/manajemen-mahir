@extends('layouts.app')
@section('content')
<div class="intro-y mt-5 col-span-12 lg:col-span-6">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                Add New Pengeluaran Perusahaan
            </h2>
            <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-0">
            </div>
        </div>
        <div class="p-5" id="vertical-form">
            <form action="{{route('keuangan-umum.store')}}" method="POST">
                @csrf
                <div class="preview">
                    <div class="mt-3">
                        <label>Title</label>
                        <input type="text" name="description" class="input w-full border mt-2 @error('description') border-theme-6 @enderror">
                        @error('description')
                            <div class="text-theme-6 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label>Total</label>
                        <input type="number" name="total" class="input w-full border mt-2 @error('total') border-theme-6 @enderror">
                        @error('total')
                            <div class="text-theme-6 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label class="pb-3">Status</label>
                        <select name="status" id="status" class="select2  w-full">
                            <option value="pemasukan">pemasukan</option>
                            <option value="pengeluaran">pengeluaran</option>
                        </select>
                        <small>boleh dikosongkan</small>
                        @error('status')
                            <div class="text-theme-6 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="input w-full border mt-2 @error('tanggal') border-theme-6 @enderror">
                        <small>boleh dikosongkan</small>
                        @error('tanggal')
                            <div class="text-theme-6 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="button bg-theme-1 text-white mt-5">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
