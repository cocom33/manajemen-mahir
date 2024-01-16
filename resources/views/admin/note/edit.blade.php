@extends('layouts.app')

@push('styles')
<style>
  .ck-editor__editable_inline {
    min-height: 300px;
  }
</style>
@endpush

@section('title', 'Edit Note')

@section('content')

<div class="flex items-center mt-8 intro-y">
  <h2 class="mr-auto text-lg font-medium">Edit Note</h2>
</div>

<div class="grid grid-cols-12 gap-6 mt-5">

  <div class="col-span-12 intro-y lg:col-span-12">
    <div class="mt-5 text-right">
        <form action="{{ route('notes.destroy', $note) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-24 mr-1 border button flex text-white  bg-theme-6 shadow-md show-alert-delete-box" onclick="return confirm('Are you sure?')">
                <p class="">Delete</p>
                <i data-feather="trash" class=" w-4 h-4 font-bold"></i>
            </button>
          </form>
    </div>

    <div class="p-5 intro-y box">

      <form method="POST" action="{{ route('notes.update', $note->id) }}" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div>
          <label>Title</label>
          <input type="text" name="title" class="input w-full border mt-2" value="{{ $note->title }}">
        </div>

        <div class="mt-5">
         <label>Content</label>
          <textarea name="content" id="editor" class="input w-full border mt-2">{{ $note->content }}</textarea>
        </div>

        <div class="mt-5 text-right">
            <a href="{{ route('notes.index') }}"><button type="button" class="w-24 mr-1 text-gray-700 border button">Cancel</button></a>
          <button type="submit" class="button w-24 bg-theme-1 text-white">Update</button>
        </div>

      </form>

    </div>

  </div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>

<script>
  ClassicEditor.create( document.querySelector( '#editor' ), {
    ckfinder: {
      uploadUrl: '{{ route('ckeditor.upload') }}?{{ csrf_token() }}'
    }
  }).catch( error => {
    console.error( error );
  } );
</script>

@endpush
