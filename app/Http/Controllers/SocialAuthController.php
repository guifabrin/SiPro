<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\SocialAccountService;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Base\Controller;


class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver("facebook")->redirect();
    }

    public function callback(SocialAccountService $service)
    {
        $user = $service->getUser(Socialite::driver("facebook")->user());

        auth()->login($user);

        return redirect()->to("/");
    }
}