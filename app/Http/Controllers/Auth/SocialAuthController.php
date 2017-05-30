<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Socialite;
use App\Models\User;
use App\Models\Social;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();          
        } catch (Exception $e) {
            return redirect('/');
        }
        $authUser = $this->createOrGetUser($user, $provider);        
        Auth::login($authUser, true);

        return redirect('/');
    }

    private function createOrGetUser($providerUser, $provider)
    {
        $account = Social::whereProvider($provider)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        }
        $email = $providerUser->getEmail() ?? null;
        $account = new Social([
            'provider_user_id' => $providerUser->getId(),
            'provider' => $provider,
        ]);
        $user = User::whereEmail($email)->first();

        if (!$user) {
            $user = User::create([
                'email' => $email,
                'name' => $providerUser->getName(),
                'avatar' => $providerUser->getAvatar(),
            ]);
        }

        $account->user()->associate($user);
        $account->save();

        return $user;
    }

}
