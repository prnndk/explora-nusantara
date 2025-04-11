<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class File extends Model
{
    /** @use HasFactory<\Database\Factories\FileFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'uploaded_by',
        'name',
        'file_path',
        'file_type',
    ];

    public function sellerKtp(): HasOne
    {
        return $this->hasOne(Seller::class, 'ktp_file_id', 'id');
    }

    public function sellerPhoto(): HasOne
    {
        return $this->hasOne(Seller::class, 'photo_file_id', 'id');
    }

    public function sellerRecommendationLetter(): HasOne
    {
        return $this->hasOne(Seller::class, 'recommendation_letter_file_id', 'id');
    }

    public function buyerKtp(): HasOne
    {
        return $this->hasOne(Buyer::class, 'ktp_file_id', 'id');
    }

    public function buyerPhoto(): HasOne
    {
        return $this->hasOne(Buyer::class, 'photo_file_id', 'id');
    }

    public function buyerLegalityLetter(): HasOne
    {
        return $this->hasOne(Buyer::class, 'legality_letter_file_id', 'id');
    }

    public function product(): HasMany{
        return $this->hasMany(Product::class, 'foto_file_id', 'id');
    }
}
