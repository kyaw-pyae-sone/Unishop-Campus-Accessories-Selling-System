<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    //

    public function redirect($provider): RedirectResponse{
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider): RedirectResponse{
        $socialUser = Socialite::driver($provider)->user();

        $user = User::updateOrCreate([
            "provider_id" => $socialUser -> id,
        ],[
            "name"              => $socialUser -> name,
            "nickname"          => $socialUser -> nickname,
            "email"             => $socialUser -> email,
            "provider"          => $provider,
            "provider_id"       => $socialUser -> id,
            "provider_token"    => $socialUser -> token
        ]);

        Auth::login($user);

        return to_route("user#home");
    }
}
