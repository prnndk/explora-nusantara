<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    /** @use HasFactory<\Database\Factories\ContractFactory> */
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => ProductStatus::class,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id');
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}