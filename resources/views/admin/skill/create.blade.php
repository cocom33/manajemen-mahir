@extends('layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="flex items-center mt-8 intro-y">
    <h2 class="mr-auto text-lg font-medium">Add New Skill</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="col-span-12 intro-y lg:col-span-6">
        <!-- BEGIN: Form Layout -->
        <div class="p-5 intro-y box">
            <form method="post" action="{{ route('skill.store') }}">
                @csrf
                <div>
                    <label>Name</label>
                    <input type="text" name="name" class="input w-full border mt-2 @error('name') border-theme-6 @enderror" placeholder="Input text">
                    @error('name')
                        <div class="mt-2 text-theme-6">{{ $message }}</div>
                    @enderror
                </div>
                <div id="summernote"></div>
                <div class="mt-5 text-right">
                    <a href="{{ route('category-project.index') }}"><button type="button" class="w-24 mr-1 text-gray-700 border button">Cancel</button></a>
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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
      $('#summernote').summernote({
        placeholder: 'Hello stand alone ui',
        tabsize: 2,
        height: 120,
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
