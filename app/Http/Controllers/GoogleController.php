<?php

namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Redirect to Google for authentication
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function callbackGoogle()
{
    $user = Socialite::driver('google')->user();

    // Check if user already exists
    $existingUser = User::where('email', $user->getEmail())->first();

    if ($existingUser) {
        Auth::login($existingUser);
    } else {
        // Create a new user
        $newUser = User::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => bcrypt(Str::random(16)), // Generate a random password
        ]);

        Auth::login($newUser);
    }

   
    // if (session()->pull('checkout_redirect', false)) {
    //     return redirect()->route('checkout')->with('success', 'Logged in successfully!');
    // }

    return redirect()->intended(route('user.dashboard'))->with('success', 'Logged in successfully!');
}
}
