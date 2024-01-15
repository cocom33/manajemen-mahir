@foreach ($clientsLoad as $client)
    <div class="intro-y">
        <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
            {{-- <div class="flex-none w-10 h-10 overflow-hidden rounded-md image-fit">
                    <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-14.jpg">
                </div> --}}
            <div class="ml-4 mr-auto">
                <a href="{{ route('client.show', $client->id) }}">
                    <div class="font-medium">{{ $client->name }}</div>
                </a>
                <div class="text-xs text-gray-600">
                    {{ \Carbon\Carbon::parse($client->created_at)->format('j F Y') }}
                </div>
            </div>
            <div class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-theme-9">
                {{  \App\Models\Project::where('client_id', $client->id)->get()->count() }} Project
            </div>
        </div>
    </div>
@endforeach
