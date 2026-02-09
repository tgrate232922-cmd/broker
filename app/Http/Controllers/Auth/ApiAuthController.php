<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Models\CryptoAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ApiAuthController extends Controller
{
    use PasswordValidationRules;

    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'string', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'regex:/^[0-9+()-]+$/'],
            'country' => ['required', 'string'],
            'password' => $this->passwordRules(),
            'captcha' => ['required', 'string', 'size:6', function ($attribute, $value, $fail) {
                $captchaConfirmation = request()->input('captcha_confirmation');
                if (strtoupper($value) !== strtoupper($captchaConfirmation)) {
                    $fail('The security verification code is incorrect.');
                }
            }],
            'agree' => ['required', 'accepted'],
        ], [
            // Custom error messages
            'username.required' => 'Please enter a username.',
            'username.unique' => 'This username is already taken.',
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'phone.required' => 'Please enter your phone number.',
            'phone.regex' => 'Phone number can only contain numbers and symbols: + ( ) -',
            'country.required' => 'Please select your country.',
            'password.required' => 'Please enter a password.',
            'captcha.required' => 'Please enter the security verification code.',
            'captcha.size' => 'The security code must be exactly 6 characters.',
            'agree.required' => 'You must agree to the terms and conditions.',
            'agree.accepted' => 'You must agree to the terms and conditions.',
        ]);

        // Create user
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'username' => $request['username'],
            'country' => $request['country'],
            'status' => 'active',
            'password' => Hash::make($request['password']),
        ]);

        // Create crypto account
        $cryptoaccnt = new CryptoAccount();
        $cryptoaccnt->user_id = $user->id;
        $cryptoaccnt->save();

        // Handle referral if exists
        if ($request->has('ref_by') && !empty($request->ref_by)) {
            $user->ref_by = $request->ref_by;
            $user->save();
        }

        // Send welcome email
        try {
            Mail::to($user->email)->send(new WelcomeEmail($user));
        } catch (\Exception $e) {
            // Log email error but don't fail registration
            \Log::error('Welcome email failed: ' . $e->getMessage());
        }

        // Log the user in automatically
        auth()->login($user);

        return response()->json([
            'message' => 'Registration is successful.',
            'status_code' => 200,
        ]);
    }
}