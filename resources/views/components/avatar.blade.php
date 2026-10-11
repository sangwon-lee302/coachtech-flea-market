@props(['src'])

<div {{ $attributes->class(['overflow-hidden rounded-full bg-gray-300']) }}>
    @if ($src)
        <img
            src="{{ $src }}"
            alt="プロフィール画像"
            class="size-full object-cover"
        />
    @endif
</div>
