<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ip_address', 'device', 'browser', 'platform', 'device_info'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
