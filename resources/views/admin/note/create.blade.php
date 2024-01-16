@extends('layouts.app')
@section('title', 'Create Note')

@push('styles')
    <link href="{{ asset('dist/css/summernote-lite.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="flex items-center mt-8 intro-y">
    <h2 class="mr-auto text-lg font-medium">Add New Notes</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
    <div class="col-span-12 intro-y lg:col-span-12">
        <!-- BEGIN: Form Layout -->
        <div class="p-5 intro-y box">
            <form method="post" action="{{ route('notes.store') }}">
                @csrf
                <div>
                    <label>Title</label>
                    <input type="text" name="title" class="input w-full border mt-2 @error('title') border-theme-6 @enderror" placeholder="Input Title">
                    @error('title')
                        <div class="mt-2 text-theme-6">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-5 form-group">
                    <label>Content</label>
                    <textarea class="relative z-50" id="summernote" name="description"></textarea>
                </div>
                <div class="mt-5 text-right">
                    <a href="{{ route('note.index') }}"><button type="button" class="w-24 mr-1 text-gray-700 border button">Cancel</button></a>
                    <button type="submit" class="w-24 text-white button bg-theme-1">Save</button>
                </div>
            </form>
        </div>
        <!-- END: Form Layout -->
    </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="{{ asset('dist/js/summernote-lite.min.js') }}"></script>
<script>
  $('#summernote').summernote({
    placeholder: 'Hello stand alone ui',
    tabsize: 2,
    height: 300,
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'underline', 'clear']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
      ['insert', ['link', 'picture', 'video']],
      ['view', ['fullscreen', 'codeview', 'help']]
    ]
  });
</script>
@endpush
