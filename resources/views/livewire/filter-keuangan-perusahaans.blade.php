<div>
    <div class="intro-y datatable-wrapper box p-5 mt-5 flex gap-6">
        <div class="w-full">
            <label>Tahun</label>
            <div class="mt-2">
                <select  data-hide-search="true" class="select2 w-full">
                    <option value="1">{{ $data->tahun }}</option>
                </select>
            </div>
        </div>
        <div class="w-full">
            <label>Bulan</label>
            <div class="mt-2">
                <select  data-hide-search="true" class="select2 w-full">
                    @foreach ($data->bulan as $item)
                        <option value="{{ $item->bulan }}"> {{ \Carbon\Carbon::create()->month($item->bulan)->format('F') }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
