<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FAQRCode\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TwoFAController extends Controller
{
    protected $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    /**
     * Show 2FA Setup Page
     */
    public function show2FASetup()
    {
        $user = Auth::user();

        // Generate a 2FA secret if the user doesn't have one
        if (!$user->google2fa_secret) {
            $user->generate2FASecret();
        }

        // Generate QR Code URL
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'), // Your application name
            $user->email,
            $user->google2fa_secret
        );

        // Generate QR Code Image using Simple-QrCode
        $qrCodeImage = QrCode::size(200)->generate($qrCodeUrl);

        return view('auth.2fa_setup', compact('qrCodeUrl', 'qrCodeImage', 'user'));
    }

    /**
     * Verify OTP after scanning the QR code
     */
    public function verify2FA(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);

        $user = Auth::user();

        // Verify the OTP entered by the user
        if ($this->google2fa->verifyKey($user->google2fa_secret, $request->code)) {
            session(['2fa_verified' => true]);

            return redirect()->route('dashboard')->with('success', '2FA Verification Successful!');
        }

        return back()->withErrors(['code' => 'Invalid OTP, please try again.']);
    }
}
