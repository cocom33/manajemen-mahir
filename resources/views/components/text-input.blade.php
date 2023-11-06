@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'input w-full border bg-gray-100 mt-2']) !!}>
