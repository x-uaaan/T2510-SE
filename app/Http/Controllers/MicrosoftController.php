<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class MicrosoftController extends Controller
{
    public function redirectToMicrosoft()
    {
        try {
            return Socialite::driver('microsoft')->redirect();
        } catch (Exception $e) {
            Log::error('Microsoft redirect error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to connect to Microsoft. Please try again.');
        }
    }

    public function handleMicrosoftCallback()
    {
        try {
            $microsoftUser = Socialite::driver('microsoft')->user();
            
            $user = User::updateOrCreate(
                ['email' => $microsoftUser->getEmail()],
                [
                    'name' => $microsoftUser->getName() ?? $microsoftUser->getNickname(),
                    'microsoft_id' => $microsoftUser->getId(),
                    'avatar' => $microsoftUser->getAvatar(),
                    'email_verified_at' => now(),
                ]
            );

            Auth::login($user, true);

            // Check if profile needs completion
            if (!$user->profile_completed) {
                return redirect()->route('complete-profile');
            }

            return redirect()->intended('/');
        } catch (Exception $e) {
            Log::error('Microsoft callback error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to authenticate with Microsoft. Please try again.');
        }
    }
}