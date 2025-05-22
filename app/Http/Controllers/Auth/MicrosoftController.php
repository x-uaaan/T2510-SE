<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MicrosoftController extends Controller
{
    public function redirectToMicrosoft()
    {
        return Socialite::driver('microsoft')->redirect();
    }

    public function handleMicrosoftCallback()
    {
        $microsoftUser = Socialite::driver('microsoft')->user();
        $user = User::firstOrCreate([
            'email' => $microsoftUser->getEmail(),
        ], [
            'name' => $microsoftUser->getName() ?? $microsoftUser->getNickname(),
            // Add other fields as needed
        ]);
        Auth::login($user, true);
        return redirect()->intended('/');
    }
}