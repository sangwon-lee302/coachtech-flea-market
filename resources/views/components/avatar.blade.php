@props(['src'])

{{-- 画像の大きさと切り抜き方は外側で指定する。スクリプトが後から差し込む画像にも当てるためである --}}
<div
    {{ $attributes->class(['overflow-hidden rounded-full bg-gray-300 *:size-full *:object-cover']) }}
>
    @if ($src)
        <img src="{{ $src }}" alt="プロフィール画像" />
    @endif
</div>
