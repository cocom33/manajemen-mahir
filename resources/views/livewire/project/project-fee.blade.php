<div>
    <form wire:model="">
        <div class="w-full"">
            <x-form-select
                label="Status Project"
                name="status"
                :default="[
                    'label' => $model->status ?? '',
                    'value' => $model->status ?? '',
                ]"
                :options="[
                    'penawaran' => 'Penawaran',
                    'deal'      => 'Deal',
                ]"
            />
    @if ($isset)
        <div class="w-full">
            <label for="">Pilih Type Pembayaran</label>
            <select name="type" class="input w-full border mt-2" wire:model.defer="type">
                <option value="termin">Termin</option>
                <option value="langsung">Langsung</option>
            </select>

            <input type="hidden" name="project_id" wire:model="project_id" />
        </div>
        <div class="flex justify-end mt-3">
            <button wire:click="submit()" class="button flex align-center text-white bg-theme-1 shadow-md">
                <i data-feather="plus" class=" w-4 h-4 font-bold mr-2"></i> <span>Tambah Pembayaran</span>
            </button>
        </div>
    @else
        <div class="w-full flex justify-between align-center">
            <h3 class="font-bold text-xl">
                pembayaran {{ $model->type = 'langsung' ? 'langsung' : 'per termin' }}
            </h3>
            <div>
                {{--  --}}
            </div>
        </div>
        @if ($model->type == 'langsung')

        @else

        @endif
    @endif
</div>
