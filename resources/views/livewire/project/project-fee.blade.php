<div>
    <form wire:model="">
        <div class="w-full">
            <x-form-select
                label="Status Project"
                name="status"
                :default="[
                    'label' => $model->status ?? '',
                    'value' => $model->status ?? '',
                ]"
                :options="[
                    'penawaran' => 'penawaran',
                    'deal'      => 'deal',
                ]"
            />
        </div>
        <div class="flex justify-end mt-3">
            <a class="button flex align-center text-white bg-theme-1 shadow-md">
                <i data-feather="plus" class=" w-4 h-4 font-bold mr-2"></i> <span>Tambah Pembayaran</span>
            </a>
        </div>
    </form>
</div>
