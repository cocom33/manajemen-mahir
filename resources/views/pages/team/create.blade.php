        @extends('layouts.app')
        @section('content')
        <!-- BEGIN: Content -->
        <div class="content">
            <div class="intro-y datatable-wrapper box p-5 mt-5">
                <table class="table table-report table-report--bordered display datatable w-full">
                    <thead>
                        <tr>
                            <th class="border-b-2 whitespace-no-wrap">TEAM NAME</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">WHATSAPP</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">EMAIL</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">ALAMAT</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($team as $team)
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-no-wrap">{{ $team->name }}</div>
                                <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $team->name }}</div>
                            </td>
                            <td class="w-40 border-b">
                                <div class="flex items-center sm:justify-center text-theme-9">
                                    <i data-feather="check-square" class="w-4 h-4 mr-2"></i> {{ ucfirst($team->status) }}
                                </div>
                            </td>
                            <td class="text-center border-b">{{ $team->wa }}</td>
                            <td class="text-center border-b">{{ $team->email }}</td>
                            <td class="text-center border-b">{{ $team->alamat }}</td>
                            <td class="border-b w-5">
                                <div class="flex sm:justify-center items-center">
                                    <a class="flex items-center mr-3" href="{{ route('teams.edit', $team) }}">
                                        <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                                    </a>
                                    <form action="{{ route('teams.destroy', $team->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center text-theme-6">
                                            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                </table>
            </div>
            
        </div>
        <script>
            $(document).ready( function () {
                $('#teams-table').DataTable();
            } );
            </script>
            
        <!-- END: Content -->
        @endsection
