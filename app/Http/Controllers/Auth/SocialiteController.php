<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['msg' => 'Unable to login, please try again.']);
        }

        $existingUser = User::where('email', $user->getEmail())->first();
        if ($existingUser) {
            auth()->login($existingUser, true);
        } else {
            $newUser = $this->createUser($user);

            auth()->login($newUser, true);
        }

        return redirect()->to('/');
    }

    protected function createUser($user)
    {
        $newUser = User::updateOrCreate([
            'email' => $user->getEmail(),
        ], [
            'name'     => $user->getName(),
            'password' => '',
            'avatar'   => $user->getAvatar(),
        ]);

        if ($newUser->markEmailAsVerified()) {
            event(new Verified($newUser));
        }

        return $newUser;
    }
}
