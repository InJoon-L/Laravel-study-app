<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleSocialiteController extends Controller
{
    public function redirectToGoogle() {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleCallback() {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $finduser = User::where('social_id', $user->id)->first();

            if ($finduser) {
                auth('api')->login($finduser);
                return $user;
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'social_type' => 'google',
                    'password' => encrypt('my-google'),
                ]);

                auth('api')->login($newUser);

                return $newUser;
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
