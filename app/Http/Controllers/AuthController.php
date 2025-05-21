<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Redirect the user to the Microsoft authentication page.
     */
    public function redirectToMicrosoft()
    {
        return Socialite::driver('microsoft')->redirect();
    }

    /**
     * Handle the callback from Microsoft after authentication.
     */
    public function handleMicrosoftCallback()
    {
        try {
            $user = Socialite::driver('microsoft')->user();

            $userId = $user->getId(); // Microsoft ID
            $email = $user->getEmail(); // User's email

            $existingUser = User::where('microsoft_id', $userId)->orWhere('email', $email)->first();

            return response()->json($user);
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Authentication failed!');
        }
    }
}