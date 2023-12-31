@extends('layouts.app')
@section('content')
<div class="intro-y mt-5 col-span-12 lg:col-span-6">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                Add New Team
            </h2>
            <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-0">
            </div>
        </div>
        <div class="p-5" id="vertical-form">
            <form action="{{route('teams.store')}}" method="POST">
                @csrf
                <div class="preview">
                    <div>
                        <label>Nama Team</label>
                        <input type="text" name="name" class="input w-full border mt-2 @error('name') border-theme-6 @enderror" placeholder="Nama Team">
                        @error('name')
                            <div class="text-theme-6 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label>Status</label>
                        <div class="mt-2">
                            <select name="status" data-hide-search="true" class="select2 w-full">
                                <option selected disabled>Pilih Status</option>
                                <option value="TETAP">Tetap</option>
                                <option value="FREELANCE">Freelance</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label>Skills</label>
                        <div class="mt-2">
                            <select name="skill[]" data-hide-search="true" class="select2 w-full border-theme-6" multiple>
                                <option disabled>Pilih Status</option>
                                @foreach ($skills as $skill)
                                <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('skills')
                            <div class="text-theme-6 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label>Nomor Whatsapp</label>
                        <input type="number" name="wa" class="input w-full border mt-2 @error('wa') border-theme-6 @enderror" placeholder="+62 895-1459-6251">
                        @error('wa')
                            <div class="text-theme-6 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label>Email</label>
                        <input type="email" name="email" class="input w-full border mt-2 @error('email') border-theme-6 @enderror" placeholder="example@gmail.com">
                        @error('email')
                            <div class="text-theme-6 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label>Alamat</label>
                        <input type="text" name="alamat" class="input w-full border mt-2 @error('alamat') border-theme-6 @enderror" placeholder="Alamat">
                        @error('alamat')
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
