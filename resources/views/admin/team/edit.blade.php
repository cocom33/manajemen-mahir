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
        <div class="preview">
            <form action="{{ route('teams.update', $team) }}" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <label>Team Name</label>
                    <input type="text" name="name" class="input w-full border mt-2" placeholder="Team Name" value="{{ $team->name }}">
                </div>
                <div>
                    <label>Status</label>
                    <select name="status" class="input w-full border mt-2">
                        <option value="FREELANCE" {{ $team->status == 'FREELANCE' ? 'selected' : '' }}>Freelance</option>
                        <option value="TETAP" {{ $team->status == 'TETAP' ? 'selected' : '' }}>Tetap</option>
                    </select>
                </div>
                
                <div>
                    <label>WhatsApp</label>
                    <input type="number" name="wa" class="input w-full border mt-2" placeholder="WhatsApp" value="{{ $team->wa }}">
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="email" class="input w-full border mt-2" placeholder="example@gmail.com" value="{{ $team->email }}">
                </div>
                <div>
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="input w-full border mt-2" placeholder="Alamat" value="{{ $team->alamat }}">
                </div>
                <button type="submit" class="button bg-theme-1 text-white mt-5">Submit</button>
            </form>
        </div>
    </div>
</div>
<!-- END: Vertical Form -->
@endsection
