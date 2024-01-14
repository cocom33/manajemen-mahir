@foreach ($piutangsLoad->where('status', 0) as $piutang)
    <div class="intro-y">
        <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
            <div class="ml-4 mr-auto">
                @php
                    $projects = \App\Models\Project::where('id', $piutang->keuangan_project->id)->first();
                @endphp
                <a href="{{ route('project.pemasukan.termin.detail', [$projects->slug, $piutang->slug]) }}">
                    <div class="font-medium hover:text-blue-600 a">{{ $piutang->name }} <small>( {{ $projects->name }} )</small></div>
                </a>
                <div class="text-xs text-gray-600">
                    Tenggat : {{ \Carbon\Carbon::parse($piutang->tanggal)->format('j F Y') }}
                </div>
            </div>
            <div class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-theme-6">
                @if ($piutang->is_lunas == 1)
                    Lunas
                @else
                    Belum Lunas
                @endif
            </div>
        </div>
    </div>
@endforeach
