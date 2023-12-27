@extends('layouts.app')
@section('title', $project->name)

@section('content')
    <x-card title="Detail {{ $project->name }}" :project="$detail">
        <x-tab-detail page="fee" slug="{{ $project->slug }}" />
        <div class="mt-5">
            <div>
                @if (!$project->keuangan_project)
                    <form action="{{ route('project.pemasukan.create', $project->slug) }}" method="post">
                        @csrf
                        <div class="w-full">
                            <label for="">Pilih Type Pembayaran</label>
                            <select name="type" class="input w-full border mt-2">
                                <option value="termin">Termin</option>
                                <option value="langsung">Langsung</option>
                            </select>

                            <input type="hidden" name="project_id" value="{{ $project->id }}" />
                        </div>
                        <div class="flex justify-end mt-3">
                            <button class="button flex align-center text-white bg-theme-1 shadow-md">
                                <i data-feather="plus" class=" w-4 h-4 font-bold mr-2"></i> <span>Tambah Pembayaran</span>
                            </button>
                        </div>
                    </form>
                @else
                    <div class="w-full flex justify-between align-center">
                        <h3 class="font-bold text-xl">
                            Pembayaran {{ $project->keuangan_project->type == 'langsung' ? 'Langsung' : 'Per Termin' }}
                        </h3>
                        <div class="flex gap-5">
                            @if ($project->keuangan_project->type == 'langsung')
                                <form
                                    action="{{ route('project.pemasukan.destroy', [$project->slug, $project->keuangan_project->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="show-alert-change-payment-type button flex align-center text-white bg-theme-6 shadow-md"
                                        onclick="formTermin()">
                                        <i data-feather="edit-2" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span> Ubah
                                            Tipe Pembayaran</span>
                                    </button>
                                </form>
                            @else
                                <form
                                    action="{{ route('project.pemasukan.destroy', [$project->slug, $project->keuangan_project->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="show-alert-change-payment-type button flex align-center text-white bg-theme-6 shadow-md"
                                        onclick="formTermin()">
                                        <i data-feather="edit-2" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span> Ubah
                                            Tipe Pembayaran</span>
                                    </button>
                                </form>
                                <button class="button flex align-center text-white bg-theme-1 shadow-md"
                                    onclick="formTermin()">
                                    <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span> Tambah
                                        Termin</span>
                                </button>
                            @endif
                        </div>
                    </div>
                    @if ($project->keuangan_project->type == 'langsung')
                        {{-- <form action="{{ route('project.pemasukan.langsung.store', $project->slug) }}" method="post"
                            class="hidden mt-3" id="form">
                            @csrf
                            <input type="hidden" name="keuangan_project_id" value="{{ $project->keuangan_project->id }}">
                            <label for="project_team_id">Pilih Team</label>
                            <select name="project_team_id" id="project_team_id" class="input w-full border mt-2 mb-3">
                                @foreach ($project_teams as $item)
                                    <option value="{{ $item->id }}">{{ $item->team->name }}</option>
                                @endforeach
                            </select>
                            <x-form-input label="Fee" name="langsung" placeholder="masukkan fee" />

                            <div class="flex justify-end">
                                <button class="button flex align-center text-white bg-theme-1 shadow-md mt-3">
                                    <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Tambah</span>
                                </button>
                            </div>
                            <hr class="my-4">
                        </form>
                        <div class="mt-8">
                            <table class="table table-report table-report--bordered display datatable w-full">
                                <thead>
                                    <tr>
                                        <th class="border-b-2 text-center whitespace-no-wrap">TEAM NAME</th>
                                        <th class="border-b-2 text-center whitespace-no-wrap">FEE</th>
                                        <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                                        <th class="border-b-2 text-center whitespace-no-wrap">TANGGAL</th>
                                        <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fee_langsung as $item)
                                        <tr>
                                            <td class="border-b">
                                                <div class="font-medium whitespace-no-wrap">
                                                    {{ $item->projectTeam->team->name ?? '' }}</div>
                                            </td>
                                            <td class="w-40 border-b">
                                                <div id="fieldFee{{ $item->id }}"
                                                    class="flex items-center sm:justify-center">
                                                    Rp. {{ number_format($item->fee) }}
                                                </div>
                                                <form
                                                    action="{{ route('project.pemasukan.langsung.store', $project->slug) }}"
                                                    method="POST" id="edit_fee{{ $item->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input id="inputFee{{ $item->id }}" name="fee"
                                                        class="hidden input w-full border"
                                                        value="Rp. {{ str_replace(',', '.', number_format($item->fee)) }}">
                                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                                </form>
                                            </td>

                                            <td class="text-center border-b">
                                                @if ($item->fee >= $item->projectTeam->fee)
                                                    <span class="font-medium text-theme-40">Lunas</span>
                                                @else
                                                    <div class="font-medium whitespace-no-wrap text-theme-6">Belum Lunas
                                                    </div>
                                                    <div class="text-gray-600 text-xs whitespace-no-wrap">tersisa Rp.
                                                        {{ number_format($item->projectTeam->fee - $item->fee) }}</div>
                                                @endif
                                            </td>
                                            <td class="text-center border-b">{{ $item->created_at->format('d M Y') }}</td>
                                            <td class="border-b w-5">
                                                <div class="flex sm:justify-center items-center">
                                                    <div class="dropdown relative flex items-center gap-1">
                                                        <button id="buttonEdit{{ $item->id }}"
                                                            form="edit_fee{{ $item->id }}" type="submit"
                                                            class="hidden button inline-block text-white bg-theme-1 shadow-md">
                                                            <i data-feather="save" class="w-4 h-4 font-bold"></i>
                                                        </button>
                                                        <a id="edit{{ $item->id }}"
                                                            onclick="EditFee{{ $item->id }}()" type="button"
                                                            class="button inline-block text-white bg-theme-9 shadow-md">
                                                            <i data-feather="edit-2" class="w-4 h-4 font-bold"></i>
                                                        </a>
                                                        <a id="close{{ $item->id }}"
                                                            onclick="EditFee{{ $item->id }}()" type="button"
                                                            class="hidden button inline-block text-white bg-theme-6 shadow-md">
                                                            <i data-feather="x" class=" w-4 h-4 font-bold"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="border-b">
                                            <div class="font-medium whitespace-no-wrap">Perusahaan</div>
                                        </td>
                                        <td class="w-40 border-b">
                                            <div class="flex items-center sm:justify-center">
                                                Rp. {{ number_format($detail['sisa']) }}
                                            </div>
                                        </td>

                                        <td class="text-center border-b">
                                            <span class="text-theme-40">-</span>
                                        </td>
                                        <td class="text-center border-b">{{ $project->created_at->format('d M Y') }}</td>
                                        <td class="border-b w-5">
                                            <div class="text-center">-</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> --}}
                        @if (!isset($fee_langsung))
                            <form class="mt-8" action="{{ route('project.pemasukan.langsung.store', $project->slug) }}"
                                method="post" enctype="multipart/form-data" class="mt-3" id="formLangsung"
                                x-data="activateImagePreview()">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="keuangan_project_id"
                                    value="{{ $project->keuangan_project->id }}">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                    <x-form-input label="Nama" name="name" placeholder="masukkan nama" />
                                    <x-form-input id="inputFee{{ $project->id }}" label="Price" name="price"
                                        placeholder="masukkan price" />
                                    <x-form-input type="date" label="Tanggal Penagihan" name="tanggal" />
                                </div>

                                <div class="mt-3">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                        for="single_file">Upload Bukti Pembayaran</label>
                                    <input name="lampiran"
                                        class="block w-full h-10.5 leading-9 rounded overflow-hidden text-sm text-gray-900 bg-gray-50 border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                        id="single_file" accept="image/*" @change="showPreview(event, $refs.previewSingle)"
                                        type="file">
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG or
                                        JPG.</p>
                                </div>
                                <div x-ref="previewSingle" class="mt-2">
                                </div>

                                <div class="flex justify-end">
                                    <button class="button flex align-center text-white bg-theme-1 shadow-md mt-3">
                                        <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Tambah</span>
                                    </button>
                                </div>
                                <hr class="my-4">
                            </form>
                        @else
                            <form action="{{ route('project.pemasukan.langsung.update', $project->slug) }}"
                                enctype="multipart/form-data" method="POST" class="mt-3" id="formTermin"
                                x-data="activateImagePreview()">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $fee_langsung->id }}">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                    <x-form-input label="Nama" name="name" value="{{ $fee_langsung->name }}"
                                        placeholder="masukkan nama" />
                                    <x-form-input label="Price" name="price" value="{{ $fee_langsung->price }}"
                                        placeholder="masukkan price" id="inputFee{{ $fee_langsung->id }}" />
                                    <x-form-input type="date" label="Tanggal Penagihan"
                                        value="{{ $fee_langsung->tanggal }}" name="tanggal" />
                                </div>

                                @if ($fee_langsung->lampiran == null)
                                    <div class="mt-3">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            for="single_file">Upload Bukti Pembayaran</label>
                                        <input name="lampiran"
                                            class="block w-full h-10.5 leading-9 rounded overflow-hidden text-sm text-gray-900 bg-gray-50 border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                            id="single_file" accept="image/*"
                                            @change="showPreview(event, $refs.previewSingle)" type="file">
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG
                                            or
                                            JPG.</p>
                                    </div>
                                    <div x-ref="previewSingle" class="mt-2">
                                    </div>
                                @endif

                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="button flex align-center text-white bg-theme-1 shadow-md mt-3">
                                        <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i>
                                        <span>Update</span>
                                    </button>
                                </div>
                                <hr class="my-4">
                            </form>
                            @if ($fee_langsung->lampiran != null)
                                <h3 class="font-bold text-xl">
                                    Bukti Pembayaran {{ $fee_langsung->name }}
                                </h3>
                                <div class="relative inline-block mt-3 shadow-lg border-2 border-gray-500">
                                    <form
                                        action="{{ route('project.pemasukan.langsung.lampiran.destroy', [$project->slug, $fee_langsung->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="show-alert-delete-box absolute cursor-pointer top-0 right-0 px-2 py-1 text-white bg-red-500">&times;</button>
                                    </form>
                                    <img src="{{ asset('bukti-pembayaran/' . $fee_langsung->lampiran) }}" alt="file"
                                        class="aspect-auto h-48 shadow">
                                </div>
                            @endif
                        @endif
                    @else
                        <form action="{{ route('project.pemasukan.termin.store', $project->slug) }}" method="post"
                            class="hidden mt-3" id="formTermin">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="keuangan_project_id"
                                value="{{ $project->keuangan_project->id }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                <x-form-input label="Nama Termin" name="name" placeholder="masukkan nama termin" />
                                <x-form-input id="inputFee{{ $project->id }}" label="Price" name="price"
                                    placeholder="masukkan price" />
                                <x-form-input type="date" label="Tanggal Penagihan" name="tanggal" />
                            </div>

                            <div class="flex justify-end">
                                <button class="button flex align-center text-white bg-theme-1 shadow-md mt-3">
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
                                        <th class="border-b-2 text-center whitespace-no-wrap">PRICE</th>
                                        <th class="border-b-2 text-center whitespace-no-wrap">TANGGAL PENAGIHAN</th>
                                        <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                                        <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($termin as $item)
                                        <tr>
                                            <td class="border-b">
                                                <div id="fieldFeeTermin{{ $item->id }}"
                                                    class="font-medium whitespace-no-wrap">{{ $item->name ?? '' }}</div>
                                                <form
                                                    action="{{ route('project.pemasukan.termin.store', $project->slug) }}"
                                                    method="POST" id="edit_feeTermin{{ $item->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input id="inputFeeTermin{{ $item->id }}" name="name"
                                                        class="hidden input w-full border" value="{{ $item->name }}">
                                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                                </form>
                                            </td>
                                            <td class="text-center border-b">Rp.
                                                {{ number_format($item->price, 2, ',', '.') }}</td>
                                            <td class="text-center border-b">
                                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                            <td class="text-center border-b">
                                                {{ $item->status == 1 ? 'Terbayar' : 'Belum Dibayar' }}</td>
                                            <td class="border-b w-5">
                                                <div class="flex sm:justify-center items-center">
                                                    <div class="dropdown relative flex items-center gap-1">
                                                        {{-- <button id="buttonEditTermin{{ $item->id }}"
                                                            form="edit_feeTermin{{ $item->id }}" type="submit"
                                                            class="hidden button inline-block text-white bg-theme-1 shadow-md">
                                                            <i data-feather="save" class="w-4 h-4 font-bold"></i>
                                                        </button>
                                                        <a id="editTermin{{ $item->id }}"
                                                            onclick="EditFeeTermin{{ $item->id }}()" type="button"
                                                            class="button inline-block text-white bg-theme-9 shadow-md">
                                                            <i data-feather="edit-2" class="w-4 h-4 font-bold"></i>
                                                        </a>
                                                        <a id="closeTermin{{ $item->id }}"
                                                            onclick="EditFeeTermin{{ $item->id }}()" type="button"
                                                            class="hidden button inline-block text-white bg-theme-6 shadow-md">
                                                            <i data-feather="x" class=" w-4 h-4 font-bold"></i>
                                                        </a> --}}
                                                        <a id="showTermin{{ $item->id }}"
                                                            href="{{ route('project.pemasukan.termin.detail', [$project->slug, $item->slug]) }}"
                                                            type="button"
                                                            class="button inline-block text-white bg-theme-1 shadow-md">
                                                            <i data-feather="eye" class=" w-4 h-4 font-bold"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </x-card>
@endsection

@push('scripts')
    <script>
        function activateImagePreview() {
            return {
                previews: [],

                showPreview(event, previewBox) {
                    previewBox.replaceChildren();
                    this.previews = [];

                    for (const i in event.target.files) {
                        const file = event.target.files[i];
                        const isImage = file.type.startsWith('image/');
                        const isPdf = file.type === 'application/pdf';

                        if (isImage || isPdf) {
                            this.createPreview(file, previewBox);
                        }
                    }
                },

                createPreview(file, previewBox) {
                    let previewItem = document.createElement('div');
                    previewItem.className = 'relative inline-block';

                    if (file.type.startsWith('image/')) {
                        let img = document.createElement('img');
                        img.className = 'aspect-auto h-32 shadow';
                        img.src = URL.createObjectURL(file);
                        previewItem.appendChild(img);
                    } else if (file.type === 'application/pdf') {
                        let iframe = document.createElement('iframe');
                        iframe.className = 'aspect-auto h-32 shadow';
                        iframe.src = URL.createObjectURL(file);
                        previewItem.appendChild(iframe);
                    }

                    let removeButton = document.createElement('button');
                    removeButton.innerHTML = '&times;';
                    removeButton.className = 'absolute top-0 right-0 px-2 py-1 text-white bg-red-500';
                    removeButton.addEventListener('click', () => this.removePreview(previewItem));
                    previewItem.appendChild(removeButton);

                    previewBox.appendChild(previewItem);
                    this.previews.push(previewItem);
                },

                removePreview(previewItem) {
                    this.previews = this.previews.filter(item => item !== previewItem);
                    previewItem.remove();
                }
            };
        }
    </script>
    <script>
        function formLangsung() {
            var form = document.getElementById('form');
            form.classList.toggle('hidden');
        };

        function formTermin() {
            var form = document.getElementById('formTermin');
            form.classList.toggle('hidden');
        };

        @if ($project->keuangan_project && $project->keuangan_project->type == 'termin')
            @foreach ($termin as $item)
                function EditFeeTermin{{ $item->id }}() {
                    var field{{ $item->id }} = document.getElementById('fieldFeeTermin{{ $item->id }}');
                    var input{{ $item->id }} = document.getElementById('inputFeeTermin{{ $item->id }}');
                    var button{{ $item->id }} = document.getElementById('buttonEditTermin{{ $item->id }}');
                    var close{{ $item->id }} = document.getElementById('closeTermin{{ $item->id }}');
                    var edit{{ $item->id }} = document.getElementById('editTermin{{ $item->id }}');
                    var show{{ $item->id }} = document.getElementById('showTermin{{ $item->id }}');

                    input{{ $item->id }}.classList.toggle('hidden');
                    field{{ $item->id }}.classList.toggle('hidden');
                    button{{ $item->id }}.classList.toggle('hidden');
                    close{{ $item->id }}.classList.toggle('hidden');
                    edit{{ $item->id }}.classList.toggle('hidden');
                    show{{ $item->id }}.classList.toggle('hidden');
                }
            @endforeach
        @endif

        var fee = document.getElementById('Price');
        fee.addEventListener('keyup', function(e) {
            fee.value = formatRupiah(this.value, 'Rp. ');
        });

        function formatRupiah(number, prefix) {
            var number_string = number.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                remainder = split[0].length % 3,
                rupiah = split[0].substr(0, remainder),
                ribuan = split[0].substr(remainder).match(/\d{3}/gi);

            if (ribuan) {
                separator = remainder ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.show-alert-change-payment-type', function(event) {
                var form = $(this).closest("form");

                event.preventDefault();
                Swal.fire({
                    title: "Apakah kamu yakin ingin mengubah Tipe Pembayaran?",
                    text: "Jika iya maka semua data yang ada akan terhapus.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, ubah saja!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Data pembayaran sudah bisa di atur kembali.",
                            icon: "success"
                        });
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
