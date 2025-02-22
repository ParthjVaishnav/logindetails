<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'google2fa_secret', 'google2fa_enabled'];

    public function generate2FASecret()
    {
        $google2fa = app('pragmarx.google2fa');
        $this->update([
            'google2fa_secret' => $google2fa->generateSecretKey(),
            'google2fa_enabled' => true, // Enable 2FA when generating secret
        ]);
    }
}
