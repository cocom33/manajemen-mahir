@extends('layouts.app')

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Add New Project Type</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-6">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box p-5">
            <form method="post" action="{{ route('project-type.update', $data->id) }}">
                @csrf
                @method('PUT')
                <div>
                    <label>Name</label>
                    <input type="text" name="name" value="{{ $data->name }}" class="input w-full border mt-2 @error('name') border-theme-6 @enderror" placeholder="Input text">
                    @error('name')
                        <div class="text-theme-6 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="text-right mt-5">
                    <a href="{{ route('project-type.index') }}"><button type="button" class="button w-24 border text-gray-700 mr-1">Cancel</button></a>
                    <button type="submit" class="button w-24 bg-theme-1 text-white">Save</button>
                </div>
            </form>
        </div>
        <!-- END: Form Layout -->
    </div>
</div>
@endsection
