<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $guarded = ['id'];

    public function isExpired(): bool
    {
        return $this->expired_at < now();
    }
}
