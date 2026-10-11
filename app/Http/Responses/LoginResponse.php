<?php

namespace App\Http\Responses;

use Laravel\Fortify\Http\Responses\LoginResponse as FortifyLoginResponse;

class LoginResponse extends FortifyLoginResponse
{
    public function toResponse($request)
    {
        if (! $request->user()?->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return parent::toResponse($request);
    }
}
