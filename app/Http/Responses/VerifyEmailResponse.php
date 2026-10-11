<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\VerifyEmailResponse as VerifyEmailResponseContract;

class VerifyEmailResponse implements VerifyEmailResponseContract
{
    public function toResponse($request)
    {
        // ログイン前に開こうとしていた画面には戻さないので、後から使われないように、覚えておいた URL を捨てる。
        $request->session()->forget('url.intended');

        return redirect()->route('profile.edit');
    }
}
