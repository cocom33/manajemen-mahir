<div>
    <div class="intro-y datatable-wrapper box p-5 mt-5 flex gap-6">
        <div class="w-full">
            <label>Search</label>
            <div class="mt-2">
                <input wire:model="query" wire:keyup.debounce="filter" type="text" class="input w-full border" placeholder="Search for...">
            </div>
        </div>
        <div class="w-full">
            <label>Tahun</label>
            <div class="mt-2">
                <select class="select2 w-full">
                    <option value="{{ $data->id }}">{{ $data->tahun }}</option>
                </select>
            </div>
        </div>
        <div class="w-full">
            <label>Bulan</label>
            <div class="mt-2">
                <select wire:model="bulan_id" wire:change="filter" class="select2 w-full">
                    @foreach ($data->bulan as $item)
                        <option value="{{ $item->id }}"> {{ \Carbon\Carbon::create()->month($item->bulan)->format('F') }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
