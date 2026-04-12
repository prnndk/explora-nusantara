<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory, HasUuids;

    protected $guarded = ['id'];
    protected $casts = [
        'status' => TransactionStatus::class,
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function contract()
    {
        return $this->hasOne(Contract::class, 'transaction_id', 'id');
    }

    public function chat()
    {
        return $this->hasMany(TransactionChat::class, 'transaction_id', 'id');
    }

    public function getInvoiceCode()
    {
        $count = Transaction::where('created_at', '<=', $this->created_at)->count();
        $sequence = str_pad($count, 4, '0', STR_PAD_LEFT);

        $qtyValue = $this->kuantitas_pembelian ?? 0;
        $qty = str_pad($qtyValue, 4, '0', STR_PAD_LEFT);

        $month = strtoupper($this->created_at->format('M'));
        $year = $this->created_at->format('Y');

        return "{$sequence}/{$qty}/{$month}/{$year}";
    }
}
