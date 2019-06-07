<?php

namespace App;

use Laravel\Socialite\Contracts\User as SocialiteUser;

class ProviderUser extends SocialiteUser {
    public function toUserCreationArray() {
        return [
            "email" => $this->getEmail(),
            "name" => $this->getName(),
            "avatar" => $this->avatar,
        ];
    }
}