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
    
        // Generate a new secret key each time
        $user->google2fa_secret = $this->google2fa->generateSecretKey();
        $user->save();
    
        // Generate a new QR code for the new secret
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
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

        if ($this->google2fa->verifyKey($user->google2fa_secret, $request->code)) {
            session(['2fa_verified' => true]);
            return redirect('/dashboard')->with('success', '2FA Verification Successful!');
        }

        return back()->withErrors(['code' => 'Invalid OTP, try again.']);
    }
}
