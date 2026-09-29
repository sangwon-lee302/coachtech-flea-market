@props(['name', 'type' => 'text'])

<div class="flex flex-col gap-1">
    <label
        for="{{ $name }}"
        class="font-bold"
        >{{ __("validation.attributes.$name") }}</label
    >
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        @if ($type !== 'password') value="{{ old($name) }}" @endif
        {{ $attributes->class(['rounded-sm border border-gray-500 p-2']) }}
    />
    @error($name)
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
