<?php

namespace App;

class SocialAccountService
{
    /**
     * @param ProviderUser $provUser
     * @return User
     */
    public function getUser(ProviderUser $provUser)
    {
        $user = User::whereEmail($provUser->getEmail())->first() ?: User::create($provUser->toUserCreationArray());
        $user->update(["avatar" => $provUser->avatar]);
        if (!SocialAccount::whereProvider("facebook")->whereProviderUserId($provUser->getId())->first()){
            $user->createSocialAccount($provUser);
        }
        return $user;
    }
}