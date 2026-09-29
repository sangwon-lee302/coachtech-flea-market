@props(['title', 'action', 'button', 'linkHref', 'linkText'])

<div class="mx-auto w-full max-w-xl px-4 py-16">
    <h1 class="text-center text-2xl font-bold">{{ $title }}</h1>

    <form action="{{ $action }}" method="POST" novalidate class="mt-12">
        @csrf

        <div class="flex flex-col gap-8">{{ $slot }}</div>

        <x-form.button class="mt-16 w-full">{{ $button }}</x-form.button>
    </form>

    <a
        href="{{ $linkHref }}"
        class="mx-auto mt-8 block w-fit text-blue-500 hover:underline"
        >{{ $linkText }}</a
    >
</div>
