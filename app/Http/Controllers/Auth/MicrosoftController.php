<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
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

    public function handleMicrosoftCallback(Request $request)
    {
        try {
            // Add debugging for the callback parameters
            Log::info('MicrosoftCallback: Received callback with parameters: ' . json_encode($request->all()));
            
            // Check if there's an error in the callback
            if ($request->has('error')) {
                Log::error('MicrosoftCallback: OAuth error received: ' . $request->get('error'));
                Log::error('MicrosoftCallback: OAuth error description: ' . $request->get('error_description', 'No description'));
                return redirect()->route('home')->with('error', 'Microsoft authentication failed: ' . $request->get('error_description', 'Unknown error'));
            }
            
            // Check if we have the required code parameter
            if (!$request->has('code')) {
                Log::error('MicrosoftCallback: No authorization code received');
                return redirect()->route('home')->with('error', 'Authorization code not received from Microsoft');
            }
            
            Log::info('MicrosoftCallback: Attempting to get user from Microsoft...');
            $microsoftUser = Socialite::driver('microsoft')->user();
            
            $userEmail = $microsoftUser->getEmail();
            $userName = $microsoftUser->getName() ?? $microsoftUser->getNickname();
            $microsoftId = $microsoftUser->getId();

            Log::info('MicrosoftCallback: Processing user callback for email: ' . $userEmail);

            // Check if user exists in the users table
            $user = User::where('email', $userEmail)->first();

            if ($user) {
                // Existing user: Properly authenticate them
                Log::info('MicrosoftCallback: Existing user found. UserID: ' . $user->userID . ', Email: ' . $userEmail);
                
                // Regenerate session to prevent session fixation attacks
                $request->session()->regenerate();
                
                // Log the user in using Laravel's authentication system (without remember me for now)
                Auth::login($user, false); // Changed to false to avoid remember token issues
                
                // Explicitly save the session
                $request->session()->save();
                
                // Verify authentication worked
                if (Auth::check()) {
                    Log::info('MicrosoftCallback: User successfully authenticated. UserID: ' . Auth::id());
                    
                    // Store additional session data for debugging
                    session([
                        'microsoft_authenticated' => true,
                        'microsoft_user_id' => $microsoftId,
                        'authenticated_at' => now()->toDateTimeString()
                    ]);
                    
                    // Clear any leftover socialite_user_data from session if it exists
                    session()->forget('socialite_user_data');

                    Log::info('MicrosoftCallback: Redirecting authenticated user to events page.');
                    return redirect()->route('events.index');
                } else {
                    Log::error('MicrosoftCallback: Authentication failed for user: ' . $userEmail);
                    return redirect()->route('home')->with('error', 'Authentication failed. Please try again.');
                }
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
            Log::error('MicrosoftCallback: Stack trace: ' . $e->getTraceAsString());
            
            // Clear any problematic session data
            session()->forget(['socialite_user_data', 'microsoft_authenticated']);
            
            return redirect()->route('home')->with('error', 'Authentication failed. Please try again.');
        }
    }
}