<?php

namespace App\Services;

use App\Models\SocialFacebookAccount;
use App\Models\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialFacebookAccountService
{
    public function createOrGetUser(ProviderUser $providerUser, $provide)
    {
        $account = SocialFacebookAccount::whereProvider($provide)
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $account = new SocialFacebookAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $provide
            ]);
            $user = [];
            if(!empty($providerUser->getEmail())) {
                $user = User::whereEmail($providerUser->getEmail())->first();
            }
            if (empty($user)) {
                $user = User::create([
                    'email' => $providerUser->getEmail() ?? 'abc@yopmail.com',
                    'name' => $providerUser->getName(),
                    'password' => bcrypt(111111),
                    'avatar_url' => $providerUser->getAvatar(),
                    'role' => 1,
                ]);
            }
            $account->user()->associate($user);
            $account->save();
            return $user;
        }
    }
}
