@props(['label', 'name', 'value', 'options', 'default', 'is_multiple' => false, 'wraperattribute' => true, 'required' => 'true', 'pesan' => '']) {{-- options format: [id => 'name'] (created using pluck) --}}


<div class="mb-3">
	<label class="my-1 me-2" for="{{ $label }}">{{ $label }}{{ $required == 'true' ? '*' : '' }}</label>
	<select
        data-hide-search="true"
		name		  ={{ $name }}
		class			="input w-full border mt-2 select2"
		id				="{{ $label }}"
		aria-label="select {{ $label }}"
		{{ $attributes }}
	>
	Type <span x-text="type"></span>

	@isset($default)
		<option value="{{ $default['value'] }}" class="hidden" selected>{{ $default['label'] }}</option>
	@endisset
	@foreach ($options as $optionId => $optionName)
		<option
			value="{{ $optionName->id ?? $optionId }}"
			@if((string)$optionId === (string)old($name, $value ?? null))
				selected
			@endif
		>
			{{ $optionName->name ?? $optionName }}
		</option>
	@endforeach
	</select>
	<small>Pilih salah satu.</small>
	@if ($pesan)
	    <br>
    	<small>{{ $pesan }}</small>
    @endif
	{{-- @error($name)
		<div class="invalid-feedback">
			{{ $message }}
		</div>
	@enderror --}}
</div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/cdn.min.js"></script>
