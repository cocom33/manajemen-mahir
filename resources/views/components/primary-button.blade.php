<button {{ $attributes->merge(['type' => 'submit', 'class' => 'button w-20 bg-theme-10 text-white mt-10 hover:bg-theme-13 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
