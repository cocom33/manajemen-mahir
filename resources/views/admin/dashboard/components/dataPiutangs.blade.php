@foreach ($piutangsLoad->where('status', 0) as $piutang)
    <div class="intro-y">
        <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
            {{-- <div class="flex-none w-10 h-10 overflow-hidden rounded-md image-fit">
                    <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-14.jpg">
                </div> --}}
            <div class="ml-4 mr-auto">
                {{-- <a href="{{ route('project.piutang.detail', [$item->project->slug, $item->id]) }}"> --}}
                    <div class="font-medium">{{ $piutang->title }} <small {{ $piutang->description }} </small></div>
                {{-- </a> --}}
                <div class="text-xs text-gray-600">
                    {{ \Carbon\Carbon::parse($piutang->created_at)->format('j F Y') }}
                </div>
            </div>
            <div class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-theme-9">
                @if ($piutang->is_lunas == 1)
                    Lunas
                @else
                    Belum Lunas
                @endif
            </div>
        </div>
    </div>
@endforeach
