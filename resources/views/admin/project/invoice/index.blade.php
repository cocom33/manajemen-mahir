@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}">
        <x-tab-detail page="invoice" slug="{{ $project->slug }}" />
        @if ($invoice == null)
        <form action="{{ route('project.invoice.store', $project->slug) }}" method="POST" class="mt-5">
            @csrf
            <div class="mb-5">
                <label>Type</label>
                <div class="mt-2">
                    <select name="type" data-hide-search="true" class="select2 w-full">
                        <option selected disabled>Pilih Tipe</option>
                        <option value="system">System</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            <button class="button w-32 mr-2 mb-2 flex items-center justify-center bg-theme-1 text-white"> <i data-feather="printer" class="w-4 h-4 mr-2"></i>
                Invoice
            </button>
        </form>
        @else
            @if ($invoice->type == 'system')
            <a href="{{ route('project.invoice.stream', [$project->slug, $invoice->id]) }}" target="__blank">
                <button class="button w-44 mr-2 mb-2 mt-10 flex items-center justify-center bg-theme-1 text-white"> <i data-feather="printer" class="w-4 h-4 mr-2"></i>
                    Invoice System
                </button>
            </a>
            @else
            <a href="{{ route('project.invoice.stream', [$project->slug, $invoice->id]) }}" target="__blank">
                <button class="button w-44 mr-2 mb-2 mt-10 flex items-center justify-center bg-theme-1 text-white"> <i data-feather="printer" class="w-4 h-4 mr-2"></i>
                    Invoice Other
                </button>
            </a>
            @endif
        @endif

    </x-card>
@endsection
