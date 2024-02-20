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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-3">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                    for="single_file">Upload Bukti Pembayaran</label>
                <input name="lampiran"
                    class="block w-full h-10.5 leading-9 rounded overflow-hidden text-sm text-gray-900 bg-gray-50 border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    id="single_file" accept="image/*" @change="showPreview(event, $refs.previewSingle)"
                    type="file">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG or
                    JPG.</p>
            </div>
            <div>
                <label for="bank">Pilih Bank*</label>
                <select name="bank_id" id="bank" class="input w-full border mt-2" required>
                    <option value=""></option>
                    @foreach ($banks as $bank)
                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div x-ref="previewSingle" class="mt-2">
        </div>

        <div class="flex justify-end">
            <div class="flex items-center mr-3 mt-2">
                <input type="checkbox" name="lunas" id="lunas" class="mr-1">
                <label for="lunas">Tandai Lunas</label>
            </div>
            <button class="button flex align-center text-white bg-theme-1 shadow-md mt-3">
                <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i>
                <span>Tambah</span>
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

        <div class="mt-3 gap-5 grid grid-flow-col auto-cols-max">
            @if ($fee_langsung->lampiran == null)
                <div class="col">
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
            @endif
            <div class="col-auto">
                <label for="bank">Pilih Bank*</label>
                <select name="bank_id" id="bank" class="input w-full border mt-2" required>
                    <option value="{{ $fee_langsung->bank_id }}">{{ $fee_langsung->bank->name }}</option>
                    @foreach ($banks as $bank)
                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div x-ref="previewSingle" class="mt-2">
        </div>

        <div class="flex justify-end">
            <div class="flex items-center mr-3 mt-2">
                <input type="checkbox" name="lunas" id="lunas" class="mr-1">
                <label for="lunas">Tandai Lunas</label>
            </div>
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
            <img src="{{ asset('storage/' . $fee_langsung->lampiran) }}" alt="file"
                class="aspect-auto h-48 shadow">
        </div>
    @endif
@endif
