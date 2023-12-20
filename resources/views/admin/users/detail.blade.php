@extends('layouts.app')
@section('content')


<x-card title="Detail User" routeEdit="{{ route('users.edit', $model->id) }}">
    <div class="preview">
        <div>
            <label>Nama Team</label>
            <input type="text" value="{{ $model->name }}" name="name" class="input w-full border mt-2" readonly>
        </div>
        <div class="mt-3">
            <label>Email</label>
            <input type="email" value="{{ $model->email }}" name="email" class="input w-full border mt-2" readonly>
        </div>
        {{-- <button type="submit" class="button bg-theme-1 text-white mt-5">Submit</button> --}}
    </div>
</x-card>
@endsection
