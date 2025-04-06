<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationHistory extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'name',
        'action',
        'ip_address',
    ];
}
