@extends('layouts.app')
@section('content')
<!-- BEGIN: Vertical Form -->
<div class="intro-y box">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
        <h2 class="font-medium text-base mr-auto">
            Edit Team
        </h2>
    </div>
    <div class="p-5" id="vertical-form">
        <form action="{{ route('teams.update', $team) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="preview">
                <div>
                    <label>Nama Team</label>
                    <input type="text" name="name" value="{{ $team->name }}" class="input w-full border mt-2 @error('name') border-theme-6 @enderror" placeholder="Nama Client">
                    @error('name')
                        <div class="text-theme-6 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Status</label>
                    <div class="mt-2">
                        <select name="status" data-hide-search="true" class="select2 w-full">
                            <option selected disabled>Pilih Status</option>
                            <option value="tetap" {{ $team->status == 'tetap' ? 'selected' : '' }}>Tetap</option>
                            <option value="freelance" {{ $team->status == 'freelance' ? 'selected' : '' }}>Freelance</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <label>Skills</label>
                    <div class="mt-2">
                        <select name="skill[]" class="select2 w-full border-theme-6" multiple>
                            <option disabled>Pilih Status</option>
                            @foreach ($skills as $skill)
                            <option value="{{ $skill->id }}"
                                @if(in_array($skill->id, $team->skill ? json_decode($team->skill) : []))
                                selected
                                @endif >{{ $skill->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('skills')
                        <div class="text-theme-6 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Nomor Whatsapp</label>
                    <input type="number" name="wa" value="{{ $team->wa }}" class="input w-full border mt-2 @error('wa') border-theme-6 @enderror" placeholder="+62 895-1459-6251">
                    @error('wa')
                        <div class="text-theme-6 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $team->email }}" class="input w-full border mt-2 @error('email') border-theme-6 @enderror" placeholder="example@gmail.com">
                    @error('email')
                        <div class="text-theme-6 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" value="{{ $team->alamat }}" class="input w-full border mt-2 @error('alamat') border-theme-6 @enderror" placeholder="Alamat">
                    @error('alamat')
                        <div class="text-theme-6 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="button bg-theme-1 text-white mt-5">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Vertical Form -->
@endsection
