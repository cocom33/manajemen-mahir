@props(['label', 'name', 'value', 'pesan' => '', 'placeholder' => '','type'=> 'text', 'class' => '', 'readonly', 'uppercase' => false , 'wraperattribute' => true, 'required' => 'true', 'addon' => ''])

<div class="mb-3 {{ $addon }} ">
  <label for="{{ $label }}" class="{{ $class }}">{{ $label }}{{ $required == 'true' ? '*' : '' }}</label>
  <input
    class      ="input w-full border mt-2"
    type       ="{{ $type }}"
    id         ="{{ $label }}"
    placeholder="{{ $placeholder }}"
    value      ="{{ old($name, $value ?? null) }}"
    name       ="{{ $name }}"
    style      ="{{ $uppercase ? 'text-transform: uppercase' : '' }}"
    {{ $readonly ?? '' }}
    {{ $attributes }}
    {{ $required == 'true' ? 'required' : '' }}
  >
  <div class="mb-3">
    {{ $slot }}
  </div>

  @if ($pesan)
	<small>{{ $pesan }}</small>
  @endif
</div>
