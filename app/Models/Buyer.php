<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    /** @use HasFactory<\Database\Factories\BuyerFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'nik',
        'email',
        'phone_number',
        'address',
        'photo_file_id',
        'ktp_file_id',
        'company_name',
        'company_address',
        'company_phone_number',
        'country',
        'bank',
        'bank_account_number',
        'legality_file_id',
        'user_id'
    ];
}
