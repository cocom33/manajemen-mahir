@extends('layouts.app')
@section('content')


<x-card title="Tambah User" routeBack="{{ route('users.index') }}">
    <form action="{{ $route }}" method="POST">
        @csrf
        @if ($model)
            @method('PUT')
        @endif

        <div class="preview">
            <div>
                <label>Nama Team</label>
                <input type="text" value="{{ $model->name ?? old('name') }}" name="name" class="input w-full border mt-2 @error('name') border-theme-6 @enderror" placeholder="Nama Team">
                @error('name')
                    <div class="text-theme-6 mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-3">
                <label>Email</label>
                <input type="email" value="{{ $model->email ?? old('email') }}" name="email" class="input w-full border mt-2 @error('email') border-theme-6 @enderror" placeholder="example@gmail.com">
                @error('email')
                    <div class="text-theme-6 mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-3">
                <label>Password</label>
                <input type="password" name="password" class="input w-full border mt-2 @error('password') border-theme-6 @enderror">
                @error('password')
                    <div class="text-theme-6 mt-2">{{ $message }}</div>
                @enderror
            </div>
            @if (!$model)
                <div class="mt-3">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="input w-full border mt-2 @error('password_confirmation') border-theme-6 @enderror">
                    @error('password_confirmation')
                        <div class="text-theme-6 mt-2">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            <button type="submit" class="button bg-theme-1 text-white mt-5">Submit</button>
        </div>
    </form>
</x-card>
@endsection
