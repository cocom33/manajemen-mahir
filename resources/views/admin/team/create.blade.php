@extends('layouts.app')

@section('content')
<div class="p-5" id="vertical-form">
    <div class="preview">
        <form action="{{ route('teams.store') }}" method="POST">
            @csrf
            <div>
                <label>Team Name</label>
                <input type="text" name="name" required class="input w-full border mt-2" placeholder="Team Name">
            </div>
            <div>
                <label>Status</label>
                <select name="status" required class="input w-full border mt-2">
                    <option value="FREELANCE">Freelance</option>
                    <option value="TETAP">Tetap</option>
                </select>
            </div>
            <div>
                <label>WhatsApp</label>
                <input type="number" name="wa" required class="input w-full border mt-2" placeholder="WhatsApp">
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" required class="input w-full border mt-2" placeholder="example@gmail.com">
            </div>
            <div>
                <label>Alamat</label>
                <input type="text" name="alamat" required class="input w-full border mt-2" placeholder="Alamat">
            </div>
            <button type="submit" class="button bg-theme-1 text-white mt-5">Submit</button>
        </form>
    </div>
</div>
@endsection
