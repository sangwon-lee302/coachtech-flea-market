<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(#[CurrentUser] User $user): View
    {
        return view('profile.show', ['user' => $user]);
    }

    public function edit(#[CurrentUser] User $user): View
    {
        return view('profile.edit', ['user' => $user]);
    }

    public function update(UpdateProfileRequest $request, #[CurrentUser] User $user): RedirectResponse
    {
        $attributes = $request->safe(['name', 'postal_code', 'address', 'building']);
        $oldAvatarPath = null;

        if ($request->hasFile('avatar')) {
            $oldAvatarPath = $user->avatar_path;
            $attributes['avatar_path'] = $request->file('avatar')->store('avatars');
        }

        $user->update($attributes);

        // 古い画像は、新しい画像の保存とパスの更新が済んでから消す。先に消すと、途中で失敗したときに画像を失う
        if ($oldAvatarPath !== null) {
            Storage::delete($oldAvatarPath);
        }

        return redirect()->route('profile.show');
    }
}
