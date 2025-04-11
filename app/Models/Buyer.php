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
        'bank_name',
        'bank_account_number',
        'legality_file_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function ktpFile()
    {
        return $this->belongsTo(File::class, 'ktp_file_id', 'id');
    }
    public function photoFile()
    {
        return $this->belongsTo(File::class, 'photo_file_id', 'id');
    }
    public function legalityFile()
    {
        return $this->belongsTo(File::class, 'legality_file_id', 'id');
    }
}
