@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}" :project="$detail">
        <x-tab-detail page="fee" slug="{{ $project->slug }}" />
        <div class="mt-5">
            <div class="w-full flex justify-between align-center">
                <h3 class="font-bold text-xl">
                    Detail {{ $termin->name }}
                </h3>
                <div>
                    <button class="button flex align-center text-white bg-theme-1 shadow-md" onclick="formTermin()">
                        <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span> Tambah Fee Team</span>
                    </button>
                </div>
            </div>

            <form action="{{ route('project.fee.termin.detail.store', [$project->slug, $termin->slug]) }}" method="post" class="hidden mt-3" id="formTermin">
                @csrf
                @method('PUT')
            
                <x-form-input label="" name="termin_id" value="{{ $termin->id }}" type="hidden" required="false" />
            
                <label for="project_team_id">pilih tim</label>
                <select name="project_team_id" id="project_team_id" class="input w-full border mt-2 mb-3">
                    @foreach ($teams as $item)
                        <option value="{{ $item->id }}">{{ $item->team->name }}</option>
                    @endforeach
                </select>
                <label>Masukkan Fee</label>
                <input type="text" id="fee" name="fee" class="input w-full border mt-2" onkeyup="formatAngka(this)">
                <input type="hidden" id="feeValue" name="feeValue">
            
                <div class="flex justify-end">
                    <button type="submit" class="button flex align-center text-white bg-theme-1 shadow-md mt-3" onclick="submitForm()">
                        <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Tambah</span>
                    </button>
                </div>
                <hr class="my-4">
            </form>
            

            <div class="mt-8">
                <table class="table table-report table-report--bordered display datatable w-full">
                    <thead>
                        <tr>
                            <th class="border-b-2 text-center whitespace-no-wrap">TERMIN NAME</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">FEE</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">TANGGAL</th>
                            <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($termin->termin_fee as $key => $item)
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-no-wrap">{{ $item->project_team->team->name }}</div>
                            </td>
                            <td class="text-center border-b">
                                <span id="fieldFee{{ $item->id }}">Rp. {{ number_format($item->fee) }}</span>
                                <form action="{{ route('project.fee.termin.detail.store', [$project->slug, $termin->slug]) }}" method="POST" id="edit_fee{{ $item->id }}">
                                    @csrf
                                    @method('PUT')
                                    <input id="inputFee{{ $item->id }}" type="number" name="fee" class="hidden input w-full border" value="{{ $item->fee }}">
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <input type="hidden" name="termin_id" value="{{ $termin->id }}">
                                </form>
                            </td>
                            <td class="text-center border-b">
                                @php
                                    $testfee[$key] = 0;
                                    foreach ($project->keuangan_project->termin as $value) {
                                        if ($value->termin_fee->where('project_team_id', $item->project_team->id)->first()) {
                                            $testfee[$key] = $testfee[$key] + $value->termin_fee->where('project_team_id', $item->project_team->id)->first()->fee;
                                        }
                                    }
                                @endphp

                                @if ($testfee[$key] >= $item->project_team->fee)
                                    <span class="font-medium text-theme-40">Lunas</span>
                                @else
                                    <div class="font-medium whitespace-no-wrap text-theme-6">Belum Lunas</div>
                                    <div class="text-gray-600 text-xs whitespace-no-wrap">tersisa Rp. {{ number_format($item->project_team->fee - $testfee[$key]) }}</div>
                                @endif
                            </td>
                            <td class="text-center border-b">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="border-b w-5">
                                <div class="flex sm:justify-center items-center">
                                    <div class="dropdown relative flex items-center gap-1">
                                        <button id="buttonEdit{{ $item->id }}" form="edit_fee{{ $item->id }}" type="submit" class="hidden button inline-block text-white bg-theme-1 shadow-md">
                                          <i data-feather="save" class="w-4 h-4 font-bold"></i>
                                        </button>
                                        <a id="edit{{ $item->id }}" onclick="EditFee{{ $item->id }}()" type="button" class="button inline-block text-white bg-theme-9 shadow-md">
                                          <i data-feather="edit-2" class="w-4 h-4 font-bold"></i>
                                        </a>
                                        <a id="close{{ $item->id }}" onclick="EditFee{{ $item->id }}()" type="button" class="hidden button inline-block text-white bg-theme-6 shadow-md">
                                          <i data-feather="x" class=" w-4 h-4 font-bold"></i>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-card>
@endsection

@push('scripts')
    <script>
        function formTermin() {
            var form = document.getElementById('formTermin');
            form.classList.toggle('hidden')
        }


        @foreach($termin->termin_fee as $item)
            function EditFee{{ $item->id }}() {
                var field{{ $item->id }} = document.getElementById('fieldFee{{ $item->id }}');
                var input{{ $item->id }} = document.getElementById('inputFee{{ $item->id }}');
                var button{{ $item->id }} = document.getElementById('buttonEdit{{ $item->id }}');
                var close{{ $item->id }} = document.getElementById('close{{ $item->id }}');
                var edit{{ $item->id }} = document.getElementById('edit{{ $item->id }}');

                input{{ $item->id }}.classList.toggle('hidden');
                field{{ $item->id }}.classList.toggle('hidden');
                button{{ $item->id }}.classList.toggle('hidden');
                close{{ $item->id }}.classList.toggle('hidden');
                edit{{ $item->id }}.classList.toggle('hidden');
            }
        @endforeach
        
        function numberWithCommas(x) {
            x = x.toString();
            var pattern = /(-?\d+)(\d{3})/;
            while (pattern.test(x))
                x = x.replace(pattern, "$1,$2");
            return x;
        }

        function formatAngka(objek) {
            var input = objek.value;
            var nominal = input.replace(/\D/g, '');
            objek.value = numberWithCommas(nominal);

            // Simpan nilai tanpa titik koma ke dalam input hidden
            document.getElementById('feeValue').value = nominal;
        }

        function submitForm() {
            var feeValue = document.getElementById('feeValue');
            if (feeValue.value === '') {
                alert('Fee tidak boleh kosong');
                return false;
            } else {
                document.getElementById('fee').value = feeValue.value;
                return true;
            }
        }

    </script>
@endpush
