<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TransactionChat extends Model
{
    use HasUuids;

    protected $guarded = ['id'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}