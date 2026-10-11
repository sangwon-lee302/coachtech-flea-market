<x-layouts.app>
    <div
        class="mx-auto flex w-full max-w-5xl flex-wrap items-center justify-between gap-8 px-4 py-16 sm:px-8"
    >
        <div class="flex min-w-0 items-center gap-4 sm:gap-8">
            <x-avatar
                :src="$user->avatarUrl()"
                class="size-24 shrink-0 sm:size-36"
            />
            <h1 class="min-w-0 text-2xl font-bold wrap-anywhere">
                {{ $user->name }}
            </h1>
        </div>
        <a
            href="{{ route('profile.edit') }}"
            class="rounded-sm border-2 border-red-500 px-4 py-2 font-semibold text-red-500 transition-colors hover:bg-red-50"
            >プロフィールを編集</a
        >
    </div>
</x-layouts.app>
