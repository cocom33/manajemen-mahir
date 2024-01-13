@extends('layouts.app')

@push('styles')
    <style>
        .ck-editor__editable_inline {
            min-height: 300px;
        }
    </style>
@endpush

@section('content')
<div class="flex items-center mt-8 intro-y">
    <h2 class="mr-auto text-lg font-medium">Add New Skill</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="col-span-12 intro-y lg:col-span-12">
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
                <div class="mt-5 form-group">
                    <label>Body:</label>
                    <textarea name="content" id="editor"></textarea>
                </div>
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
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    <script>
    ClassicEditor
        .create( document.querySelector( '#editor' ),{
            ckfinder: {
                uploadUrl: '{{route('ckeditor.upload').'?_token='.csrf_token()}}',
            }
        })
        .catch( error => {

        } );
</script>
@endpush
