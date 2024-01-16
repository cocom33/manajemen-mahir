@extends('layouts.app')

@section('title', 'Show Notes')

@section('content')
<div class="grid grid-cols-12 gap-6 mt-5">

    <div class="col-span-12 intro-y lg:col-span-8">
      <div class="box p-5">

        <div class="flex">
          <h2 class="text-lg font-medium mr-auto">{{ $note->title }}</h2>
        </div>

        <div class="text-gray-600 mt-5">
          {!! $note->description !!}
        </div>

      </div>
    </div>

    <div class="col-span-12 intro-y lg:col-span-4">

      <div class="box p-5">

        <div class="flex items-center border-b border-gray-200 dark:border-dark-5 pb-5">
          <i data-feather="clock" class="w-4 h-4 mr-2"></i>
          <div class="font-medium text-gray-600">Created At</div>
          <div class="ml-auto text-theme-1">{{ $note->created_at->format('d M Y') }}</div>
        </div>

        <div class="flex items-center border-b border-gray-200 dark:border-dark-5 py-5">
          <i data-feather="clock" class="w-4 h-4 mr-2"></i>
          <div class="font-medium text-gray-600">Updated At</div>
          <div class="ml-auto text-theme-1">{{ $note->updated_at->format('d M Y') }}</div>
        </div>

        <div class="flex justify-end mt-5">
          <a href="{{ route('notes.edit', $note) }}" class="button text-white bg-theme-1 mr-2">Edit</a>
          <a href="{{ route('notes.index') }}" class="button w-24 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Back</a>
        </div>

      </div>

    </div>

  </div>
@endsection
