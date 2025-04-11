<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seller extends Model
{
    /** @use HasFactory<\Database\Factories\SellerFactory> */
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function ktpFile(): BelongsTo
    {
        return $this->belongsTo(File::class, 'ktp_file_id', 'id');
    }

    public function photoFile(): BelongsTo
    {
        return $this->belongsTo(File::class, 'photo_file_id', 'id');
    }

    public function recommendationLetterFile(): BelongsTo
    {
        return $this->belongsTo(File::class, 'recommendation_letter_file_id', 'id');
    }

}
