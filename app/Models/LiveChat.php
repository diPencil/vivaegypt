<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LiveChat extends Model
{
    protected $fillable = ['user_id', 'status', 'unread_admin', 'unread_user'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'email', 'phone');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(LiveChatMessage::class, 'chat_id')->orderBy('created_at', 'asc');
    }

    public function lastMessage(): HasMany
    {
        return $this->hasMany(LiveChatMessage::class, 'chat_id')->latest()->limit(1);
    }
}
