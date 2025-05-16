<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeMeeting extends Model
{
    /** @use HasFactory<\Database\Factories\TradeMeetingFactory> */
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => ProductStatus::class,
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
}
