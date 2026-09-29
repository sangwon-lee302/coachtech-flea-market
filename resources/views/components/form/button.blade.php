<button
    {{ $attributes->class(['cursor-pointer rounded-sm bg-red-500 px-4 py-2 font-semibold text-white transition-colors hover:bg-red-400 active:bg-red-300']) }}
>
    {{ $slot }}
</button>
