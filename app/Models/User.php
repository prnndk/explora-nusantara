<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\RegisterStatus;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'register_status',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'register_status' => RegisterStatus::class,
            'role' => UserRole::class,
        ];
    }

    public function getUserCurrentRegisterStatus(): string
    {
        return $this->register_status->value;
    }

    public function getUserVerificationStatus(): bool
    {
        return $this->register_status !== RegisterStatus::WAITING;
    }

    public function isBuyer(): bool
    {
        return $this->role === UserRole::BUYER;
    }

    public function isSeller(): bool
    {
        return $this->role === UserRole::SELLER;
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    public function otp(): HasMany
    {
        return $this->hasMany(Otp::class, 'user_id', 'id');
    }

    public function seller(): HasOne
    {
        return $this->hasOne(Seller::class, 'user_id', 'id');
    }

    public function buyer(): HasOne
    {
        return $this->hasOne(Buyer::class, 'user_id', 'id');
    }

    public function chats(): HasMany
    {
        return $this->hasMany(TransactionChat::class, 'sender_id', 'id');
    }

    public function getUserUnreadChatsCount(): int
    {
        $chats = TransactionChat::where('sender_id', '!=', $this->id)
            ->whereIn('transaction_id', function ($query) {
                $query->select('id')
                    ->from('transactions')
                    ->when($this->isBuyer(), fn($query) => $query->where('buyer_id', $this->buyer?->id))
                    ->when($this->isSeller(), fn($query) => $query->where('seller_id', $this->seller?->id));
            })
            ->where('read_status', false)
            ->count();
        return $chats;
    }
}
