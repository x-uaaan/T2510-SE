<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Alumni;   // Make sure these models exist
use App\Models\Lecturer; // Make sure these models exist
use App\Models\Admin;    // Make sure these models exist
use Illuminate\Support\Facades\Log;

class CustomAuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authenticatedUserEmail = session('authenticated_user_email');
        Log::info('CustomAuthCheck: Checking for authenticated_user_email. Found: ' . ($authenticatedUserEmail ? 'Yes' : 'No'));

        if ($authenticatedUserEmail) {
            // Verify that the email actually exists in one of the tables
            $alumni = Alumni::where('alumniEmail', $authenticatedUserEmail)->first();
            $lecturer = Lecturer::where('lecturerEmail', $authenticatedUserEmail)->first();
            $admin = Admin::where('AdminEmail', $authenticatedUserEmail)->first();

            if ($alumni || $lecturer || $admin) {
                // User is considered authenticated and verified
                Log::info('CustomAuthCheck: User ' . $authenticatedUserEmail . ' is valid. Proceeding.');
                return $next($request);
            }
        }

        // If not authenticated or not verified, redirect to home/landing page
        Log::warning('CustomAuthCheck: User not authenticated or invalid email in session. Redirecting to home.');
        return redirect()->route('home');
    }
}