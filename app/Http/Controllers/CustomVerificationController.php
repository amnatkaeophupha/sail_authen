<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class CustomVerificationController extends Controller
{
    public function show()
    {
        return view('auth.verify-email'); // Your custom email verification view
    }

    public function verify(Request $request, $id, $hash)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Check if the hash matches
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link.');
        }

        // Check if the user is already verified
        if ($user->hasVerifiedEmail()) {
            return redirect('signin')->with('message', 'Email already verified.');
        }

        // Mark the email as verified
        $user->markEmailAsVerified();

        // Trigger the Verified event
        event(new Verified($user));

        return redirect('signin')->with('message', 'Email successfully verified.');
    }

}
