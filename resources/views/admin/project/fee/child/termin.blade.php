<form action="{{ route('project.pemasukan.termin.store', $project->slug) }}" method="post"
    class="hidden mt-3" id="formTermin">
    @csrf
    @method('PUT')
    <input type="hidden" name="keuangan_project_id"value="{{ $project->keuangan_project->id }}">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <x-form-input label="Nama Termin" name="name" placeholder="masukkan nama termin" />
        <div id="harga">
            <x-form-input label="Price" name="harga" placeholder="masukkan price" required="false" />
        </div>
        <div id="persen" class="hidden">
            <x-form-input label="Persen" name="price" placeholder="masukkan persenan" required="false" />
        </div>
        <x-form-input type="date" label="Tanggal Penagihan" name="tanggal" />

        <div>
            <label for="bank">Pilih Bank*</label>
            <select name="bank_id" id="bank" class="input w-full border mt-2" required>
                <option value=""></option>
                @foreach ($banks as $bank)
                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="type">Type Harga*</label>
            <select name="type" id="type" class="input w-full border mt-2" required>
                <option value="harga">Price</option>
                <option value="persen">Persen</option>
            </select>
        </div>
        <div class="flex justify-end items-end">
            <button class="button flex align-center  text-white bg-theme-1 shadow-md mt-3">
                <i data-feather="plus" class=" w-4 h-4 mt-1 font-bold mr-2"></i> <span>Tambah</span>
            </button>
        </div>
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
                <th class="border-b-2 text-center whitespace-no-wrap">BANK</th>
                <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($termin as $key => $item)
                <tr>
                    <td class="border-b">
                        <div class="font-medium whitespace-no-wrap"><span class="hidden">{{ $key }}</span>{{ $item->name ?? '' }}</div>
                    </td>
                    <td class="text-center border-b">Rp.
                        {{ number_format($item->price, 2, ',', '.') }}
                        @if ($project->harga_deal)
                             / {{ current(explode(".", $item->price * 100 / $project->harga_deal)) }}%
                        @endif
                    </td>
                    <td class="text-center border-b">
                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                    </td>
                    <td class="text-center border-b">
                        {{ $item->bank->name }}
                    </td>
                    <td class="text-center border-b">
                        {{ $item->status == 1 ? 'Terbayar' : 'Belum Dibayar' }}
                    </td>
                    <td class="border-b w-5">
                        <div class="flex sm:justify-center items-center">
                            <div class="dropdown relative flex items-center gap-1">
                                <a href="{{ route('project.pemasukan.termin.detail', [$project->slug, $item->slug]) }}"
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
