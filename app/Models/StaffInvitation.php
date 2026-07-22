<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffInvitation extends Model
{
    protected $fillable = [
        'email', 'name', 'role', 'token_hash', 'expires_at', 'sent_at', 'accepted_at',
        'subject', 'custom_message', 'revoked_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'sent_at' => 'datetime',
        'accepted_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public function isUsable(): bool
    {
        return $this->accepted_at === null && $this->revoked_at === null && $this->expires_at->isFuture();
    }
}
