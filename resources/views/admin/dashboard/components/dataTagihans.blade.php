@foreach ($tagihansLoad as $tagihan)
    @php
        if ($tagihan->project_id) {
            $route = route('project.tagihan.detail', [$tagihan->project->slug, $tagihan->id]);
        } else {
            $route = route('tagihan.show', $tagihan->id);
        }
    @endphp

    <a href="{{ $route }}">
        <div class="intro-y">
            <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
                <div class="ml-4 mr-auto">
                        <div class="font-medium">{{ $tagihan->title }} <small>( {{ $tagihan->description }} )</small></div>
                    <div class="text-xs text-gray-600">
                        {{ \Carbon\Carbon::parse($tagihan->created_at)->format('j F Y') }}
                    </div>
                </div>
                <div class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-theme-6">
                    @if ($tagihan->is_lunas == 1)
                        Lunas
                    @else
                        Belum Lunas
                    @endif
                </div>
            </div>
        </div>
    </a>
@endforeach
