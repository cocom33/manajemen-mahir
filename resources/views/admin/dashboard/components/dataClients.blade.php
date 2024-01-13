@foreach ($clientsLoad as $client)
    <div class="intro-y">
        <div class="box px-4 py-4 mb-3 flex items-center zoom-in">
            {{-- <div class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden">
                    <img alt="Midone Tailwind HTML Admin Template" src="dist/images/profile-14.jpg">
                </div> --}}
            <div class="ml-4 mr-auto">
                <a href="{{ route('client.show', $client->id) }}">
                    <div class="font-medium">{{ $client->name }}</div>
                </a>
                <div class="text-gray-600 text-xs">
                    {{ \Carbon\Carbon::parse($client->created_at)->format('j F Y') }}
                </div>
            </div>
            <div class="py-1 px-2 rounded-full text-xs bg-theme-9 text-white cursor-pointer font-medium">

            </div>
        </div>
    </div>
@endforeach
