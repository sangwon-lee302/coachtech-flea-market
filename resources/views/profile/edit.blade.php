<x-layouts.app>
    <div class="mx-auto w-full max-w-xl px-4 py-16">
        <h1 class="text-center text-2xl font-bold">プロフィール設定</h1>

        <form
            action="{{ route('profile.update') }}"
            method="POST"
            enctype="multipart/form-data"
            novalidate
            class="mt-12"
        >
            @csrf
            @method('PATCH')

            <div class="flex flex-col gap-8">
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-8">
                        <x-avatar
                            id="avatar-preview"
                            :src="$user->avatarUrl()"
                            class="size-36 shrink-0"
                        />
                        <label
                            class="cursor-pointer rounded-sm border-2 border-red-500 px-4 py-2 font-semibold text-red-500 transition-colors hover:bg-red-50 has-focus-visible:outline-2 has-focus-visible:outline-offset-2"
                        >
                            画像を選択する
                            <input
                                name="avatar"
                                type="file"
                                accept="image/jpeg,image/png"
                                data-preview="avatar-preview"
                                class="sr-only"
                            />
                        </label>
                    </div>
                    @error('avatar')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <x-form.field
                    name="name"
                    :value="$user->name"
                    autocomplete="nickname"
                />
                <x-form.field
                    name="postal_code"
                    :value="$user->postal_code"
                    autocomplete="postal-code"
                />
                <x-form.field name="address" :value="$user->address" />
                <x-form.field name="building" :value="$user->building" />
            </div>

            <x-form.button class="mt-16 w-full">更新する</x-form.button>
        </form>
    </div>
</x-layouts.app>
