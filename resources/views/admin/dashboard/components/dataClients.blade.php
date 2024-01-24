@foreach ($clientsLoad as $client)
    <div class="intro-y">
        <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
            {{-- <div class="flex-none w-10 h-10 overflow-hidden rounded-md image-fit">
                    <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-14.jpg">
                </div> --}}
            <div class="ml-4 mr-auto">
                <a href="{{ route('project.detail', $client->slug) }}">
                    <div class="font-medium">{{ $client->name }}</div>
                </a>
                <div class="text-xs text-gray-600">
                    Deadline: {{ $client->deadline_date ? \Carbon\Carbon::parse($client->deadline_date)->format('j F Y') : 'Belum Di Set Up'}}
                </div>
            </div>
            <div class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-theme-9">
                {{  Str::limit($client->client->name, 13) }}
            </div>
        </div>
    </div>
@endforeach
