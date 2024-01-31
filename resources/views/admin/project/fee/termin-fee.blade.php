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
            </div>

            <div class="mt-8">
                <form action="{{ route('project.pemasukan.termin.detail.store', [$project->slug, $termin->id]) }}"
                    enctype="multipart/form-data" method="POST" class="mt-3" id="formTermin" x-data="activateImagePreview()">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $termin->id }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <x-form-input label="Nama Termin" name="name" value="{{ $termin->name }}"
                            placeholder="masukkan nama termin" />
                        <x-form-input label="Price" name="price" value="{{ $termin->price }}"
                            placeholder="masukkan price" id="inputFee{{ $termin->id }}" />
                        <x-form-input type="date" label="Tanggal Penagihan" value="{{ $termin->tanggal }}"
                            name="tanggal" />
                    </div>

                    @if ($termin->lampiran == null)
                        <div class="mt-3">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                for="single_file">Upload Bukti Pembayaran</label>
                            <input name="lampiran"
                                class="block w-full h-10.5 leading-9 rounded overflow-hidden text-sm text-gray-900 bg-gray-50 border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                id="single_file" accept="image/*" @change="showPreview(event, $refs.previewSingle)"
                                type="file">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG or JPG.</p>
                        </div>
                        <div x-ref="previewSingle" class="mt-2">
                        </div>
                    @endif

                    <div class="flex justify-end">
                        <button type="submit" class="button flex align-center text-white bg-theme-1 shadow-md mt-3">
                            <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Update</span>
                        </button>
                    </div>
                    <hr class="my-4">
                </form>
                @if ($termin->lampiran != null)
                    <h3 class="font-bold text-xl">
                        Bukti Pembayaran {{ $termin->name }}
                    </h3>
                    <div class="relative inline-block mt-3 shadow-lg border-2 border-gray-500">
                        <form action="{{ route('project.lampiran.pemasukan.destroy', [$project->slug, $termin->id]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="show-alert-delete-box absolute cursor-pointer top-0 right-0 px-2 py-1 text-white bg-red-500">&times;</button>
                        </form>
                        <img src="{{ asset('bukti-pembayaran/' . $termin->lampiran) }}" alt="file"
                            class="aspect-auto h-48 shadow">
                    </div>
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
        function formTermin() {
            var form = document.getElementById('formTermin');
            form.classList.toggle('hidden')
        }

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
@endpush
