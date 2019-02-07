<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\SocialAccountService;
use Laravel\Socialite\Facades\Socialite;


class SocialAuthController extends Controller
{
    /**
     * @return mixed
     */
    public function redirect()
    {
        return Socialite::driver("facebook")->redirect();
    }

    /**
     * @param SocialAccountService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(SocialAccountService $service)
    {
        $user = $service->getUser(Socialite::driver("facebook")->user());

        auth()->login($user);

        return redirect()->to("/");
    }
}