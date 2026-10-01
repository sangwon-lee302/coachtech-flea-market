<x-layouts.app>
    <div class="mx-auto flex w-full max-w-xl flex-col items-center px-4 py-24">
        <p class="text-center text-xl font-bold">登録していただいたメールアドレスに認証メールを送付しました。<br />
        メール認証を完了してください。</p>

        @if (config('mail.inbox_url'))
            <a
                href="{{ config('mail.inbox_url') }}"
                target="_blank"
                rel="noopener noreferrer"
                class="mt-12 rounded-sm border border-gray-500 bg-gray-200 px-6 py-3 font-bold transition-colors hover:bg-gray-100"
                >認証はこちらから</a
            >
        @endif

        <form
            action="{{ route('verification.send') }}"
            method="POST"
            class="mt-8"
        >
            @csrf
            <button class="cursor-pointer text-blue-500 hover:underline">
                認証メールを再送する
            </button>
        </form>

        @if (session('status') === 'verification-link-sent')
            <p class="mt-8 text-green-600">認証メールを再送しました。</p>
        @endif
    </div>
</x-layouts.app>
