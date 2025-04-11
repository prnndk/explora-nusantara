<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    protected $casts = [
        'status'=> ProductStatus::class,
    ];

    public function seller(): BelongsTo{
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function file(): BelongsTo{
        return $this->belongsTo(File::class, 'foto_file_id','id');
    }
}
