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
                                        class="show-alert-change-payment-type button flex align-center text-white bg-theme-6 shadow-md">
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
                                        class="show-alert-change-payment-type button flex align-center text-white bg-theme-6 shadow-md">
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
                        @include('admin.project.fee.child.langsung')
                    @else
                        @include('admin.project.fee.child.termin')
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

        var fee = document.getElementById('Price');
        fee.addEventListener('keyup', function(e) {
            fee.value = formatRupiah(this.value, 'Rp. ');
        });

        var persen = document.getElementById('persen');
        var harga = document.getElementById('harga');
        var type = document.getElementById('type');
        type.addEventListener('change', function(e) {
            if (type.value == 'harga') {
                harga.classList.remove('hidden');
                persen.classList.add('hidden');
            }
            if (type.value == 'persen') {
                harga.classList.add('hidden');
                persen.classList.remove('hidden');
            }
        })

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
