@extends('layouts.app')

@section('title', 'Create Note')

@section('content')

<form method="POST" action="{{ route('notes.store') }}" enctype="multipart/form-data">

  @csrf

  <div class="intro-y box">
    <div class="p-5 mt-5" id="vertical-form">
      
      <div> 
        <label>Title</label>
        <input type="text" name="title" class="input w-full border mt-2" placeholder="Input Title">
      </div>
      
      <div class="form-group my-5">
        <label>Content</label>
        <textarea name="content" class="ckeditor form-control my-5" id="editor"></textarea>
      </div>

      <button type="submit" class="button bg-theme-1 text-white mt-5">Create Note</button>
    </div>
  </div>
  
  
</form>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

@endpush