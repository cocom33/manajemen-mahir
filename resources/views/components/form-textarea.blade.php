@props(['label', 'name', 'value', 'class' => '', 'placeholder' => '', 'rows' =>"3", 'wraperattribute' => true, 'required' => 'true'])

@php
  $trimmedValue = trim($value ?? old($name));
@endphp

<div class="mb-3">
  <label class="{{ $class }}">{{ $label }}{{ $required == 'true' ? '*' : '' }}</label>
  <textarea
    {{ $attributes }}
    name="{{ $name }}"
    class="input w-full border mt-2"
    placeholder="{{ $placeholder }}"
    rows="{{ $rows }}"
    {{ $required == 'true' ? 'required' : '' }}
  >{{ $trimmedValue }}</textarea>
</div>
