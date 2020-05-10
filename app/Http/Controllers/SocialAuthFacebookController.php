<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;
use App\Services\SocialFacebookAccountService;

class SocialAuthFacebookController extends Controller
{
    /**
     * Create a redirect method to facebook api.
     *
     * @return void
     */
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback(SocialFacebookAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user(), 'facebook');
        auth()->guard('user')->login($user);
        return back();
    }

    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callbackGoogle(SocialFacebookAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('google')->user(), 'google');
        auth()->guard('user')->login($user);
        return redirect('/');
    }

    public function redirectTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callbackTwitter(SocialFacebookAccountService $service)
    {
        try {
            $user = $service->createOrGetUser(Socialite::driver('twitter')->user(), 'twitter');
        } catch (\Exception $e) {
            return redirect('/');
        }
        auth()->guard('user')->login($user);
        return back();
    }

    private function guard()
    {
        return Auth::guard('user');
    }
}
