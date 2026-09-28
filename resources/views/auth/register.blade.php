<x-layouts.app>
    <x-auth-card
        title="会員登録"
        :action="route('register')"
        button="登録する"
        :link-href="route('login')"
        link-text="ログインはこちら"
    >
        <x-form.field name="name" autocomplete="nickname" />
        <x-form.field name="email" type="email" autocomplete="email" />
        <x-form.field
            name="password"
            type="password"
            autocomplete="new-password"
        />
        <x-form.field
            name="password_confirmation"
            type="password"
            autocomplete="new-password"
        />
    </x-auth-card>
</x-layouts.app>
