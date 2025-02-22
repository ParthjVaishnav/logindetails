<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'google2fa_secret'];

    public function generate2FASecret()
    {
        $this->google2fa_secret = app('pragmarx.google2fa')->generateSecretKey();
        $this->save();
    }
}
