<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Mail\PasswordResetOtp;


use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Import the Log facade
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


class CustomerController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('harsh.forgot_password'); // Make sure this view exists
    }

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $email = $request->input('email');
        $otp = mt_rand(100000, 999999); // Generate a 6-digit OTP
        $customer = User::where('email', $email)->first(); // Use $customer instead of $user
        if(!$customer){
           return redirect()->back()->with('error', 'Customer not found.');
        }
        if ($customer) {
            $customer->otp = $otp;
             $customer->otp_expiry = now()->addMinutes(10); // OTP expires in 10 minutes
            $customer->save();

            // Send OTP via email
            $emailMessage = 'Here is your OTP to reset your password.'; // Explicitly create a string
            $emailSubject = 'Your OTP for Password Reset';

            Mail::to($email)->send(new PasswordResetOtp(  // Updated Mailable class name
                $emailMessage,
                $emailSubject,
                (string) $otp  // Explicitly cast OTP to a string
            ));

            Session::put('reset_email', $email); // Store email in session for later use

            return redirect()->route('otp.verification.form')->with('success', 'OTP sent to your email address.');
        }

        return redirect()->back()->with('error', 'User not found.'); // Should not happen, as validation checks for email existence
    }


    public function showOtpVerificationForm()
    {
        return view('harsh.otp-verification'); // Create this view
    }

    public function verifyOtps(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $otp = $request->input('otp');
        $email = Session::get('reset_email');

        if (!$email) {
            return redirect()->route('forgot.password.form')->with('error', 'Email not found in session. Please request OTP again.');
        }

        $customer = User::where('email', $email)->first();

        if (!$customer) {
            return redirect()->route('forgot.password.form')->with('error', 'User not found.');
        }

         // Check for OTP expiry
         if ($customer->otp_expiry < now()) {
            $customer->otp = null;
            $customer->otp_expiry = null;
            $customer->save();
            return redirect()->back()->with('error', 'OTP has expired. Please request a new one.');
        }

        if ($customer->otp == $otp ) {
            // Clear OTP and expiry after successful verification
            $customer->otp = null;
             $customer->otp_expiry = null;
            $customer->save();

            Session::put('reset_token', Str::random(60)); // Generate a reset token
            return redirect()->route('reset.password.form')->with('success', 'OTP verified successfully.');
        } else {
            return redirect()->back()->with('error', 'Invalid OTP or OTP has expired.');
        }
    }

    public function showResetPasswordForm()
    {
        // Verify reset token
        if (!Session::has('reset_token')) {
            return redirect()->route('forgot.password.form')->with('error', 'Invalid reset link.');
        }
        return view('harsh.reset-password'); // Create this view
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => [
                'required',
                'min:8',
                'confirmed',
                function ($attribute, $value, $fail) {
                    // Check for at least one numeric character
                    if (!preg_match('/[0-9]/', $value)) {
                        $fail('The password must contain at least one numeric character or alphabatic or special character.');
                    }

                    // Check for at least one alphabetic character
                    if (!preg_match('/[a-zA-Z]/', $value)) {
                        $fail('The password must contain at least one alphabetic character.');
                    }

                    // Check for at least one special character
                    if (!preg_match('/[^a-zA-Z0-9]/', $value)) {
                        $fail('The password must contain at least one special character.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $email = Session::get('reset_email');

        if (!$email) {
            toastr()->error('Your Email is Not registered.');
            return redirect()->route('forgot.password.form')->with('error', 'Email not found in session. Please request OTP again.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('forgot.password.form')->with('error', 'User not found.');
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        Session::forget('reset_email');
        Session::forget('reset_token');
        return redirect()->route('login')->with('success', 'Password reset successfully. Please log in.');
    }
}
