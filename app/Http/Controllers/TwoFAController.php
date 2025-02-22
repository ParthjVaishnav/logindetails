<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TwoFAController extends Controller
{
    protected $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    public function show2FASetup()
{
    $user = Auth::user();

    // If 2FA is already enabled, redirect to the dashboard
    if ($user->google2fa_enabled) {
        return redirect('/dashboard')->with('info', '2FA is already enabled.');
    }

    // Generate secret key only if not already set
    if (!$user->google2fa_secret) {
        $user->google2fa_secret = app('pragmarx.google2fa')->generateSecretKey();
        $user->save();
    }

    // Generate QR Code
    $qrCodeUrl = app('pragmarx.google2fa')->getQRCodeUrl(
        'YourAppName',
        $user->email,
        $user->google2fa_secret
    );

    $qrCodeImage = QrCode::size(200)->generate($qrCodeUrl);

    return view('auth.2fa_setup', compact('qrCodeImage', 'qrCodeUrl'));
}

public function verify2FA(Request $request)
{
    $request->validate(['code' => 'required|numeric']);
    
    $user = Auth::user();
    $google2fa = app('pragmarx.google2fa');

    if ($google2fa->verifyKey($user->google2fa_secret, $request->code)) {
        // Enable 2FA for the user
        $user->google2fa_enabled = true;
        $user->save();

        session(['2fa_verified' => true]);
        return redirect('/dashboard')->with('success', '2FA Verification Successful!');
    }

    return back()->withErrors(['code' => 'Invalid OTP, try again.']);
}

}
