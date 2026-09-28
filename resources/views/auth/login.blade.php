<x-layouts.app>
    <x-auth-card
        title="ログイン"
        :action="route('login')"
        button="ログインする"
        :link-href="route('register')"
        link-text="会員登録はこちら"
    >
        <x-form.field name="email" type="email" autocomplete="username" />
        <x-form.field
            name="password"
            type="password"
            autocomplete="current-password"
        />
    </x-auth-card>
</x-layouts.app>
