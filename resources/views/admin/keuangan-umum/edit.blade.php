@extends('layouts.app')

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Edit Keuangan Umum</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-6">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box p-5">
            <form method="post" action="{{ route('keuangan-umum.update', $data->id) }}">
                @csrf
                @method('PUT')
                <div>
                    <label>Description</label>
                    <input type="text" value="{{ $data->description }}" name="description" class="input w-full border mt-2 @error('description') border-theme-6 @enderror" placeholder="Input text">
                    @error('description')
                        <div class="text-theme-6 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Status</label>
                    <div class="mt-2">
                        <select name="status" data-hide-search="true" class="select2 w-full">
                            <option value="pemasukan" @if ( $data->status == 'pemasukan' ) selected @endif>Pemasukan</option>
                            <option value="pengeluaran" @if ( $data->status == 'pengeluaran' ) selected @endif>Pengeluaran</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <label>Total</label>
                    <input type="text" value="{{ $data->total }}" name="total" class="input w-full border mt-2 @error('total') border-theme-6 @enderror" placeholder="Input text">
                    @error('total')
                        <div class="text-theme-6 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="text-right mt-5">
                    <a href="{{ route('category-project.index') }}"><button type="button" class="button w-24 border text-gray-700 mr-1">Cancel</button></a>
                    <button type="submit" class="button w-24 bg-theme-1 text-white">Save</button>
                </div>
            </form>
        </div>
        <!-- END: Form Layout -->
    </div>
</div>
@endsection
