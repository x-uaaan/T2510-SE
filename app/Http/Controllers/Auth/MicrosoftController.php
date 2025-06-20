<?php

namespace App\Http\Controllers\Auth;

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
            $userEmail = $microsoftUser->getEmail();
            $userName = $microsoftUser->getName() ?? $microsoftUser->getNickname();
            $microsoftId = $microsoftUser->getId();

            Log::info('MicrosoftCallback: Processing user callback for email: ' . $userEmail);

            // Check if user exists in the users table
            $user = User::where('email', $userEmail)->first();

            if ($user) {
                // Existing user: Store their identifying email in the session
                session(['authenticated_user_email' => $userEmail]);
                
                Log::info('MicrosoftCallback: Existing user found. Email: ' . $userEmail . '. Redirecting to events.');
                
                // Clear any leftover socialite_user_data from session if it exists
                session()->forget('socialite_user_data');

                return redirect()->route('events.index');
            } else {
                // Check if user is already in the process of completing their profile
                if (session()->has('socialite_user_data')) {
                    Log::info('MicrosoftCallback: User already has socialite data in session. Redirecting to complete-profile.');
                    return redirect()->route('complete-profile');
                }

                // New user: Store Microsoft user data in session for complete-profile page
                session([
                    'socialite_user_data' => [
                        'email' => $userEmail,
                        'name' => $userName,
                        'microsoft_id' => $microsoftId,
                    ]
                ]);
                Log::info('MicrosoftCallback: New user detected. Email: ' . $userEmail . '. Redirecting to complete-profile.');
                return redirect()->route('complete-profile');
            }
        } catch (\Exception $e) {
            Log::error('MicrosoftCallback: Error during callback: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Authentication failed. Please try again.');
        }
    }
}