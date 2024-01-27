@foreach ($feeteamsLoad as $item)
    <div class="intro-y">
        <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
            <div class="ml-4 mr-auto">
                <a href="{{ route('project.teams.show', [App\Models\Project::where('id', $item->projectTeam->project_id)->first()->slug, App\Models\Team::where('id', $item->projectTeam->team_id)->first()->id]) }}">
                    <div class="font-medium">
                        {{ App\Models\Team::where('id', $item->projectTeam->team_id)->first()->name }}
                    </div>
                </a>
                <div class="text-xs text-gray-600">
                    Deadline: {{ Carbon\Carbon::parse($item->tenggat)->format('j M Y') }}
                </div>
            </div>
            <div class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-theme-9">
                Rp. {{ number_format($item->fee, 0, ',', '.') }}
            </div>
        </div>
    </div>
@endforeach
