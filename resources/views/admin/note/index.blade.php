@extends('layouts.app')

@section('title', 'Notes')

@section('content')

  <!-- BEGIN: Content -->
  <x-card title="Note List" :route="route('notes.create')">

    <table class="table table-report table-report--bordered display datatable w-full">
      <thead>
        <tr>
          <th class="border-b-2 whitespace-no-wrap">Title</th> 
          <th class="border-b-2 text-center whitespace-no-wrap">Photo</th>
          <th class="border-b-2 text-center whitespace-no-wrap">Actions</th>
        </tr>
      </thead>
      
      <tbody>
        @foreach ($notes as $note)
          <tr>
            <td class="border-b">{{ $note->title }}</td>
            <td class="border-b">{{ $note->photo }}</td>
            <td class="border-b">
              <div class="flex justify-center gap-2">
                <a href="{{ route('notes.show', $note) }}" class="button inline-block text-white bg-theme-1 shadow-md">
                  <i data-feather="eye" class=" w-4 h-4 font-bold"></i>
                </a>
                <a href="{{ route('notes.edit', $note) }}" class="button inline-block text-white bg-theme-9 shadow-md">
                  <i data-feather="edit" class=" w-4 h-4 font-bold"></i>
                </a>
                <form action="{{ route('notes.destroy', $note) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="button inline-block text-white bg-theme-6 shadow-md show-alert-delete-box" onclick="return confirm('Are you sure?')">
                    <i data-feather="trash" class=" w-4 h-4 font-bold"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>  
    </table>

  </x-card>
  <!-- END: Content -->

@endsection